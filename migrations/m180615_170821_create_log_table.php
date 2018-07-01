<?php

use yii\db\Migration;

/**
 * Handles the creation of table `log`.
 */
class m180615_170821_create_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%log}}', [
            'id' => $this->primaryKey(),
            'action' => $this->string(),
            'description' => $this->text(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->text(),
        ],$tableOptions);

        $this->createIndex('{{%index-log-user_id}}', '{{%log}}', 'user_id');
        $this->addForeignKey('{{%fkey-log-user_id}}', '{{%log}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%log}}');
    }
}
