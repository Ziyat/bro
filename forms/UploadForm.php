<?php

namespace app\forms;

use yii\base\Model;
use Yii;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class UploadForm
 * @package app\forms
 * @property $file
 */
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

    /**
     * @return bool
     * @throws \DomainException
     */

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstance($this, 'file');

            if (!$this->file) {
                throw new \Exception('Файл не найден');
            }

            $path = Yii::getAlias('@upload');

            $filename = Yii::$app->user->id
                . '_'
                . Yii::$app->security->generateRandomString()
                . '.'
                . $this->file->extension;

            $filePath = $path . '/' . $filename;

            if (!is_dir($path)) {
                mkdir($path, 0700);
            }

            if ($this->file->saveAs($filePath)) {
                $this->file = $filename;
            } else {
                throw new \DomainException('upload error');
            }
            return true;
        }
        return false;
    }
}