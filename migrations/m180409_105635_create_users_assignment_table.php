<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users_group_assignment`.
 */
class m180409_105635_create_users_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%users_assignment}}', [
            'user_id' => $this->integer()->notNull(),
            'group_id' => $this->integer()->notNull(),
        ],$tableOptions);

        $this->addPrimaryKey('{{%pk-users_assignment-user_id-group_id}}','{{%users_assignment}}',['user_id','group_id']);

        $this->createIndex('{{%idx-users_assignment-user_id}}', '{{%users_assignment}}', 'user_id');
        $this->createIndex('{{%idx-users_assignment-group_id}}', '{{%users_assignment}}', 'group_id');
        $this->addForeignKey('{{%fk-users_assignment-user_id}}', '{{%users_assignment}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-users_assignment-group_id}}', '{{%users_assignment}}', 'group_id', '{{%users_group}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users_assignment');
    }
}
