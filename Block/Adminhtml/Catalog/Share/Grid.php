<?php

namespace Qbo\FlipBook\Block\Adminhtml\Catalog\Share;

use Magento\Backend\Block\Widget\Grid as WidgetGrid;

class Grid extends WidgetGrid
{
    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Backend\Helper\Data $backendHelper, array $data = array())
    {
         die('llegando');
        parent::__construct($context, $backendHelper, $data);
    }
}
