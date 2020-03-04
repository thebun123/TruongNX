<?php

namespace TruongNX\Tutorial\Block;

use Magento\Framework\View\Element\Template\Context;
use TruongNX\Tutorial\Model\FAQFactory;

/**
 * Test List block
 */
class Index extends \Magento\Framework\View\Element\Template
{
    protected $_faqFactory;

    public function __construct(
        Context $context,
        FAQFactory $faqFactory
    ) {
        $this->_faqFactory = $faqFactory;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('TABLE '));

        if ($this->getFAQCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'tutorial.faq.pager'
            )->setAvailableLimit([5=>5,10=>10,15=>15])->setShowPerPage(true)->setCollection(
                $this->getFAQCollection()
            );
            $this->setChild('pager', $pager);
            $this->getFAQCollection()->load();
        }
        return parent::_prepareLayout();
    }

    public function getFAQCollection()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;

        $faq = $this->_faqFactory->create();
        $collection = $faq->getCollection();
        $collection->addFieldToFilter('Status','1'); // if you want to use filter
        //$collection->setOrder('test_id','ASC'); // if you want to set collection order
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);

        return $collection;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
