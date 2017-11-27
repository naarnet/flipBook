<?php

/**
 * MMDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDMMM
 * MDDDDDDDDDDDDDNNDDDDDDDDDDDDDDDDD=.DDDDDDDDDDDDDDDDDDDDDDDMM
 * MDDDDDDDDDDDD===8NDDDDDDDDDDDDDDD=.NDDDDDDDDDDDDDDDDDDDDDDMM
 * DDDDDDDDDN===+N====NDDDDDDDDDDDDD=.DDDDDDDDDDDDDDDDDDDDDDDDM
 * DDDDDDD$DN=8DDDDDD=~~~DDDDDDDDDND=.NDDDDDNDNDDDDDDDDDDDDDDDM
 * DDDDDDD+===NDDDDDDDDN~~N........8$........D ........DDDDDDDM
 * DDDDDDD+=D+===NDDDDDN~~N.?DDDDDDDDDDDDDD:.D .DDDDD .DDDDDDDN
 * DDDDDDD++DDDN===DDDDD~~N.?DDDDDDDDDDDDDD:.D .DDDDD .DDDDDDDD
 * DDDDDDD++DDDDD==DDDDN~~N.?DDDDDDDDDDDDDD:.D .DDDDD .DDDDDDDN
 * DDDDDDD++DDDDD==DDDDD~~N.... ...8$........D ........DDDDDDDM
 * DDDDDDD$===8DD==DD~~~~DDDDDDDDN.IDDDDDDDDDDDNDDDDDDNDDDDDDDM
 * NDDDDDDDDD===D====~NDDDDDD?DNNN.IDNODDDDDDDDN?DNNDDDDDDDDDDM
 * MDDDDDDDDDDDDD==8DDDDDDDDDDDDDN.IDDDNDDDDDDDDNDDNDDDDDDDDDMM
 * MDDDDDDDDDDDDDDDDDDDDDDDDDDDDDN.IDDDDDDDDDDDDDDDDDDDDDDDDDMM
 * MMDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDMMM
 *
 * @author Néstor Alain <alain@qbo.tech>
 * @category qbo
 * @package qbo\FlipBook\
 * @copyright qbo (http://www.qbo.tech)
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
 * © 2016 QBO DIGITAL SOLUTIONS. 
 *
 */

namespace Qbo\FlipBook\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;

class Data
{
    /**
     * @var Psr\Log\LoggerInterface
     */
    protected $_logger;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;
    
    /**
     * @var Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    
    /**
     * @var Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * 
     * @param CollectionFactory $productCollectionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        CollectionFactory $productCollectionFactory,
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager    
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_logger = $logger;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
    }
    
    /**
     * Get values from store config
     * @return string
     */
    public function getConfigValue($configPath)
    {
        $value = $this->_scopeConfig->getValue(
                $configPath, \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $value;
    }
    
    /**
     * 
     * @param type $attibuteToSet
     * @return collection of products
     */
    public function getCollectionByAttributeSet($attibuteToSet)
    {
        $attributeSetId = $this->getConfigValue($attibuteToSet);
        $collection = $this->_productCollectionFactory->create();
        $collection
                ->addAttributeToSelect('*')
                ->addFieldToFilter('attribute_set_id', $attributeSetId);
        return $collection;
    }
    
    /**
     * @param type int
     * @return collection of products by id
     */
    public function getPdfUrlById($product)
    {
        if ($product->getData('pdf_url')) {
            $pdfUrl = $product->getData('pdf_url');
            $currentStore = $this->_storeManager->getStore();
            $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $pdfUrl;
            return $mediaUrl;
        }
        return '';
    }

}
