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

namespace Qbo\FlipBook\Controller\Customer;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Qbo\FlipBook\Helper\Data as DataHelper;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\Customer;

class Message extends Action
{
    
    /**
     * @var Qbo\FlipBook\Helper\Data
     */
    protected $_dataHelper;
    
    /**
     *
     * @var Magento\Framework\View\Result\PageFactory 
     */
    protected $_resultPageFactory;
    
    /**
     * @var Magento\Customer\Model\Session 
     */
    protected $_customerSession;
    
    /**
     *
     * @var Magento\Customer\Model\Customer 
     */
    protected $_customer;


    /**
     * 
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CustomerSession $customerSession,
        DataHelper $dataHelper,
        Customer $customer    
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->_dataHelper = $dataHelper;
        $this->_customerSession = $customerSession;
        $this->_customer = $customer;

    }
    
    /**
     * 
     * @return type
     */
    public function execute()
    {
        $clienteData = [];
        $sendMessage = [];
        //Get parameters from request
        $params = $this->getRequest()->getParams();
        if (isset($params['recipients']) && isset($params['product-url'])) {
            //Get customer logging
            $customerId = $this->_customerSession->getCustomer()->getId();
            $customer = $this->_customer->load($customerId);
            //Getting params from array by post
            $clienteData['comment'] = $params['sender']['message'];
            $clienteData['prodUrl'] = $params['product-url'];
            $clienteData['prodId'] = $params['product-id'];
            $paramsName = $params['recipients']['name'];
            $paramsEmail = $params['recipients']['email'];
            //Initialize variable counter to count emails sent
            $sendMessage['sent_cont'] = 0;
            foreach ($paramsName as $index => $value) {
                $clienteData['name'] = $this->getClientDataEscaped($paramsName[$index]);
                $clienteData['email'] = $this->getClientDataEscaped($paramsEmail[$index]);
                //Send email 
                $statusMessage = $this->_dataHelper->sendEmail($clienteData, $customer);
                $sendMessage['sent_cont'] += (isset($statusMessage['sent_emails'])) ? 1 : 0;
                $sendMessage['failed_emails'] = (isset($statusMessage['failed_emails'])) ? $statusMessage['failed_emails'] : '';
            }
        }
        //Display message if email was sent
        $this->_dataHelper->displayMessage($sendMessage);
        return $this->_redirect('flipbook/customer/multimedia');
    }

    public function getClientDataEscaped($val)
    {   
        //Escaping values
        $values = (isset($val))? $this->_dataHelper->escapeHtml($val): '';
        return $values;
    }

}
