<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Novo Usuário';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
