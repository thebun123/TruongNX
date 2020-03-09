<?php
namespace TruongNX\Tutorial\Controller\Adminhtml\Faq;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\Read;
use Magento\MediaStorage\Model\File\Uploader;
use TruongNX\Tutorial\Logger\Logger;
use TruongNX\Tutorial\Model\FAQFactory;
use TruongNX\Tutorial\Model\FAQStoreFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var FAQFactory
     */
    public $faqFactory;
    public $faqStoreFactory;

    protected $uploaderFactory;
    protected $log;

    /**
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory
     * @param \Magento\Backend\App\Action\Context $context
     * @param FAQFactory $faqFactory
     * @param FAQStoreFactory $faqStoreFactory
     * @param FAQFactory $faqFactory
     * //     * * @param Logger $log
     */
    public function __construct(
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Backend\App\Action\Context $context,
        FAQFactory $faqFactory,
        FAQStoreFactory $faqStoreFactory,
        Logger $log
    ) {
        parent::__construct($context);
        $this->faqFactory = $faqFactory;
        $this->faqStoreFactory = $faqStoreFactory;
        $this->log=$log;
        $this->uploaderFactory = $uploaderFactory;
    }

    public function execute()
    {
        $obs_title = [];
//        $data = $this->getRequest()->getPostValue();
        $data = $this->getRequest()->getPostValue();
        $this->log->info('data: ' . json_encode($data));
        if (!$data) {
            $this->_redirect('grid/grid/addrow');
            return;
        }
        try {
            $obs_title[0] = 'install';
            $faqData = $this->faqFactory->create();
            $faqStoreData = $this->faqStoreFactory->create();
//           set data for faq_table
            $faqData->setData('title', $data['title']);
            $faqData->setData('description', $data['description']);
            $faqData->setData('status', $data['status']);
            $store_id = $data['store_id'];
//

            // edit row
            if (isset($data['id'])) {
                $obs_title[0] = 'edit';
                $faqData->setId($data['id']);
//                $this->log->info('faq data: ' . json_encode($faqData->getData()));
                $collection = $this->_objectManager->create('\TruongNX\Tutorial\Model\ResourceModel\FaqStore\Collection');
                $collection->addFieldToFilter('faq_id', ['eq'=>$faqData['faq_id']]);
//                $this->log->info('filter data: ' . json_encode($data));
                $row = $collection->getData()[0];
                $this->log->info('store data: ' . json_encode($row));
                $this->log->info('row data: ' . $row['id']);
                $faqStoreData->setId($row['id']);
            }

            $faqData->save();
            $faq_id = $faqData['faq_id'];

            //            setdata for faq_store

            $faqStoreData->setFAQ_Id($faqData->getData('faq_id'));
            $faqStoreData->setStore_Id($store_id);
            $faqStoreData->save();


            // event
            $this->_eventManager->dispatch('truongnx_tutorial_modified_db', ['title'=>$obs_title, 'id'=>$faq_id]);


            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));

        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('tutorial/faq/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('TruongNX_FAQ::save');
    }
}
