<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\DashboardForm;

class SiteController extends PrincipalController
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'dashboard'],
                'rules' => [
                    [
                        'actions' => ['logout', 'dashboard'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $user = User::findOne(Yii::$app->user->getId());
            if($user->cliente === 0) {

                $dashboardForm = new DashboardForm();
                $dashboardForm->inicio = date('Y-m-d');
                $dashboardForm->fim = date('Y-m-d');
                $dashboardForm->load(Yii::$app->request->post());

                $qtde_pedidos = 5;
                $qtde_pendentes = 4;
                $qtde_finalizados = 1;
                $taxa_conversao = round(100 * ($qtde_finalizados / $qtde_pedidos), 2);

                $grafico = [
                    'labels' => "Nome",
                    'atendimentos' => 5,
                    'finalizados' => 1
                ];

                return $this->render('dashboard', [
                    'qtde_pedidos' => $qtde_pedidos,
                    'qtde_pendentes' => $qtde_pendentes,
                    'qtde_finalizados' => $qtde_finalizados,
                    'taxa_conversao' => $taxa_conversao,
                    'dashboardForm' => $dashboardForm,
                    'grafico' => $grafico
                ]);
            }

        }
        return $this->render('index');
    }
        
    public function actionCadastro()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                return $this->redirect(['site/login']);
            }
        }

        return $this->render('cadastro', [
            'model' => $model,
        ]);
    }
    
    public function actionLogin()
    {        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }        

        $this->layout = 'main-login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionAdmin()
    {        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }        

        $this->layout = 'main-admin';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('admin', [
            'model' => $model,
        ]);
    }
    
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    
    public function actionAbout()
    {
        return $this->render('about');
    }
}
