<?php
    $usuario = new app\models\User();
    if(Yii::$app->user->identity){
        $usuario = Yii::$app->user->identity;
    }
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Yii::getAlias('@web/images/') ?>png-usuario.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo($usuario->nome) ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => '', 'options' => ['class' => 'header']],
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['site/index']],                    
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Cadastros',
                        'icon' => 'edit',
                        'url' => ['#'],
                        'items' => [                            
                            ['label' => 'Clientes', 'icon' => 'user', 'url' => ['/cliente'],],
                            ['label' => 'Endereços', 'icon' => 'user', 'url' => ['/cliente-endereco'],],
                            ['label' => 'Produtos', 'icon' => 'user', 'url' => ['/produto'],],
                            ['label' => 'Marcas', 'icon' => 'user', 'url' => ['/marca'],],
                            ['label' => 'Setores', 'icon' => 'user', 'url' => ['/setor'],],
                            ['label' => 'Supermercado', 'icon' => 'user', 'url' => ['/supermercado'],],
                            ['label' => 'Tipos de endereço', 'icon' => 'user', 'url' => ['/tipo-endereco'],],
                            ['label' => 'Usuários', 'icon' => 'user', 'url' => ['/user'],],
                        ],
                    ],                    
                ],
            ]
        ) ?>

    </section>

</aside>
