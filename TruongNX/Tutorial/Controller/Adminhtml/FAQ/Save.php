<?php
namespace TruongNX\Tutorial\Controller\Adminhtml\Faq;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \TruongNX\Tutorial\Model\FAQFactory
     */
    var $faqFactory;

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

        parent::__construct($context);
        $this->faqFactory = $faqFactory;
    }

//    /**
//     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
//     * @SuppressWarnings(PHPMD.NPathComplexity)
//     */
//    public function execute()
//    {
//        $data = $this->getRequest()->getPostValue();
//        if (!$data) {
//            $this->_redirect('tutorial/faq/addrow');
//            return;
//        }
//        try {
//            $rowData = $this->faqFactory->create();
//            $rowData->setData($data);
//            if (isset($data['id'])) {
//                $rowData->setEntityId($data['id']);
//            }
//            $rowData->save();
//            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
//        } catch (\Exception $e) {
//            $this->messageManager->addError(__($e->getMessage()));
//        }
//
//        $this->_redirect('tutorial/faq/index');
//    }

    public function execute()
    {
        $isPost = $this->getRequest()->getPost();
        if ($isPost) {
            $model = $this->faqFactory->create();
            $postId = $this->getRequest()->getParam('id');

            if ($postId) {
                $model->load($postId);
            }
            $imagePost = $this->getRequest()->getFiles('image');
            $fileName = ($imagePost && array_key_exists('name', $imagePost)) ?
                $imagePost['name'] : null;
            if ($imagePost && $fileName) {
                try {
                    $uploader = $this->_objectManager->create(
                        'Magento\MediaStorage\Model\File\Uploader',
                        ['fileId' =>'image']
                    );
                    $uploader->setAllowedExtensions('jpg', 'jpeg', 'png');
//                    /** @var \Magento\Framework\Image\Adapter\AdapterInterface
//                    $imageAdapterFactory */
//                    $imageAdapterFactory = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);
                    $uploader->setAllowCreateFolders(true);
                    /** @var \Magento\Framework\Filesystem\Directory\Read
                    $mediaDirectory */
                    $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                        ->getDirectoryRead(DirectoryList::MEDIA);
                    $result = $uploader->save($mediaDirectory)->getAbsolutePath('Tutorial/Images');
                    $model->setImage('Tutorial/Images' . $result['file']);
                } catch (\Exception $e) {
                    if ($e->getCode() == 0) {
                        $this->messageManager->addError($e->getMessage());
                    }
                }
            }
            $rowData = $this->getRequest()->getParam('id');
            $model->setDate($rowData);
            try{
                $model->save();
                $this->messageManager->addSuccess(__('The FAQ has been saved.'));

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('tutorial/faq/addrow', ['id' => $model->getId(),
                        '_current' => true]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }

            $this->_getSession()->setFormData($rowData);
            $this->_redirect('tutorial/faq/index', ['id' => $postId]);
        }
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('TruongNX_FAQ::save');
    }
}
