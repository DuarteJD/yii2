<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Cadastrar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>    

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'nome')->textInput(['autofocus' => true, 'placeholder' => "Nome completo"]) ?>

        <?= $form->field($model, 'username')->textInput(['placeholder' => "Nome para acesso"]) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => "Senha"]) ?>
        
        <input type="submit" class="btn btn-success btn-block" value="Cadastrar">
  

    <?php ActiveForm::end(); ?>    

    <div class="text-center">
    <a href="<?php echo Url::toRoute("site/login")?>">Entrar no sistema</a>
    </div>
</div>
