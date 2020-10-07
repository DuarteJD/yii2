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
use app\models\Pedido;
use yii\data\ActiveDataProvider;
use app\models\DashboardForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;

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

                if(!Yii::$app->request->post()) {
                    $datainisession = Yii::$app->session->get('data_inicial');
                    $datafimsession = Yii::$app->session->get('data_final');
                    if($datainisession) {
                        $dashboardForm->inicio = $datainisession;
                        $dashboardForm->fim = $datafimsession;
                    }
                }

                $dashboardForm->inicio_fim = $dashboardForm->inicio . ' Até ' . $dashboardForm->fim;

                if(Yii::$app->request->post()) {
                    Yii::$app->session->set('data_inicial', $dashboardForm->inicio);
                    Yii::$app->session->set('data_final', $dashboardForm->fim);
                }
                

                $qtde_pedidos = Pedido::find()->where(['and', "data_pedido>='".$dashboardForm->inicio." 00:01:00'", "data_pedido <= '".$dashboardForm->fim." 23:59:59'"])->count('id');
                $qtde_pendentes = Pedido::find()->where(['and', "data_pedido>='".$dashboardForm->inicio." 00:01:00'", "data_pedido <= '".$dashboardForm->fim." 23:59:59'"])->andWhere(['status' => 0])->count('id');
                $qtde_separacao = Pedido::find()->where(['and', "data_pedido>='".$dashboardForm->inicio." 00:01:00'", "data_pedido <= '".$dashboardForm->fim." 23:59:59'"])->andWhere(['status' => 1])->count('id');
                $qtde_prontos = Pedido::find()->where(['and', "data_pedido>='".$dashboardForm->inicio." 00:01:00'", "data_pedido <= '".$dashboardForm->fim." 23:59:59'"])->andWhere(['status' => 3])->count('id');
                $taxa_conversao = 0;
                
                if($qtde_pedidos > 0) {
                    $taxa_conversao = ($qtde_prontos * 100) / $qtde_pedidos;
                } 

                $queryPedido = Pedido::find()
                    ->select([
                        'pedido.id',
                        'pedido.data_pedido',
                        'usuario.nome as cliente',
                        'pedido.valor_total',
                        'pedido.status as status'
                    ])
                    ->joinWith('cliente', true, 'INNER JOIN')
                    ->where(['and', "data_pedido >= '".$dashboardForm->inicio." 00:01:00'", "data_pedido <= '".$dashboardForm->fim." 23:59:59'"]);
                                               

                $dataProviderPedido = new ActiveDataProvider([
                    'query' => $queryPedido,
                    'pagination' => [
                        'pageSize' => 30
                    ]
                ]);
                
                return $this->render('dashboard', [
                    'qtde_pedidos' => $qtde_pedidos,
                    'qtde_pendentes' => $qtde_pendentes,
                    'qtde_separacao' => $qtde_separacao,
                    'taxa_conversao' => $taxa_conversao,
                    'dashboardForm' => $dashboardForm,                    
                    'dataProviderPedido' => $dataProviderPedido,
                ]);
            }

        }
        return $this->render('index');
    }

    public function actionInvoice($id)
    {
        if($id) {
            $pedido = Pedido::findOne(['id' => $id]);            
            if($pedido) {                                
                return $this->render('invoice', [
                    'model' => $pedido,
                ]);
            }
        }        
        return $this->redirect(['site/index']);
    }

    public function actionAlterarStatusPedido($id)
    {
        if($id) {
            $pedido = Pedido::findOne(['id' => $id]);            
            if($pedido) {                                
                if ($pedido->status < 3) {                    
                    $pedido->status += 1;
                    if(!$pedido->save()) {
                        print_r($pedido->errors);
                    };                    
                }
            }
        }        
        return $this->redirect(['site/index']);
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
    public function actionRequererNovaSenha()
    {
        $this->layout = 'main-login';

        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', '<span class="label label-success">Verifique seu e-mail para as instruções de alteração de senha.</span>');

                return $this->redirect(['site/login']);
            } else {
                Yii::$app->session->setFlash('error', '<span class="label label-warning">Desculpe, não podemos redefinir a senha para o endereço de e-mail informado.</span>');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionAlterarSenha($token)
    {
        $this->layout = 'main-login';

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', '<span class="label label-success">Sua senha foi alterada com sucesso!</span>');

            return $this->redirect(['site/login']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

}
