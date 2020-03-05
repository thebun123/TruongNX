<?php
namespace TruongNX\Tutorial\Model\Config\Source;

class ConfigNumFAQ implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return ['5'=>__('5'),
            '10'=>__('10'),
            '15'=>__('15'),
            '20'=>__('20'),];
    }
}
