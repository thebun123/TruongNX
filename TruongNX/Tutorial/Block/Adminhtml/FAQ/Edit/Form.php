<?php

namespace TruongNX\Tutorial\Block\Adminhtml\FAQ\Edit;

/**
 * Adminhtml Add New Row Form.
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_store;
    protected $_log;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \TruongNX\Tutorial\Model\Status $options,
        \TruongNX\Tutorial\Model\Config\Source\Store $store,
        \TruongNX\Tutorial\Logger\Logger $log,
        array $data = []
    )
    {
        $this->_options = $options;
        $this->_store = $store;
        $this->_log = $log;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form',
                            'enctype' => 'multipart/form-data',
                            'action' => $this->getData('action'),
                            'method' => 'post'
                        ]
            ]
        );

        $form->setHtmlIdPrefix('wkgrid_');
        if ($model->getId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Row Data'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('faq_id', 'hidden', ['name' => 'id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Row Data'), 'class' => 'fieldset-wide']
            );
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'id' => 'title',
                'title' => __('Title'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);

        $fieldset->addField(
            'description',
            'editor',
            [
                'name' => 'description',
                'label' => __('Description'),
                'style' => 'height:10em;',
                'required' => true,
                'config' => $wysiwygConfig
            ]
        );

        $fieldset->addField(
                    'faq_image',
                    'image',
                    [
                        'name' => 'faq_image',
                        'label' => __('Image'),
                        'title' => __('Image'),
                        'note' => 'Allow image type: jpg, jpeg, png',
                        'config' => $wysiwygConfig
                    ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'id' => 'status',
                'title' => __('Status'),
                'values' => $this->_options->getOptionArray(),
                'class' => 'status',
                'required' => true,
            ]
        );

                $fieldset->addField(
                    'store_id',
                    'select',
                    [
                        'name' => 'store_id',
                        'label' => __('Store ID'),
                        'id' => 'store_id',
                        'title' => __('Store ID'),
                        'values' => $this->_store->toOptionArray(),
                        'class' => 'store',
                        'required' => true,
                    ]
                );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
//         $this->_log->info('form');

        return parent::_prepareForm();
    }
}
