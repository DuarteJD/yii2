<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuários';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clearfix">
<?= Yii::$app->session->getFlash('deletar') ?>
</div>
<div class="usuario-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Novo Usuário', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">

        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'username:email',
                'nome',
                [
                    'attribute' => 'status',
                    'filter' => [
                        $searchModel::STATUS_ACTIVE => $searchModel::STATUS_ACTIVE_STRING ,
                        $searchModel::STATUS_INACTIVE => $searchModel::STATUS_INACTIVE_STRING
                    ],
                    'headerOptions' => [
                        'class' => 'col-sm-2 text-center'
                    ],
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
                    'format' => 'boolean',
                ],


                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>
</div>
