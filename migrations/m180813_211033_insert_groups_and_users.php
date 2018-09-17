<?php

use yii\db\Migration;

/**
 * Class m180813_211033_insert_groups_and_users
 */
class m180813_211033_insert_groups_and_users extends Migration
{

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        //regions

        $this->insert('{{%users_group}}', [
            'name' => 'Ташкент',
        ], $tableOptions);
        $this->insert('{{%users_group}}', [
            'name' => 'Наманган',
        ], $tableOptions);
        $this->insert('{{%users_group}}', [
            'name' => 'Кашкадарья',
        ], $tableOptions);
        $this->insert('{{%users_group}}', [
            'name' => 'Навоий',
        ], $tableOptions);
        $this->insert('{{%users_group}}', [
            'name' => 'Андижан',
        ], $tableOptions);
        $this->insert('{{%users_group}}', [
            'name' => 'Ташкентская область',
        ], $tableOptions);

        //branch

        $this->insert('{{%users_group}}', [
            'name' => 'филиал Ташкент',
            'parent_id' => 1
        ], $tableOptions);
        $this->insert('{{%users_group}}', [
            'name' => 'филиал Наманган',
            'parent_id' => 2
        ], $tableOptions);
        $this->insert('{{%users_group}}', [
            'name' => 'филиал Кашкадарья',
            'parent_id' => 3
        ], $tableOptions);
        $this->insert('{{%users_group}}', [
            'name' => 'филиал Навоий',
            'parent_id' => 4
        ], $tableOptions);
        $this->insert('{{%users_group}}', [
            'name' => 'филиал Андижан',
            'parent_id' => 5
        ], $tableOptions);
        $this->insert('{{%users_group}}', [
            'name' => 'филиал Ташкентская область',
            'parent_id' => 6
        ], $tableOptions);


        //users


        $this->insert('{{%users}}', [
            'name' => 'Оператор филиал Ташкент',
            'username' => 'operator_1',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('111111'),
            'created_at' => time(),
            'updated_at' => time(),
        ], $tableOptions);

        $this->insert('{{%users}}', [
            'name' => 'Оператор филиал Наманган',
            'username' => 'operator_2',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('111111'),
            'created_at' => time(),
            'updated_at' => time(),
        ], $tableOptions);

        $this->insert('{{%users}}', [
            'name' => 'Оператор филиал Кашкадарья',
            'username' => 'operator_3',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('111111'),
            'created_at' => time(),
            'updated_at' => time(),
        ], $tableOptions);

        $this->insert('{{%users}}', [
            'name' => 'Оператор филиал Навоий',
            'username' => 'operator_4',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('111111'),
            'created_at' => time(),
            'updated_at' => time(),
        ], $tableOptions);

        $this->insert('{{%users}}', [
            'name' => 'Оператор филиал Андижан',
            'username' => 'operator_5',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('111111'),
            'created_at' => time(),
            'updated_at' => time(),
        ], $tableOptions);

        $this->insert('{{%users}}', [
            'name' => 'Оператор филиал Ташкентская область',
            'username' => 'operator_6',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('111111'),
            'created_at' => time(),
            'updated_at' => time(),
        ], $tableOptions);



        $this->insert('{{%users_assignment}}', [
            'user_id' => 2,
            'group_id' => 7,
        ], $tableOptions);

        $this->insert('{{%users_assignment}}', [
            'user_id' => 3,
            'group_id' => 8,
        ], $tableOptions);

        $this->insert('{{%users_assignment}}', [
            'user_id' => 4,
            'group_id' => 9,
        ], $tableOptions);

        $this->insert('{{%users_assignment}}', [
            'user_id' => 5,
            'group_id' => 10,
        ], $tableOptions);

        $this->insert('{{%users_assignment}}', [
            'user_id' => 6,
            'group_id' => 11,
        ], $tableOptions);

        $this->insert('{{%users_assignment}}', [
            'user_id' => 7,
            'group_id' => 12,
        ], $tableOptions);


    }

    public function safeDown()
    {
        $this->delete('{{%users_group}}', [
            'name' => 'Ташкент',
        ]);
        $this->delete('{{%users_group}}', [
            'name' => 'Наманган',
        ]);
        $this->delete('{{%users_group}}', [
            'name' => 'Кашкадарья',
        ]);
        $this->delete('{{%users_group}}', [
            'name' => 'Навоий',
        ]);
        $this->delete('{{%users_group}}', [
            'name' => 'Андижан',
        ]);
        $this->delete('{{%users_group}}', [
            'name' => 'Ташкентская область',
        ]);
    }

}
