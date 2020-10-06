<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $username;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'email'],
            ['username', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Este e-mail não está presente em nossa base de dados.'
            ],
        ];
    }

    public function attributeLabels()
    {
        //return parent::attributeLabels(); // TODO: Change the autogenerated stub

        return['username' => 'E-mail'];

    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user usuario */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'username' => $this->username,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->passwordResetToken)) {
            $user->generatePasswordResetToken();
            $user->senha_temporaria_alteracao = $user->passwordHash;
            if (!$user->save(false)) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['adminEmail'] => 'TCC'])
            ->setTo($user->username)
            ->setSubject('Alteração de Senha')
            ->send();
    }
}