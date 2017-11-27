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

namespace Qbo\FlipBook\Controller\Product;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Psr\Log\LoggerInterface;
use Qbo\FlipBook\Helper\Data as DataHelper;


class Pdf extends Action
{
    /**
     * Constant to get group id by admin configuration
     */
    const XML_PATH_ID_CUSTOMER_GROUP = 'flipbook/flipbookconfig/customergroup';
    
    /**
     * @var Magento\Framework\App\Config\ScopeConfigInterface 
     */
    protected $_scopeConfig;
    
    /**
     * @var Magento\Store\Model\StoreManagerInterface 
     */
    protected $_storeManagerInterFace;
    
    /**
     *
     * @var Psr\Log\LoggerInterface 
     */
    protected $_logger;
    
    /**
     *
     * @var Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var Magento\Framework\View\Result\PageFactory 
     */
    protected $_pageFactory;
    
    /**
     * @var Magento\Framework\Message\ManagerInterface 
     */
    protected $_messageManager;
    
    /**
     * @var Magento\Catalog\Model\Product 
     */
    protected $_product;
    
    /**
     * @var Qbo\FlipBook\Helper\Data
     */
    protected $_dataHelper;

    /**
     * 
     * @param Context $context
     * @param StoreManagerInterface $storeManagerInterFace
     * @param LoggerInterface $logger
     * @param Session $customerSession
     * @param ManagerInterface $managerMessage
     * @param PageFactory $pageFactory
     * @param Product $product
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManagerInterFace,
        LoggerInterface $logger,
        Session $customerSession,
        ManagerInterface $managerMessage,    
        PageFactory $pageFactory,
        Product $product,
        DataHelper $dataHelper,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->_storeManagerInterFace = $storeManagerInterFace;
        $this->_customerSession = $customerSession;
        $this->_pageFactory = $pageFactory;
        $this->_logger = $logger;
        $this->_messageManager = $managerMessage;
        $this->_product = $product;
        $this->_scopeConfig = $scopeConfig;
        $this->_dataHelper = $dataHelper;

    }
    
    public function execute()
    {
        $exitsCatalogShare = false;
        $productId = $this->getRequest()->getParam('productId');
        $sendByEmail = $this->getRequest()->getParam('sendByEmail');
        $resultRedirect = $this->resultRedirectFactory->create();
        if (isset($sendByEmail)) {
            //Check if exist collection of catalog product share
            $exitsCatalogShare = $this->isExistCollection(
                                    $productId,
                                    $this->getRequest()->getParam('sender_email'),
                                    $this->getRequest()->getParam('email')
                                );
        }
        //Checking if exist productId
        if (!$productId) {
            //Redirect to customer account
            $resultRedirect->setPath('customer/account');
            $this->_messageManager->addError(__('An error ocurred'));
        }
        //Loading product to get Url
        $product = $this->_product->load($productId);
        //Check if exit product 
        if (!$product || !$product->getId()) {
            $resultRedirect->setPath('customer/account');
            $this->_messageManager->addError(__('Resource does not exist'));
        }
        //Convert string of id from customer group to array
        $customerGroupValues = explode(',', $this->getConfigValue(self::XML_PATH_ID_CUSTOMER_GROUP));
        //Checking if customer is loggin and check if this customer group can access to routes
        if (($this->_customerSession->isLoggedIn() && in_array($this->_customerSession->getCustomer()->getGroupId(), $customerGroupValues)) || $exitsCatalogShare) {
            //Getting Url from pdf
            $urlpdf = $this->_storeManagerInterFace
                           ->getStore()
                           ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
                           ."wysiwyg/pdf/" . $product->getPdfUrl();
            $result = $this->_pageFactory->create();
            //Setting url of pdf to block
            $result->getLayout()
                   ->getBlock('pdf')
                   ->setPdfUrl($urlpdf);
            return $result;
        } else {
            //Rediret to customer account
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('customer/account');
            $this->_messageManager->addError(__('You\'re not authorized to access this resoure'));
            return $resultRedirect;
        }
    }
    
    public function isExistCollection($productId, $senderEmail, $emal)
    {
        //Filter collection from catalog product share model
        $collectionShare = $this->_dataHelper->getCatalogShareCollection()
                ->addFieldToFilter('catalog_id', $productId)
                ->addFieldToFilter('sender_email', $senderEmail)
                ->addFieldToFilter('customer_email', $emal);
        if ($collectionShare) {
            return true;
        }
        return false;
    }

    /**
     * Get store config
     * @return string
     */
    public function getConfigValue($configPath)
    {
        $value = $this->_scopeConfig->getValue(
                $configPath, \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $value;
    }
}
