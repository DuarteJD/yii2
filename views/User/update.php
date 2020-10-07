<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Atualizar Usuário:'. $model->nome;
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="usuario-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
