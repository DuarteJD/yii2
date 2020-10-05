<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-6">
    <div class="row">
        <div class="usuario-view box box-primary">
            <div class="box-header">
                <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
                <?= Html::a('Deletar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-flat',
                    'data' => [
                        'confirm' => 'Tem certeza que deseja deletar este registro?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
            <div class="box-body table-responsive no-padding">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'username:email',
                        'nome',
                        'cpf',
                        'created_at:datetime',
                        'updated_at:datetime',
                        'passwordHash',
                        'passwordResetToken',
                        'authKey',
                        'status:boolean',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
