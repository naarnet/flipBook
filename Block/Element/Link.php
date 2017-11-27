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

namespace Qbo\FlipBook\Block\Element;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Link extends \Magento\Framework\View\Element\Html\Link\Current
{
    /**
     * @var Magento\Customer\Model\Session 
     */
    protected $_customerSession;
    
    /**
     *
     * @var Magento\Framework\App\Config\ScopeConfigInterface 
     */
    protected $_scopeConfig;
        
    /**
     * Const to get customer group
     */
    const XML_PATH_ID_CUSTOMER_GROUP = 'flipbook/flipbookconfig/customergroup';

    /**
     * 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\DefaultPathInterface $defaultPath
     * @param Session $customerSession
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
            \Magento\Framework\View\Element\Template\Context $context, 
            \Magento\Framework\App\DefaultPathInterface $defaultPath, 
            Session $customerSession,
            ScopeConfigInterface $scopeConfig,
            array $data = array())
    {
        $this->_customerSession = $customerSession;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context, $defaultPath, $data);
    }

    /**
     * Check if user belongs to group
     * @return boolean
     */
    public function isAllowed()
    {
        $customerGroupValues = explode(',', $this->getConfigValue(self::XML_PATH_ID_CUSTOMER_GROUP));
        if(in_array($this->_customerSession->getCustomer()->getGroupId(), $customerGroupValues)){
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
    
    /**
     * Render block HTML
     * @return string
     */
    protected function _toHtml()
    {  
        if (false != $this->getTemplate()) {
            return parent::_toHtml();
        }

        $highlight = '';

        if ($this->getIsHighlighted()) {
            $highlight = ' current';
        }

        if ($this->isCurrent()) {
            $html = '<li class="nav item current b2b">';
            $html .= '<strong>'
                . $this->escapeHtml((string)new \Magento\Framework\Phrase($this->getLabel()))
                . '</strong>';
            $html .= '</li>';
        } else {
            $html = '<li class="nav item b2b' . $highlight . '"><a href="' . $this->escapeHtml($this->getHref()) . '"';
            $html .= $this->getTitle()
                ? ' title="' . $this->escapeHtml((string)new \Magento\Framework\Phrase($this->getTitle())) . '"'
                : '';
            $html .= $this->getAttributesHtml() . '>';

            if ($this->getIsHighlighted()) {
                $html .= '<strong>';
            }

            $html .= $this->escapeHtml((string)new \Magento\Framework\Phrase($this->getLabel()));

            if ($this->getIsHighlighted()) {
                $html .= '</strong>';
            }

            $html .= '</a></li>';
        }

        return $html;
    }

}
