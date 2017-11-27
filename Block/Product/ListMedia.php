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
 * @package qbo\Training\
 * @copyright qbo (http://www.qbo.tech)
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
 * © 2016 QBO DIGITAL SOLUTIONS. 
 *
 */

namespace Qbo\FlipBook\Block\Product;

use Magento\Catalog\Block\Product\Context;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Url\Helper\Data;
use Qbo\FlipBook\Model\Data as DataModel;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Model\Product\Gallery\ReadHandler as GalleryReadHandler;

class ListMedia extends \Magento\Catalog\Block\Product\ListProduct
{
    
    /**
     * Constant var from store config 'Attribute Set'
     */
    const XML_PATH_ATTRIBUTE_SET = 'flipbook/flipbookconfig/flipbookattrset';
    /**
     * @var Psr\Log\LoggerInterface
     */
    protected $_logger;
    
    /**
     * @var Qbo\FlipBook\Model\Data
     */
    protected $_dataModel;
    
    /**
     * @var Magento\Catalog\Model\Product\Gallery\ReadHandler
     */
    protected $_galleryReadHandler;
        
    public function __construct(
        Context $context,
        PostHelper $postDataHelper, 
        Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        Data $urlHelper,
        DataModel $datamodel,    
        LoggerInterface $logger,
        GalleryReadHandler  $galleryReadHandler,  
        array $data = array()
    ) {
        parent::__construct(
                $context,
                $postDataHelper,
                $layerResolver,
                $categoryRepository,
                $urlHelper,
                $data
            );
        $this->_dataModel = $datamodel;
        $this->_logger = $logger;
        $this->_galleryReadHandler = $galleryReadHandler;
    }
    
    /**
     * Getting product collection by attribute set
     * @return collection
     */
    public function getProductMediaCollection(){
        //Return collection by attribute set
        return $this->_dataModel->getCollectionByAttributeSet(self::XML_PATH_ATTRIBUTE_SET);
    }
    
    /**
     * 
     * @param type $_product
     * @return string
     */
    public function getVideoUrl($_product){
        $urlvideoEmbed = null;
        //Loading Media Gallery from Product
        $this->addGallery($_product);
        $videoUrl = '';
        foreach ($_product->getMediaGallery() as $mediaGalleryImage) {
            foreach($mediaGalleryImage as $gallery){
                //Getting Youtube Url from Product
                $videoUrl = $gallery['video_url'];
            }
        }
        if ($this->getVideoIdToEmbed($videoUrl)) {
            $urlvideoEmbed = 'https://www.youtube.com/embed/' . $this->getVideoIdToEmbed($videoUrl);
        }
        //Concat Url with id of video from product
        return $urlvideoEmbed;
    }
    
    /**
     * 
     * @param string $url
     * @return id
     */
    public function getVideoIdToEmbed($url)
    {
        preg_match(
                '/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches
        );
        //return Id of video from youtube
        return (isset($matches[1]))? $matches[1]: '';
    }
    
    /** 
     * Add image gallery to $product
     */
    public function addGallery($product)
    {
        //Loading Product Image Gallery
        $this->_galleryReadHandler->execute($product);
    }
    
    /**
     * 
     * @param type $product
     * @return type
     */
    public function getPdfUrl($product){
        //return product pdf url
        return $this->_dataModel->getPdfUrlById($product);
    }
    
}
