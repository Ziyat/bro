<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dubious`.
 */
class m180401_005927_create_dubious_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%dubious}}', [
            'id' => $this->primaryKey(),
            'id_cli' => $this->string(),
            'mfo_cli' => $this->string(),
            'inn_cli' => $this->string(),
            'account_cli' => $this->string(),
            'name_cli' => $this->string(),
            'mfo_cor' => $this->string(),
            'inn_cor' => $this->string(),
            'account_cor' => $this->string(),
            'name_cor' => $this->string(),
            'date_msg' => $this->string(),
            'date_doc' => $this->string(),
            'doc_sum' => $this->string(),
            'pop' => $this->string(),
            'ans_per' => $this->string(),
            'currency' => $this->string(),
            'criterion' => $this->string(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ],$tableOptions);

        $this->createIndex('{{%index-dubious-created_by}}', '{{%dubious}}', 'created_by');
        $this->addForeignKey('{{%fkey-dubious-created_by}}', '{{%dubious}}', 'created_by', '{{%users}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->createIndex('{{%index-dubious-updated_by}}', '{{%dubious}}', 'updated_by');
        $this->addForeignKey('{{%fkey-dubious-updated_by}}', '{{%dubious}}', 'updated_by', '{{%users}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dubious}}');
    }
}
