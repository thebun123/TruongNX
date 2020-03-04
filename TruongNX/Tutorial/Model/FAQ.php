<?php

namespace TruongNX\Tutorial\Model;

use TruongNX\Tutorial\Api\Data\FAQInterface;

class FAQ extends \Magento\Framework\Model\AbstractModel implements FAQInterface
{
    const CACHE_TAG = 'faq_table';

    protected $_cacheTag = 'faq_table';

    protected $_eventPrefix = 'faq_table';

    protected function _construct()
    {
        $this->_init('TruongNX\Tutorial\Model\ResourceModel\FAQ');
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    public function getDes()
    {
        return $this->getData(self::DESCRIPTION);
    }

    public function setDes($des)
    {
        return $this->setData(self::DESCRIPTION, $des);
    }

    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    public function getStatus()
    {
        return $this->getData();
    }
    public function setStatus($status)
    {
        return $this->setDate(self::STATUS, $status);
    }

    public function getCreateTime()
    {
        return $this->getData(self::CREATE_TIME);
    }
    public function setCreateTime($time)
    {
        return $this->setData(self::CREATE_TIME, $time);
    }

    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    public function setUpdateTime($time)
    {
        return $this->setData(self::UPDATE_TIME, $time);
    }
}
