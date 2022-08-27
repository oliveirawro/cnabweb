<?php

namespace app\models;

use Yii;

class TransactionCnab extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return 'TransactionCnab';
    }

    public function rules()
    {
        return [
            [['FilesCnabCode', 'TransactionTypeCode'], 'integer'],
            [['DateOccurrence', 'TimeOccurrence'], 'safe'],
            [['Value'], 'number'],
            [['NationalRegister', 'Card'], 'string', 'max' => 20],
            [['NameStoreOwner'], 'string', 'max' => 200],
            [['NameStore'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Code' => 'Code',
            'FilesCnabCode' => 'Files Cnab Code',
            'TransactionTypeCode' => 'Transaction Type Code',
            'DateOccurrence' => 'Date Occurrence',
            'Value' => 'Value',
            'NationalRegister' => 'National Register',
            'Card' => 'Card',
            'TimeOccurrence' => 'Time Occurrence',
            'NameStoreOwner' => 'Name Store Owner',
            'NameStore' => 'Name Store',
        ];
    }
}
