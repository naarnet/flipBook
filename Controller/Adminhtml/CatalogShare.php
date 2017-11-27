<?php

/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/**
 *
 * Customer reports admin controller
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */

namespace Qbo\FlipBook\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Qbo\FlipBook\Model\CatalogShareFactory;

class CatalogShare extends Action
{

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $_fileFactory;
    
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
 
    /**
     * Result page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
 
    /**
     * News model factory
     *
     * @var \TQbo\FlipBook\Model\CatalogShareFactory
     */
    protected $_catalogShareFactory;
 
    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param CatalogShareFactory $catalogShareFactory
     */
    public function __construct(
        Context $context,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        CatalogShareFactory $catalogShareFactory
    ) {
       parent::__construct($context,$coreRegistry);
        $this->_fileFactory = $fileFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_catalogShareFactory = $catalogShareFactory;
    }

    /**
     * Add reports and customer breadcrumbs
     *
     * @return $this
     */
    public function _initAction()
    {
        $act = $this->getRequest()->getActionName();
        if (!$act) {
            $act = 'default';
        }

        $this->_view->loadLayout();
        $this->_addBreadcrumb(__('Reports'), __('Reports'));
        $this->_addBreadcrumb(__('Customers'), __('Customers'));
        return $this;
    }

    /**
     * News access rights checking
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Qbo_FlipBook::adminhtml_catalog_share');
    }

    public function execute()
    {
        return $this->_resultPageFactory->create();
    }

}
