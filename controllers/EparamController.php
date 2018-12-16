<?php

namespace app\controllers;

use Yii;
use app\models\Eparam;
use app\models\EparamSearch;
//use yii\web\Controller;
use app\Components\Ccontroller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\Components\Generic;
use yii\filters\AccessControl;

/**
 * EparamController implements the CRUD actions for Eparam model.
 */
class EparamController extends Ccontroller
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
                'only' => ['create','update','delete','index','view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create','update','delete','index','view'],
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all Eparam models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Generic::checkPermission()){
            return $this->redirect(['site/index']);
        }

        $searchModel = new EparamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Eparam model.
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
     * Creates a new Eparam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Generic::checkPermission()){
            return $this->redirect(['site/index']);
        }
        $model = new Eparam();

        if ($model->load(Yii::$app->request->post())) {

            if($model->save()){
                Generic::deleteCache();
                return $this->redirect(['view', 'id' => $model->id]);
                //return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Eparam model.
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

            if($model->save()){
                Generic::deleteCache();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Eparam model.
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

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Eparam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Eparam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Eparam::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
