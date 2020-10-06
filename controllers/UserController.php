<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioController implements the CRUD actions for User model.
 */
class UserController extends PrincipalController
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->status = true;
        $model->cliente = false;

        if ($model->load(Yii::$app->request->post())) {

            $verificar = User::find()->where(['username' => $model->username])->one();
            if ($verificar ){      
                
                Yii::$app->session->setFlash('Criar', '<p class="alert alert-danger"><span><i class="icon fa fa-warning"></i> Alerta!</span>Não foi possivel criar este registro, ele está relacionado a outros dados</p>');

                return $this->redirect(['index']);
            }
            else{
                $model->generateAuthKey();

                if ($model->save()){
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        $model->passwordHash = "temp";
        $model->passwordHash_repeat = "temp";
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
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

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
