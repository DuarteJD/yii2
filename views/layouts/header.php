<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

    $usuario = new app\models\User();
    if(Yii::$app->user->identity){
        $usuario = Yii::$app->user->identity;
    }

?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">TCC</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?= Yii::getAlias('@web/images/') ?>png-usuario.png" class="user-image" />
                        <span class="hidden-xs">
                        <?php 
                            if (!Yii::$app->user->isGuest) {
                                echo($usuario->nome) ;
                            } else {
                                echo("Olá, faça seu login ou cadastre-se");
                            }
                        ?>
                        </span>
                    </a>

                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= Yii::getAlias('@web/images/')?>png-usuario.png" class="img-circle" alt="User Image"/>

                            <span>
                                <p>
                                    <br/>
                                    
                                    <?php
                                        if (!Yii::$app->user->isGuest) {
                                            echo($usuario->nome);
                                            echo("<br/>");
                                            echo("<small>" . $usuario->username . "</small>");
                                        }
                                    ?>
                                </p>
                            </span>
                        </li>
                        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?php 
                                    if (!Yii::$app->user->isGuest) {
                                        if(Yii::$app->user->identity->cliente === 0) {
                                            echo(Html::a('Editar perfil', ['/user/update', 'id' => $usuario->id], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']));
                                        }else {
                                            echo(Html::a('Editar perfil', ['/cliente/update', 'id' => $usuario->id], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']));
                                        }
                                    } else {
                                        echo(Html::a('Cadastre-se', ['/cliente/create'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']));
                                    }
                                ?>
                            </div>


                            <div class="pull-right">
                                <?php 
                                    if (!Yii::$app->user->isGuest) {
                                        echo(Html::a('Sair', ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']));
                                    } else {
                                        echo(Html::a('Entrar', ['/site/login'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']));
                                    }
                                ?>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->                
            </ul>
        </div>
    </nav>
</header>
