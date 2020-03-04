<?php

namespace TruongNX\Tutorial\Model;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    public function getOptionArray()
    {
        return ['1'=>__('Enable'), '0'=>__('Disable')];
    }

    public function getAllOptions()
    {
        $res = $this->getOptionArray();
        array_unshift($res, ['values'=>'', 'label'=>'']);
        return $res;
    }

    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value'=>$index, 'label'=> $value];
        }
        return $res;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
