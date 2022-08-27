<?php

namespace app\models;

use Yii;

class TransactionType extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'TransactionType';
    }


    public function rules()
    {
        return [
            [['Code'], 'required'],
            [['Code'], 'integer'],
            [['Description', 'Category'], 'string', 'max' => 100],
            [['Signal'], 'string', 'max' => 10],
            [['Code'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Code' => 'Code',
            'Description' => 'Description',
            'Category' => 'Category',
            'Signal' => 'Signal',
        ];
    }
}
