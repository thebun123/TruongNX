<?php

namespace TruongNX\Tutorial\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_TUTORIAL = 'truongnx/';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getGeneralConfig($code, $type, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_TUTORIAL . $type . '/general/' . $code, $storeId);
    }
}
