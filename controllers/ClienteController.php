<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\ClienteSearch;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClienteController implements the CRUD actions for User model.
 */
class ClienteController extends PrincipalController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new User();
        $model->status = true;
        $model->cliente = true;

        if ($model->load(Yii::$app->request->post())) {

            $verificar = User::find()->where(['username' => $model->username])->one();
            if ($verificar ){
                Yii::$app->session->setFlash('Criar', '<p class="alert alert-danger"><span><i class="icon fa fa-warning"></i> Alerta!</span>Este e-mail já encontra-se cadastrado!</p>');                
            } else {
                $cpf = User::find()->where(['cpf' => $model->cpf])->one();
                if ($cpf ){                    
                    Yii::$app->session->setFlash('Criar', '<p class="alert alert-danger"><span><i class="icon fa fa-warning"></i> Alerta!</span>Este CPF já encontra-se cadastrado!</p>');                    
                } else {
                    $model->generateAuthKey();
                    if ($model->save()){

                        Yii::$app->user->login($model);
                        return $this->goHome();
                    }
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->senha_temporaria_alteracao = $model->passwordHash;

        if ($model->load(Yii::$app->request->post())) {

            if($model->passwordHash == 'temp'){
                $model->passwordHash =          $model->senha_temporaria_alteracao;
                $model->passwordHash_repeat =   $model->senha_temporaria_alteracao;
            }

            if ($model->save()){
                return $this->goHome();
            }
        }
        
        $model->passwordHash = "temp";
        $model->passwordHash_repeat = "temp";
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model){

            try{

                $model->delete();

            }catch (Exception $e){

                Yii::$app->session->setFlash('deletar', '<p class="alert alert-danger"><span><i class="icon fa fa-warning"></i> Alerta!</span>Não foi possivel deletar este registro, ele está relacionado a outros dados</p>');

            }

        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
