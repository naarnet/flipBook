<?php

namespace Qbo\FlipBook\Block\Adminhtml\Catalog;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget;
use Qbo\FlipBook\Model\CatalogShare;

class Share extends Widget
{

    /**
     * @var \Qbo\FlipBook\Model\CatalogShare
     */
    protected $_catalogShare;

    public function __construct(
        CatalogShare $catalogShare,
        Context $context,
        array $data = array()
    ) {
        $this->_catalogShare = $catalogShare;
        parent::__construct($context, $data);
    }

    /**
     * Get Number of shared catalogs
     * 
     * @return string
     */
    public function getCountCatalog()
    {
        $catalogCollection = $this->_catalogShare->getCollection();
        $countCatalogShare = count($catalogCollection);
        return $countCatalogShare;
    }
}
