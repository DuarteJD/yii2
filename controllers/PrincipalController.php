<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class PrincipalController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'login',
            ],
        ];
    }
    

    public function getUsuarioLogado(){

        if(!Yii::$app->getUser()->isGuest){

            $usuario = Yii::$app->user->identity;
            return $usuario;

        }

        Yii::$app->user->logout();
        return $this->goHome();

    }

    public function getUsuarioLogadoId(){

        if(!Yii::$app->getUser()->isGuest){

            $usuario = Yii::$app->user->id;
            return $usuario;

        }

        Yii::$app->user->logout();
        return $this->goHome();

    }
    
}