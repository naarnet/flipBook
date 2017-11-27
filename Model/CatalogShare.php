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

use Qbo\FlipBook\Api\Data\PostInterface;

class CatalogShare extends \Magento\Framework\Model\AbstractModel implements PostInterface, \Magento\Framework\DataObject\IdentityInterface
{

    const CACHE_TAG = 'catalog_share';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'catalog_share';
    protected $_coreRegistry;

    public function _construct()
    {
        $this->_init('Qbo\FlipBook\Model\ResourceModel\CatalogShare');
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        $this->getData(self::SHARE_ID);
    }

    /**
     * Get Catalog Id
     *
     * @return int|null
     */
    public function getCatalogId()
    {
        $this->getData(self::CATALOG_ID);
    }

    /**
     * Get Created At
     *
     * @return datetime|null
     */
    public function getCreatedAt()
    {
        $this->getData(self::CREATION_TIME);
    }

    /**
     * Get Customer Email
     *
     * @return string|null
     */
    public function getCustomerEmail()
    {
        $this->getData(self::CUSTOMER_EMAIL);
    }

    /**
     * Get Sender Email
     *
     * @return string|null
     */
    public function getSenderEmail()
    {
        $this->getData(self::SENDER_EMAIL);
    }

    /**
     * Set ID
     * @param int $id
     * @return \Qbo\FlipBook\Api\Data\PostInterface
     */
    public function setId($id)
    {
        return $this->setData(self::SHARE_ID, $id);
    }

    /**
     * Set catalog id
     * @param string $catalog_Id
     * @return \Qbo\FlipBook\Api\Data\PostInterface
     */
    public function setCatalogId($catalog_Id)
    {
        return $this->setData(self::CATALOG_ID, $catalog_Id);
    }

    /**
     * Set created at
     * @param string $creationTime
     * @return \Qbo\FlipBook\Api\Data\PostInterface
     */
    public function setCreatedAt($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set content
     * @param string $customer_email
     * @return \Qbo\FlipBook\Api\Data\PostInterface
     */
    public function setCustomerEmail($customer_email)
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customer_email);
    }

    /**
     * Set content
     * @param string $sender_email
     * @return \Qbo\FlipBook\Api\Data\PostInterface
     */
    public function setSenderEmail($sender_email)
    {
        return $this->setData(self::SENDER_EMAIL, $sender_email);
    }

}
