<?php

use yii\db\Migration;

/**
 * Class m180809_173212_add_dubious_file_field
 */
class m180809_173212_add_dubious_file_field extends Migration
{

    public function up()
    {
        $this->addColumn('{{%dubious}}', 'file', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%dubious}}', 'file');
    }

}