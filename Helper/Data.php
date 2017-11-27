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

namespace Qbo\FlipBook\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\Context;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;
use Qbo\FlipBook\Model\CatalogShare;
use Qbo\FlipBook\Model\CatalogShareFactory;


class Data extends AbstractHelper
{

    /**
     * Config Values Templates email
     */
    const XML_PATH_SUPORT_EMAIL = 'flipbook/flipbookconfig/email_template';
    
    /**
     * XML_PATH_SUPORT_EMAILCC
     */
    const XML_PATH_SUPORT_EMAILCC = 'flipbook/flipbookconfig/senderemailcc';
    
    /**
     * Magento\Framework\Escaper
     */
    protected $_escaper;
    
    /**
     * @var Psr\Log\LoggerInterface
     */
    protected $_logger;
    
    /**
     * @var Magento\Framework\Mail\Template\TransportBuilder 
     */
    protected $_transportBuilder;
    
    /**
     * @var Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    
    /**
     * @var Magento\Framework\Message\ManagerInterface
     */
    protected $_messageManager;
    
    /**
     *
     * @var Magento\Framework\UrlInterface 
     */
    protected $_storeUrl;
    
    /**
     * @var Qbo\FlipBook\Model\CatalogShare
     */
    protected  $_catalogShare;
    
    /**
     * @var Qbo\FlipBook\Model\CatalogShareFactory
     */
    protected  $_catalogShareFactory;

    /**
     * 
     * @param Context $context
     * @param TransportBuilder $transportBuilder
     * @param LoggerInterface $logger
     * @param ScopeConfigInterface $scopeConfig
     * @param ManagerInterface $managerMessage
     * @param Escaper $escaper
     */
    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder, 
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig,
        ManagerInterface $managerMessage,
        UrlInterface $storeUrl,
        CatalogShare $catalogShare,
        CatalogShareFactory $catalogShareFactory,
        Escaper $escaper    
    ) {
        parent::__construct($context);
        $this->_escaper = $escaper;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_messageManager = $managerMessage;
        $this->_storeUrl = $storeUrl;
        $this->_catalogShare = $catalogShare;
        $this->_catalogShareFactory = $catalogShareFactory;
        $this->_logger = $logger;
    }
    
    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->_logger;
    }

    /**
     * 
     * @param array $templateVars
     * @param string $senderInfo
     * @param string $suportEmailto
     * @param string $suportEmailcc
     * @param string $suportEmail
     */
    public function sendEmail($response, $customer)
    {
        $status = [];
        $storeurl = $this->_storeUrl->getUrl('flipbook/product/pdf');
        //Templates var to send email
        $templateVars = array(
            'name' => $response['name'],
            'email' => $response['email'],
            'customerEmail' => $customer->getEmail(),
            'prodId' => $response['prodId'],
            'comment' => $response['comment'],
            'url' => $storeurl
        );
        //Parameters to send emails
        $suportEmailto = $response['email'];
        $suportEmailcc = $this->getConfigValue(self::XML_PATH_SUPORT_EMAILCC);
        $suportEmail = $this->getConfigValue(self::XML_PATH_SUPORT_EMAIL);
        $senderInfo = ['name' => 'Administrador', 'email' => $suportEmailcc];
        try
        {
            $transport = $this->_transportBuilder->setTemplateIdentifier($suportEmail)
                    ->setTemplateOptions([
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ])
                    ->setTemplateVars($templateVars)
                    ->setFrom($senderInfo)
                    ->addTo($suportEmailto)
                    ->getTransport();
            $transport->sendMessage();
            $status['sent_emails'] = 1;
            //Saving values on catalog product share table
            $this->saveReport($response['prodId'],$customer->getEmail(),$response['email']);
        } catch (\Exception $ex)
        {
            //If there is error on send email
            $status['failed_emails']= $response['email'];
            $this->_logger->debug($ex->getMessage());
        }
        return $status;
    }
    
    /**
     * @param $field
     * @return $field
     */
    public function escapeHtml($field)
    {
        return $this->_escaper->escapeHtml($field);
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
     * Display message on store front
     * @param type $sendMessage
     */
    public function displayMessage($sendMessage)
    {
        //Check variable to display error or success message
        if (isset($sendMessage['sent_cont']) &&  $sendMessage['sent_cont'] > 0) {
            $this->_messageManager->addSuccess(__(sprintf('%s sent successfully.', $sendMessage['sent_cont'])));
        } else if (isset($sendMessage['failed_emails']) && $sendMessage['failed_emails']) {
            $emails_failed = '';
            foreach($sendMessage['failed_emails'] as $email){
                $emails_failed .= $email.' ,';
            }
            $this->_messageManager->addError(__(sprintf('The following emails did not receive the shared catalog %s.',$emails_failed)));
        }
    }
    
    public function saveReport($productId, $sender_email, $email)
    {
        //Saving report data
        $datetime = date("Y-m-d H:i:s");
        $catalogShare = $this->_catalogShareFactory->create();
        try
        {
            $catalogShare->setCatalogId($productId);
            $catalogShare->setSenderEmail($sender_email);
            $catalogShare->setCustomerEmail($email);
            $catalogShare->setCreatedAt($datetime);
            $catalogShare->save();
        } catch (Exception $ex)
        {
            $this->_logger->debug($ex->getMessage());
        }
    }
    
    public function getCatalogShareCollection()
    {
        //return collection of model catalog share 
        $catalogShare = $this->_catalogShareFactory->create();
        return $catalogShare->getCollection();
    }

}
