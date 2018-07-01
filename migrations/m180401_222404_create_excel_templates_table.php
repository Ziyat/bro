<?php

use yii\db\Migration;

/**
 * Handles the creation of table `excel_templates`.
 */
class m180401_222404_create_excel_templates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%excel_templates}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'values' => 'MEDIUMTEXT',
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ],$tableOptions);

        $this->createIndex('{{%index-excel_templates-created_by}}', '{{%excel_templates}}', 'created_by');
        $this->addForeignKey('{{%fkey-excel_templates-created_by}}', '{{%excel_templates}}', 'created_by', '{{%users}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->createIndex('{{%index-excel_templates-updated_by}}', '{{%excel_templates}}', 'updated_by');
        $this->addForeignKey('{{%fkey-excel_templates-updated_by}}', '{{%excel_templates}}', 'updated_by', '{{%users}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%excel_templates}}');
    }
}
