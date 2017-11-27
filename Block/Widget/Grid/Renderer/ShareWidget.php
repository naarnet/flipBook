<?php

namespace Qbo\FlipBook\Block\Widget\Grid\Renderer;

use Magento\Backend\Block\Widget;
use Qbo\FlipBook\Model\CatalogShare;
use Magento\Backend\Block\Template\Context;

class ShareWidget extends Widget
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
}
