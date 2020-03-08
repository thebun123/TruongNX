<?php
namespace TruongNX\Tutorial\Controller\Index;

class Config extends \Magento\Framework\App\Action\Action
{
    protected $storeManager;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->$storeManager = $storeManager;
        parent::__construct($context);
    }

    public function execute()
    {

    }
}
