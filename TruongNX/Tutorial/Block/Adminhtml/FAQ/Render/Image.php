<?php
namespace TruongNX\Tutorial\Block\Adminhtml\FAQ\Render;

class TruongNX_Tutorial_Block_Adminhtml_FAQ_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $html = '<img id="' . $this->getColumn()->getId() . '" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $row->getData($this->getColumn()->getIndex()) . '"';
        $html .= '/>';
        return $html;
    }
}
