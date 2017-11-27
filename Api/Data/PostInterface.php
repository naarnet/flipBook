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
 * @author Néstor Alain<alain@qbo.tech>
 * @category qbo
 * @package qbo\FlipBook\
 * 
 * © 2016 QBO DIGITAL SOLUTIONS. 
 *
 */

namespace Qbo\FlipBook\Api\Data;

interface PostInterface
{

    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const SHARE_ID = 'id';
    const CATALOG_ID = 'catalog_id';
    const SENDER_EMAIL = 'sender_email';
    const CUSTOMER_EMAIL = 'customer_email';
    const CREATION_TIME = 'created_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Sender Email
     *
     * @return string|null
     */
    public function getCatalogId();

    /**
     * Get Sender Email
     *
     * @return string|null
     */
    public function getSenderEmail();

    /**
     * Get Customer Email
     *
     * @return string|null
     */
    public function getCustomerEmail();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Qbo\FlipBook\Api\Data\PostInterface
     */
    public function setId($id);

    /**
     * Set Catalog Id
     *
     * @param string $catalog_Id
     * @return \Qbo\FlipBook\Api\Data\PostInterface
     */
    public function setCatalogId($catalog_Id);

    /**
     * Set Sender Email
     *
     * @param string $sender_email
     * @return \Qbo\FlipBook\Api\Data\PostInterface
     */
    public function setSenderEmail($sender_email);

    /**
     * Set customer email
     *
     * @param string $customer_email
     * @return \Qbo\FlipBook\Api\Data\PostInterface
     */
    public function setCustomerEmail($customer_email);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return \Qbo\FlipBook\Api\Data\PostInterface
     */
    public function setCreatedAt($creationTime);
}
