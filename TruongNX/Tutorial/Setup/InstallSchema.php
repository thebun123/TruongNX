<?php

namespace TruongNX\Tutorial\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('faq_table')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('faq_table')
            )->addColumn(
                'id',
                \Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'ID'
            )->addColumn(
                'title',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Title'
            )->addColumn(
                'description',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                '32k',
                [],
                'Description'
            )->addColumn(
                'image',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'image'
            )->addColumn(
                'status',
                \Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
                1,
                ['nullable' => false],
                'Status'
            )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At'
                )
                ->setComment('FAQ Table');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
