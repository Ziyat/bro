<?php

namespace app\entities\excel;

use Yii;

/**
 * This is the model class for table "excel_templates".
 *
 * @property int $id
 * @property string $name
 * @property array $values
 */
class ExcelTemplates extends \yii\db\ActiveRecord
{
    public static function create(string $name, string $values){

        $template = new Static();
        $template->name = $name;
        $template->values = $values;

        return $template;
    }

    public static function tableName()
    {
        return 'excel_templates';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'values' => 'Values',
        ];
    }
}
