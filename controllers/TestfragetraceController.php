<?php

namespace app\controllers;

use Yii;
use app\models\Testfragetrace;
use app\models\TestfragetraceSearch;
//use yii\web\Controller;
use app\Components\Ccontroller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\Components\Generic;


/**
 * TestfragetraceController implements the CRUD actions for Testfragetrace model.
 */
class TestfragetraceController extends Ccontroller
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
                'only' => ['delete','index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['delete','index'],
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all Testfragetrace models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Generic::checkPermission()){
            return $this->redirect(['site/index']);
        }

        $searchModel = new TestfragetraceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Deletes an existing Testfragetrace model.
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
     * Finds the Testfragetrace model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Testfragetrace the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Testfragetrace::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
