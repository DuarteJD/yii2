<?php
namespace app\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use app\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $passwordHash_repeat;

    /**
     * @var \app\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Token da senha não pode estar em branco.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Problemas com o token de acesso, solicite uma nova recuperação de senha.');
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['passwordHash_repeat', 'compare', 'compareAttribute' => 'password']
        ];
    }

    public function attributeLabels()
    {
     //   return parent::attributeLabels(); // TODO: Change the autogenerated stub

        return ['password' => 'Senha'];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->passwordHash_repeat = $this->passwordHash_repeat;
        $user->passwordHash = $this->password;
        $user->generateAuthKey();
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
