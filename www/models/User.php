<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property int $Code
 * @property int $EnterpriseCode
 * @property string $Name
 * @property string $Login
 * @property string $Password
 * @property string $Phone
 * @property string $Active
 * @property int $Status
 * @property Log[] $logs
 */

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    private $authKey;

    public static function tableName()
    {
        return 'User';
    }


    public function rules()
    {
        return [
            [['EnterpriseCode', 'Code'], 'required'],
            [['EnterpriseCode', 'Code'], 'integer'],
            [['authKey'], 'safe'],
            [['Name', 'Login'], 'string', 'max' => 80],
            [['Password', 'Phone'], 'string', 'max' => 60],
            [['ExternalKey', 'Active'], 'string', 'max' => 1],
            [['EnterpriseCode', 'Code'], 'unique', 'targetAttribute' => ['EnterpriseCode', 'Code']],
            [['EnterpriseCode'], 'exist', 'skipOnError' => true, 'targetClass' => Enterprise::className(), 'targetAttribute' => ['EnterpriseCode' => 'Code']],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'EnterpriseCode' => 'Enterprise Code',
            'Code' => 'Code',
            'Name' => 'Name',
            'Login' => 'Login',
            'Password' => 'Senha',
            'Phone' => 'Phone',
            'Active' => 'Active',
        ];
    }


    /********************************************* custom auth *******************************/
    
    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function getId()
    {
        return $this->Code;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($login)
    {
        return self::findOne(['Login' => $login]);
    }

    public function validatePassword($password)
    {
        return $this->Password === md5($password);
    }
    
}



