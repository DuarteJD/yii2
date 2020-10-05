<?php


use yii\grid\GridView;
use dosamigos\chartjs\ChartJs;
use kartik\daterange\DateRangePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = '';
?>
<div class="site-index">

    <div class="row">
        <div class="col-md-12">
            <label class="control-label">Período para análise </label>
            <div class="drp-container>
                <?php

                   $form = ActiveForm::begin([
                       'action' => ['index'],
                       'method' => 'post',
                       'id' => 'inicio-fim-busca'
                   ]);

                    echo $form->field($dashboardForm, 'inicio_fim', [
                        'options'=>['class'=>'drp-container form-group']
                    ])->widget(DateRangePicker::classname(), [
                        'useWithAddon'=>true,
                        'startAttribute' => 'inicio',
                        'endAttribute' => 'fim',
                        'presetDropdown'=>true,
                        'convertFormat'=>true,
                        'pluginOptions'=>[
                            'locale'=>[
                                'format'=> 'Y-m-d',
                                'separator'=>' até ',
                            ],
                            'opens'=>'left'
                        ]
                    ])->label(false);


                    ActiveForm::end();
                    ?>
                </br>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pedidos</span>
                    <span class="info-box-number"><?= $qtde_pedidos ?></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pendentes</span>
                    <span class="info-box-number"><?= $qtde_pendentes ?></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description"></span>
                </div>
            </div>
        </div>

        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Finalizados</span>
                    <span class="info-box-number"><?= $qtde_finalizados ?></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description"></span>
                </div>
            </div>
        </div>

        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Taxa de conversão</span>
                    <span class="info-box-number"><?= $taxa_conversao ?>%</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: <?= $taxa_conversao ?>%"></div>
                    </div>
                    <span class="progress-description"></span>
                </div>
            </div>
        </div>
    </div>

    <?php /*
    <div class="row">
        <div class="col-md-12">
            
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Departamentos</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Setores</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Sexo</a></li>
                    <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Atendente</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="box-header"></div>
                        <div class="box-body table-responsive no-padding">
                            <?php

                            echo GridView::widget([
                                'dataProvider' => $dataProviderDepartamento,
                                'layout' => "{items}\n{summary}\n{pager}",
                                'columns' => [
                                    'departamento_nome',
                                    'qtde_atendimentos',
                                    'compraram',
                                    'oportunidades',
                                    [
                                        'attribute' => 'taxa_conversao',
                                        'value' => function($model){
                                            return $model->getTaxaConversao();
                                        }
                                    ]
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <div class="box-header">
<!--                            <h3 class="box-title">Setores mais buscados</h3>-->
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <?php
                                echo GridView::widget([
                                    'dataProvider' => $dataProviderSetores,
                                    'layout' => "{items}\n{summary}\n{pager}",
                                    'columns' => [
                                        'setores_nome',
                                        'qtde_atendimentos',
                                        'compraram',
                                        'oportunidades',
                                        [
                                            'attribute' => 'taxa_conversao',
                                            'value' => function($model){
                                                return $model->getTaxaConversao();
                                            }
                                        ]
                                    ],
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_3">
                        <div class="box-header">
                            <!--                            <h3 class="box-title">Setores mais buscados</h3>-->
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <?php
                            echo GridView::widget([
                                'dataProvider' => $dataProviderSexo,
                                'layout' => "{items}\n{summary}\n{pager}",
                                'columns' => [
                                    [
                                        'attribute' => 'sexo',
                                        'value' => function($model){
                                            if($model->sexo == 2){
                                                return 'Mulheres';
                                            }else{
                                                return 'Homens';
                                            }
                                        }
                                    ],
                                    'qtde_atendimentos',
                                    'compraram',
                                    'oportunidades',
                                    [
                                        'attribute' => 'taxa_conversao',
                                        'value' => function($model){
                                            return $model->getTaxaConversao();
                                        }
                                    ]
                                ],
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_4">

                        <div class="box-header">
                            <!--                            <h3 class="box-title">Setores mais buscados</h3>-->
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <?php
                            echo GridView::widget([
                                'dataProvider' => $dataProviderAtendentes,
                                'layout' => "{items}\n{summary}\n{pager}",
                                'columns' => [
                                    'usuario_nome',
                                    'qtde_atendimentos',
                                    'compraram',
                                    'oportunidades',
                                    [
                                        'attribute' => 'taxa_conversao',
                                        'value' => function($model){
                                            return $model->getTaxaConversao();
                                        }
                                    ],
                                    'ultima_sincronizacao:datetime'
                                ],
                            ]);
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    */
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="box text-center">
                <div class="chart-container">
                    <?= ChartJs::widget([

                        'type' => 'bar',
                        'options' => [
                            'maintainAspectRatio' => true,
                            'responsive' => true,
                        ],
                        'data' => [
                            'labels' => $grafico['labels'],
                            'datasets' => [
                                [
                                    'label' => "Pedidos",
                                    'backgroundColor' => "rgba(0, 85, 155, 0.2)",
                                    'borderColor' => "rgba(0, 85, 155, 0.8)",
                                    'data' => $grafico['atendimentos']
                                ],
                                [
                                    'label' => "Finalizados",
                                    'backgroundColor' => "rgba(11, 122, 10, 0.6)",
                                    'borderColor' => "rgba(11, 122, 10, 1)",
                                    'data' => $grafico['finalizados']
                                ]
                            ]
                        ],
                        'clientOptions' => [
                            'scales' => [
                                'yAxes' => [
                                    [
                                        'ticks' => [
                                            'beginAtZero' => true
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>

</div>
