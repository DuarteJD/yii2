<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'Entrar';

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
                <h3 class="brand-text font-size-40">Login do cliente</h3>
            </div>
            <h3 class="font-size-24">Entrar</h3>
            <p>Preencha os campos para efetuar o login.</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

            <?= $form
                ->field($model, 'username', $fieldOptions1)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('usuario')]) ?>

            <?= $form
                ->field($model, 'password', $fieldOptions2)
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('senha')]) ?>

            <div class="row">
                <div class="col-xs-8">
                    <?= $form->field($model, 'rememberMe')->checkbox()
                        ->label(' Logar automaticamente')
                    ?>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>
                <!-- /.col -->
            </div>


            <?php ActiveForm::end(); ?>

            <?php
            echo Yii::$app->session->getFlash('success');
            echo Yii::$app->session->getFlash('error');
            ?>

            <p>Esqueceu sua senha? <a href="<?= \yii\helpers\Url::to(['site/requerer-nova-senha']) ?>">Recuperar Senha</a></p>
            <p>Não possui cadastro? <a href="<?= \yii\helpers\Url::to(['user/create']) ?>">Cadastre-se</a></p>

            <footer class="page-copyright">

                <p>Jaqueline Brum</p>
                <p>© 2020. Todos os direitos reservados.</p>
                
            </footer>
        </div>

    </div>
</div><!-- /.login-box -->