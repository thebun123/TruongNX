<?php

namespace TruongNX\Tutorial\Model\Config\Source;

/**
 * @api
 * @since 100.0.2
 */
class Store implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */

    public function toOptionArray()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface');

        $storeManagerDataList = $storeManager->getStores();
        $options = [];

        foreach ($storeManagerDataList as $key => $value) {
            $options[] = ['label' => $value['name'],  'value' => $key ];
        }
        return $options;
    }
}
