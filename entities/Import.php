<?php

namespace app\entities\report;

use Yii;
use yii\base\Model;
use moonland\phpexcel\Excel;

class Import extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'],
                'file',
                'checkExtensionByMimeType' => false,
                'skipOnEmpty' => true,
                'extensions' => 'xls, xlsx',
                'mimeTypes' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel',
                'maxFiles' => 1, 'maxSize' => 200 * 1024 * 1024
            ]
        ];
    }

    public function uploadFile()
    {
        $path = Yii::getAlias('upload/');
        $filename = time() . '.' . $this->file->extension;
        $url = 'upload/';
        if (!is_dir($path)) {
            mkdir($path, 0700);
        }

        if ($this->file->saveAs($path . $filename)) {
            $data = Excel::widget([
                'mode' => 'import',
                'fileName' => [
                    'import' => $path . $filename,
                ],
                'setFirstRecordAsKeys' => false,
                'setIndexSheetByName' => false,
                'getOnlySheet' => 'sheet1',
            ]);
        }
        return $data;
    }

    public static function export($model)
    {
        return Excel::export([
            'models' => $model,
            'columns' => [
                'id',
                'mfo_client',
                'mfo_correspondent',
                'name_client',
                'name_correspondent',
                'account_correspondent',
                'account_client',
                'document_amount',
                'purpose_of_payment',
                'executor',
                'date_message',
                'criterion',
            ],
            'headers' => [
                'created_at' => 'Date Created Content',
            ],
        ]);
    }
}