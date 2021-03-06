<?php

namespace app\controllers;

use app\models\Gruppe;
use Yii;
use app\models\Benutzer;
use app\models\Testfragetrace;
use app\models\BenutzerSearch;
use app\models\Eparam;
use yii\web\Controller;
use app\Components\Ccontroller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\Components\Generic;
use yii\filters\AccessControl;

/**
 * BenutzerController implements the CRUD actions for Benutzer model.
 */
class BenutzerController extends Ccontroller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update','delete','index','view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update','delete','index','view'],
                        'roles' => ['@'],
                    ],
                ],
            ]

        ];
    }

    /**
     * Lists all Benutzer models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Generic::checkPermission()){
            return $this->redirect(['site/index']);
        }
        $searchModel = new BenutzerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Benutzer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!Generic::checkPermission()){
            return $this->redirect(['site/index']);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Benutzer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->isGuest){
            $user_role = Generic::getCurrentuser(Yii::$app->user->id,'rolle');
            if($user_role != 'admin'){
                Yii::$app->session->setFlash('danger', "You have already registered");
                return $this->redirect(['view', 'id' => Yii::$app->user->id]);
            }
        }

        $model = new Benutzer();
        if ($model->load(Yii::$app->request->post()) ) {

            if(!isset($model->rolle)){
                $model->rolle = 'user';
            }

            $previous_user = Benutzer::find()->select(['user_id'])->orderBy(['id' => SORT_DESC])->one();
            $model->user_id = $previous_user->user_id + 1;

            //reading last users group from db
            $gruppe = Gruppe::find()->one();
            $gruppe->gruppe = ($gruppe->gruppe >= Yii::$app->params['max_gruppe'])? 1 : $gruppe->gruppe + 1; // maximale Gruppennummer

            $model->gruppe = $gruppe->gruppe;
            if($model->save()){
                /*keeping trace of gruppe*/
                if($gruppe->save()){
                    if(Yii::$app->user->isGuest){
                        Yii::$app->session->setFlash('success', "Sie haben sich erfolgreich registriert. Vielen Dank!");
                        return $this->render('view', [
                            'model' => $this->findModel($model->id),
                        ]);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Benutzer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!Generic::checkPermission()){
            return $this->redirect(['site/index']);
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $updated_fields = $model->getDirtyAttributes();
            if($model->save()){
                /*functionality for updating current user number in essential parameter table.*/
                if(!empty($updated_fields) && array_key_exists("status", $updated_fields)){
                    $user_count = ($model->status == 1) ? 1 : -1;
                    $essential_param = Eparam::find()
                        ->where(['name' => 'n'])
                        ->one();
                    $essential_param->value = (string)((int)$essential_param->value + $user_count);
                    if(!$essential_param->save()){
                        Yii::$app->session->setFlash('danger', "User count not updated");
                        return $this->redirect(['view', 'id' => $model->id]);
                    };
                }
                Yii::$app->session->setFlash('success', "Update Successful");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Benutzer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!Generic::checkPermission()){
            return $this->redirect(['site/index']);
        }

        /*functionality for updating current user number in essential parameter table. if any active user is deleted then the */
        $model = $this->findModel($id);
        $dlt_ok = Generic::performBenutzerDeletionDependency($model);

        if($dlt_ok){
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Benutzer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Benutzer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Benutzer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
