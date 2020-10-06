<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'Alteração de Senha';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="page">
    <div class="page-content">
        <div class="page-login-main animation-slide-right animation-duration-1">
            <div class="brand hidden-md-up">
                <img class="brand-img" src="<?= Yii::getAlias('@web/images/') ?>logo-colored@2x.png" alt="...">
                <h3 class="brand-text font-size-40">TCC</h3>
            </div>
            <h3 class="font-size-24">Alteração de Senha</h3>
            <p>Preencha os campos para alterar sua senha.</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

            <?= $form
                ->field($model, 'password', $fieldOptions2)
                ->label(false)
                ->passwordInput(['placeholder' => 'Nova Senha']) ?>

            <?= $form
                ->field($model, 'passwordHash_repeat', $fieldOptions2)
                ->label(false)
                ->passwordInput(['placeholder' => 'Repita a Senha']) ?>


            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                    <?= Html::submitButton('Alterar', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>
                <!-- /.col -->
            </div>


            <?php ActiveForm::end(); ?>

            <footer class="page-copyright">
                <p>Info Solutions</p>
                <p>© 2018. Todos os direitos reservados.</p>
                <div class="social">
                    <a class="btn btn-icon btn-round social-twitter mx-5" href="javascript:void(0)">
                        <i class="icon bd-twitter" aria-hidden="true"></i>
                    </a>
                    <a class="btn btn-icon btn-round social-facebook mx-5" href="javascript:void(0)">
                        <i class="icon bd-facebook" aria-hidden="true"></i>
                    </a>
                    <a class="btn btn-icon btn-round social-google-plus mx-5" href="javascript:void(0)">
                        <i class="icon bd-google-plus" aria-hidden="true"></i>
                    </a>
                </div>
            </footer>
        </div>

    </div>
</div><!-- /.login-box -->
