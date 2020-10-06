<?php

/* @var $this yii\web\View */
/* @var $user app\models\usuario */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/alterar-senha', 'token' => $user->passwordResetToken]);
?>
Olá, <?= $user->nome ?>,

Clique no link abaixo para recuperar sua senha:

<?= $resetLink ?>
