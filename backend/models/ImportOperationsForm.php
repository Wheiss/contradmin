<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/19/19
 * Time: 7:49 PM
 */

namespace backend\models;


use yii\base\Model;
use yii\web\UploadedFile;

class ImportOperationsForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file = null;
    /**
     * @var string|null
     */
    public $uploadedFilePath = null;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
        ];
    }

    /**
     * Upload form data
     * @return bool
     */
    public function upload()
    {
        if($this->validate()) {
            $this->uploadedFilePath = uniqid(UPLOAD_FOLDER) . '.' . $this->file->getExtension();
            $this->file->saveAs($this->uploadedFilePath);
            return true;
        } else {
            return false;
        }
    }
}