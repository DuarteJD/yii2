<?php


use yii\grid\GridView;
use dosamigos\chartjs\ChartJs;
use kartik\daterange\DateRangePicker;
use yii\widgets\ActiveForm;

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
                                'format'=> 'd-m-Y',
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
                    <span class="info-box-text">Em separação</span>
                    <span class="info-box-number"><?= $qtde_separacao ?></span>
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
                    <span class="info-box-text">Finalizados</span>
                    <span class="info-box-number"><?= $taxa_conversao ?>%</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: <?= $taxa_conversao ?>%"></div>
                    </div>
                    <span class="progress-description"></span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-12">
            
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Pedidos no período</a></li>                    
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="box-header"></div>
                        <div class="box-body table-responsive no-padding">
                            <?php

                            echo GridView::widget([
                                'dataProvider' => $dataProviderPedido,
                                'layout' => "{items}\n{summary}\n{pager}",
                                'columns' => [
                                    'id',
                                    'data_pedido',
                                    'cliente',
                                    'valor_total',                                    
                                    'status',                                    
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
