<?php

namespace app\forms;

use yii\base\Model;
use Yii;

class UploadForm extends Model
{
    public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['file'],
                'file',
                'checkExtensionByMimeType' => false,
                'skipOnEmpty' => true,
                'extensions' => 'xls, xlsx',
                'mimeTypes' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel',
                'maxFiles' => 1,
                'maxSize' => 200 * 1024 * 1024],
        ];
    }

    public function uploadFile()
    {
        if(!$this->file){
            throw new \Exception('Файл не найден');
        }
        $path = Yii::getAlias('@upload');
        $filename = time() . '.' . $this->file->extension;
        $filePath = $path . '/' . $filename;
        if (!is_dir($path)) mkdir($path, 0700);

        if ($result = $this->file->saveAs($filePath)) {
            return $filePath;
        }

        throw new \DomainException('upload error');
    }
}