<?php

namespace TruongNX\Tutorial\Observer;

use TruongNX\Tutorial\Model\FAQFactory;

class ModifiedDB implements \Magento\Framework\Event\ObserverInterface
{
    protected $faqFactory;
    protected $log;

    public function __construct(FAQFactory $faqFactory, \TruongNX\Tutorial\Logger\Logger $log)
    {
        $this->faqFactory = $faqFactory;
        $this->log = $log;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $title = $observer->getData('title');
        $this->log->info('title: ' . json_encode($title[0]));
        $id = $observer->getData('id');
        $this->log->info('id: ' . $id[0]);
        $faq = $this->faqFactory->create();
        $faq->setId($id[0]);
        $faq->setObs($title[0]);
        $faq->save();

        return $this;
    }
}
