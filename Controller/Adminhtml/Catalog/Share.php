<?php

/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Qbo\FlipBook\Controller\Adminhtml\Catalog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Share extends Action
{

    /**
     * 
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Initi function
     * @param Context     $context           
     * @param PageFactory $resultPageFactory 
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Principal route action
     * @return PageFactory 
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Qbo_FlipBook::adminhtml_catalog_share');
        $resultPage->addBreadcrumb(__('Catalog Share Report'), __('Catalog Share Report'));
        $resultPage->addBreadcrumb(__('Catalog Share Report'), __('Catalog Share Report'));
        $resultPage->getConfig()->getTitle()->prepend(__('Catalog Share Report'));

        return $resultPage;
    }

    /**
     * Check if this route is allowed by this user
     * @return boolean [description]
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Qbo_Survey::adminhtml_catalog_share');
    }

}
