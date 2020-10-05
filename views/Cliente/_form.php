<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $modelperfil app\models\Perfil*/
/* @var $form yii\widgets\ActiveForm */

?>

<div class="usuario-form box box-primary">
    
    <div class="clearfix">
        <?= Yii::$app->session->getFlash('Criar') ?>
    </div>

    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive row" >
        <div class="col-md-12">
            <?= $form->field($model, 'username')->textInput(['disabled' => !$model->isNewRecord]) ?>
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cpf')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999.999.999-99',]) ?>
        </div>        

        <?php
        if($model->isNewRecord){
        ?>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'passwordHash')->passwordInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'passwordHash_repeat')->passwordInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <?php
        }
        ?>

        <div class="col-md-12">
            <?= $form->field($model, 'status')->radioList( $model->getStatus()) ?>
        </div>
    </div>

    <div class="box-footer">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
