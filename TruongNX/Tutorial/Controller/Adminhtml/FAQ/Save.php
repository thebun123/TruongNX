<?php
namespace TruongNX\Tutorial\Controller\Adminhtml\FAQ;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \TruongNX\Tutorial\Model\FAQFactory
     */
    public $faqFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \TruongNX\Tutorial\Model\FAQFactory $faqFactory
     */
    public function __construct(
//        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Backend\App\Action\Context $context,
        \TruongNX\Tutorial\Model\FAQFactory $faqFactory
    ) {
//        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->faqFactory = $faqFactory;
        parent::__construct($context);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
            $data = $this->getRequest()->getPostValue();
            if (!$data) {
                $this->_redirect('tutorial/faq/addrow');
                return;
            }
            try {
                $rowData = $this->faqFactory->create();
                $rowData->setData($data);
                if (isset($data['id'])) {
                    $rowData->setEntityId($data['id']);
                }
                $rowData->save();
                $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
            } catch (\Exception $e) {
                $this->messageManager->addError(__($e->getMessage()));
            }

        $this->_redirect('tutorial/faq/index');
    }

//    public function execute()
//    {
//        $isPost = $this->getRequest()->getPost();
//        $resultRedirect = $this->resultRedirectFactory->create();
//        if ($isPost) {
//            $model = $this->faqFactory->create();
//            $postId = $this->getRequest()->getParam('id');
//
//            if ($postId) {
//                $model->load($postId);
//            }
//            $mImage = $this->getRequest()->getFiles('image');
//            $fileName = ($mImage && array_key_exists('name', $mImage)) ?
//                $mImage['name'] : null;
//            if ($mImage && $fileName) {
//                try {
//                    $uploader = $this->_objectManager->create(
//                        'Magento\MediaStorage\Model\File\Uploader',
//                        ['fileId' =>'image']
//                    );
//                    $uploader->setAllowExtendsions('jpg', 'jpeg', 'png');
//                    /** @var \Magento\Framework\Image\Adapter\AdapterInterface
//                    $imageAdapterFactory */
//                    $imageAdapterFactory = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
//                    $uploader->setAllowRenameFiles(true);
//                    $uploader->setFilesDispersion(true);
//                    $uploader->setAllowCreateFolders(true);
//                    /** @var \Magento\Framework\Filesystem\Directory\Read
//                    $mediaDirectory */
//                    $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
//                        ->getDirectoryRead(DirectoryList::MEDIA);
//                    $result = $uploader->save($mediaDirectory)->getAbsolutePath('Tutorial/Image');
//                    $model->setImage('Tutorial/Image' . $result['file']);
//                } catch (\Exception $e) {
//                    if ($e->getCode() == 0) {
//                        $this->messageManager->addError($e->getMessage());
//                    }
//                }
//            }
//            $rowData = $this->getRequest()->getParam('label');
//            $model->setDate($rowData);
//            try{
//                $model->save();
//                $this->messageManager->addSuccess(__('The FAQ has been saved.'));
//
//                if ($this->getRequest()->getParam('back')) {
//                    $this->_redirect('tutorial/faq/addrow', ['id' => $model->getId(),
//                        '_current' => true]);
//                    return;
//                }
//                $this->_redirect('*/*/');
//                return;
//            } catch (\Exception $e) {
//                $this->messageManager->addError($e->getMessage());
//            }
//
//            $this->_getSession()->setFormData($rowData);
//            $this->_redirect('tutorial/faq/index', ['id' => $postId]);
//        }
//    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('TruongNX_FAQ::save');
    }
}
