<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dubious`.
 */
class m180810_173553_alter_dubious_column extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%dubious}}', 'doc_sum', $this->float());
    }

    public function down()
    {
        $this->alterColumn('{{%dubious}}', 'doc_sum', $this->string());
    }
}
