<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\Usuario */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/alterar-senha', 'token' => $user->passwordResetToken]);
?>
<div class="password-reset">
    <p>Olá, <?= Html::encode($user->nome) ?>,</p>

    <p>Clique no link abaixo para recuperar sua senha:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
