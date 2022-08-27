<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

class FilesCnab extends \yii\db\ActiveRecord
{

    public $file;

    public static function tableName()
    {
        return 'FilesCnab';
    }

    public function rules()
    {
        return [
            [['UserCode', 'DateTimeLoaded'], 'required'],
            [['Code', 'UserCode'], 'integer'],
            [['DateTimeLoaded', 'Parsed'], 'safe'],
            [['FileName'], 'string', 'max' => 300],
            [['file'], 'file'],
            //[['file'], 'file', 'extensions' => 'txt', 'mimeTypes' => 'text/plain'],
            [['Amount'], 'number'],
            [['Code', 'FileName'], 'unique', 'targetAttribute' => ['Code', 'FileName']],
            [['UserCode'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['UserCode' => 'Code']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Code' => 'Code',
            'UserCode' => 'User Code',
            'DateTimeLoaded' => 'DateTimeLoaded',
            'FileName' => 'FileName',
            'Amount' => 'Amount',
            'Parsed' => 'Parsed',
        ];
    }


}
