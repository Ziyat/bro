<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180323_152141_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'is_admin' => $this->boolean()->defaultValue(0),
            'password_hash' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('{{%users}}', [
            'name' => 'Администратор',
            'username' => 'cp_admin',
            'is_admin' => 1,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('1qazxsw23edc@#$'),
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->createIndex('{{%idx-users-status}}', '{{%users}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('{{%users}}');
    }
}
