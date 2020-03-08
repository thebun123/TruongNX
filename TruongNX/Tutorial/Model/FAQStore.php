<?php

namespace TruongNX\Tutorial\Model;
use TruongNX\Tutorial\Api\Data\FAQStoreInterface;

class FAQStore extends \Magento\Framework\Model\AbstractModel implements FAQStoreInterface
{
    const CACHE_TAG = 'faq_store';

    protected $_cacheTag = 'faq_store';

    protected $_eventPrefix = 'faq_store';

    protected function _construct()
    {
        $this->_init('TruongNX\Tutorial\Model\ResourceModel\FAQStore');
    }

    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->getData(self::ID);
    }

    public function setId($id)
    {
        // TODO: Implement setId() method.
        return $this->setData(self::ID, $id);
    }

    public function getFAQ_Id()
    {
        // TODO: Implement getFAQ_Id() method.
        return $this->getData(self::FAQ_ID);
    }

    public function setFAQ_Id($fId)
    {
        // TODO: Implement setFAQ_Id() method.
        return $this->setData(self::FAQ_ID, $fId);
    }

    public function getStore_Id()
    {
        // TODO: Implement getStore_Id() method.
        return $this->getData(self::STORE_ID);
    }

    public function setStore_Id($sId)
    {
        // TODO: Implement setStore_Id() method.
        return $this->setData(self::STORE_ID, $sId);
    }
}
