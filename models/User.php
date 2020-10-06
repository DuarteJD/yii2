<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use \yii\web\IdentityInterface;
use \yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%usuario}}".
 *
 * @property int $id
 * @property string $nome
 * @property string $username
 * @property boolean $cliente
 * @property int $created_at
 * @property int $updated_at
 * @property string $passwordHash
 * @property string $passwordResetToken
 * @property string $authKey
 * @property string $access_token
 * @property string $cpf
 * @property int $status
 * @property string $passwordResetTokenExpire
 */

class User extends PrincipalModel implements IdentityInterface
{
 
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE  = 1;
    public $passwordHash_repeat;    
    public $senha_temporaria_alteracao;

    public static function tableName()
    {
        return '{{%usuario}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    

    public function rules()
    {
        return [
            [['username', 'passwordHash'], 'required'],
            [['nome'], 'string', 'max' => 100],
            [['cpf'], 'string', 'max' => 14],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['cliente', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['authKey'], 'string', 'max' => 32],
            [['username'], 'string', 'max' => 150],
            [['passwordHash'], 'string', 'max' => 45],
            [['access_token'], 'string', 'max' => 255],
            [['access_token', 'passwordResetToken', 'passwordResetTokenExpire'], 'safe'],
            [['username'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'E-mail',
            'nome' => 'Nome',
            'cpf' => 'CPF',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
            'passwordHash' => 'Senha',
            'passwordHash_repeat' => 'Confirmar Senha',
            'passwordResetToken' => 'Password Reset Token',
            'authKey' => 'Auth Key',
            'status' => 'Status',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['authKey']);
        unset($fields['passwordHash']);
        unset($fields['passwordResetToken']);
        unset($fields['passwordResetTokenExpire']);
        return $fields;
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord || $this->passwordHash != $this->senha_temporaria_alteracao){
            $this->setPassword($this->passwordHash);
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $model = static::findOne(['access_token' => $token]);
        if($model){
            return $model;
        }

        return null;
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByUsername($username)
    {                
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'passwordResetToken' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->passwordHash === sha1($password);
    }

    public function setPassword($password)
    {
        $this->passwordHash = sha1($password);
    }

    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->passwordResetToken = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->passwordResetToken = null;
    }

    public function requestPasswordResetToken($id)
    {
        $user = Usuario::findOne([
            'status' => Usuario::STATUS_ACTIVE,
            'id' => $id,
        ]);
        if (!$user) {
            return false;
        }
        if (!Usuario::isPasswordResetTokenValid($user->passwordResetToken)) {
            $user->generatePasswordResetToken();
        }
        if (!$user->save()) {
            return false;
        }
        return $user->passwordResetToken;
    }
}
