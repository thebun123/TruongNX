<?php
namespace TruongNX\Tutorial\Controller\Adminhtml\Faq;

use Magento\Framework\App\Filesystem\DirectoryList;
use TruongNX\Tutorial\Model\Faq\Image;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \TruongNX\Tutorial\Model\FAQFactory
     */
    public $faqFactory;

    protected $uploaderFactory;
    protected $imageModel;

    /**
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory
     * @param \Magento\Backend\App\Action\Context $context
     * @param \TruongNX\Tutorial\Model\FAQFactory $faqFactory
//     * @param Image $imageModel
     */
    public function __construct(
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Backend\App\Action\Context $context,
        \TruongNX\Tutorial\Model\FAQFactory $faqFactory
//        Image $imageModel
    ) {
        parent::__construct($context);
        $this->faqFactory = $faqFactory;
        $this->uploaderFactory = $uploaderFactory;
//        $this->imageModel = $imageModel;
    }

    public function execute()
    {
        $isPost = $this->getRequest()->getPost();
        if ($isPost) {
            $model = $this->faqFactory->create();
            $postId = $this->getRequest()->getParam('id');

            if ($postId) {
                $model->load($postId);
            }
            $faqImage = $this->getRequest()->getFiles('faq_image');
            $fileName = ($faqImage && array_key_exists('name', $faqImage)) ?
                $faqImage['name'] : null;
            if ($faqImage && $fileName) {
                try {
                    $uploader = $this->_objectManager->create(
                        'Magento\MediaStorage\Model\File\Uploader',
                        ['fileId' =>'faq_image']
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
            try {
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

//    public function uploadFileAndGetName($input, $destinationFolder, $data)
//    {
//        try {
//            if (isset($data[$input]['delete'])) {
//                return '';
//            } else {
//                $uploader = $this->uploaderFactory->create(['fileId' => $input]);
//                $uploader->setAllowRenameFiles(true);
//                $uploader->setFilesDispersion(true);
//                $uploader->setAllowCreateFolders(true);
//                $result = $uploader->save($destinationFolder);
//                return $result['file'];
//            }
//        } catch (\Exception $e) {
//            if ($e->getCode() != \Magento\Framework\File\Uploader::TMP_NAME_EMPTY) {
//                throw new FrameworkException($e->getMessage());
//            } else {
//                if (isset($data[$input]['value'])) {
//                    return $data[$input]['value'];
//                }
//            }
//        }
//        return '';
//    }
}
