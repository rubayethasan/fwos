<?php

namespace app\controllers;

use Yii;
use app\Components\Generic;
use app\models\Marktspiel;
use app\models\MarktspielSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MarktspielController implements the CRUD actions for Marktspiel model.
 */
class MarktspielController extends Controller
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
     * Lists all Marktspiel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarktspielSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Marktspiel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($round)
    {
        $username = Generic::getCurrentuser(Yii::$app->user->id,'username');
        $marktspiel = Marktspiel::find()->where(['username' => $username,'round'=>$round])->one();
        if(!empty($marktspiel)){ // if already marktspiel data is stored for this user
            return $this->redirect(['eingabe/create', 'round' => $round]);
        }else{
            $model = new Marktspiel();
            if ($model->load(Yii::$app->request->post())) {
                $model->username = $username;
                $model->round = $round;
                if($model->save()){
                    return $this->redirect(['eingabe/create', 'round' => $round]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model, 'runde' => $round
        ]);
    }

    /**
     * Deletes an existing Marktspiel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Marktspiel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Marktspiel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Marktspiel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
