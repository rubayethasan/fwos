<?php

namespace app\controllers;

use app\Components\Generic;
use Yii;
use app\models\Eingeben;
use app\models\Questionset;
use app\models\EingebenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EingebenController implements the CRUD actions for Eingeben model.
 */
class EingebenController extends Controller
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
     * Lists all Eingeben models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EingebenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Eingeben model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Eingeben model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Eingeben();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionNeueingeben($id)
    {
        $qnset = Questionset::find()
            ->where(["round" => $id])
            ->asArray()
            ->one();

        if(!empty($qnset)){
            return $this->render('neueingeben', [
                'data' => json_decode($qnset['qn_ans'],true),
            ]);
        }else{
            Yii::$app->session->setFlash('danger', "No Question Set yet for round ". $id);
            return $this->redirect(['site/spieler']);
        }
    }

    public function actionEingabe()
    {
        $model = new Eingeben();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('eingabe', [
            'model' => $model,
        ]);
    }

    public function actionPrevieweingeben()
    {
        $data = Yii::$app->request->post('eingeben_data');

        $qn_set = Generic::getQnSet($data['round']);
        $processed_eingeben_data = Generic::processEingenenData($qn_set,$data);

        return $this->renderPartial('previeweingeben', [
            'data' => $processed_eingeben_data,
        ]);
    }

    public function actionAnsehen($id)
    {
        $eingeben = Eingeben::find()
            ->where(["round" => $id])
            ->asArray()
            ->one();

        if(!empty($eingeben)){
            return $this->render('ansehen', [
                'data' => json_decode($eingeben['qn_ans'],true),
                'user_name' => $eingeben['user_name'],
                'user_id' => $eingeben['user_id'],
                'role' => Generic::getCurrentuser(Yii::$app->user->id,'rolle')
            ]);
        }else{
            Yii::$app->session->setFlash('danger', "You did not made a feedback yet for round ". $id);
            return $this->redirect(['site/spieler']);
        }
    }

    public function actionStoreeingebendata()
    {
        $response = false;
        $data = Yii::$app->request->post('processed_eingeben_data');

        $qn_set = Generic::getQnSet($data['round']);
        $processed_eingeben_data = Generic::processEingenenData($qn_set,$data);

        $round = $processed_eingeben_data['round'];
        $user_id = Yii::$app->user->id;

        $eingeben = Generic::getEingeben($round,$user_id);
        if(!empty($eingeben)){ //checking for existing entry

            $model = $this->findModel($eingeben["id"]);
            $model->qn_ans = json_encode($processed_eingeben_data);
            $model->update_date = date("Y-m-d H:i:s");
            $model->updated_by = Generic::getCurrentuser($user_id,'username');

        }else{ //for the first entry

            $model = new Eingeben();
            $model->user_id = Yii::$app->user->id;
            $model->user_name = Generic::getCurrentuser($user_id,'username');
            $model->round = $round;
            $model->qn_ans = json_encode($processed_eingeben_data);
            $model->create_date = date("Y-m-d H:i:s");
            $model->created_by = Generic::getCurrentuser($user_id,'username');

        }

        if($model->save()){
            $response = true;
        }
        return $response;

        /*return $this->renderPartial('test', [
            'qn_set' => $qn_set,
            'data' => $processed_eingeben_data,
        ]);*/

        //return array_diff($qn_set,$processed_eingeben_data);
    }

    /**
     * Updates an existing Eingeben model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Eingeben model.
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
     * Finds the Eingeben model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Eingeben the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Eingeben::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
