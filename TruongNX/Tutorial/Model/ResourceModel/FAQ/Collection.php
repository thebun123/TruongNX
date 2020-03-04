<?php

namespace TruongNX\Tutorial\Model\ResourceModel\FAQ;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    // protected $_eventPrefix = 'truongnx_tutorial_faq_collection';
    // protected $_eventObject = 'faq_collection';

    protected function _construct()
    {
        $this->_init(
            'TruongNX\Tutorial\Model\FAQ',
            'TruongNX\Tutorial\Model\ResourceModel\FAQ'
        );
    }
}
