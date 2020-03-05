<?php
namespace TruongNX\Tutorial\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use TruongNX\Tutorial\Model\ResourceModel\Faq\CollectionFactory;

/**
 * Class MassDisable
 */
class MassStatus extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    protected $log;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        \TruongNX\Tutorial\Logger\Logger $logger,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->log = $logger;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $total = 0;
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        foreach ($collection as $item) {
//            $this->log->info($item->toJson());
            if ($item['status'] == '0') {
                $item['status'] = '1';
                $total += 1;
                $item->save();
            }
//            $item->setStatus('Enable')->save();
        }
//        $this->messageManager->addSuccess(__('A total of %1 record(s) have been modified.', $collection->getSize()));
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been modified.', $total));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }

    /**
     * Check Category Map recode delete Permission.
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('TruongNX_Tutorial::row_data_status');
    }
}
