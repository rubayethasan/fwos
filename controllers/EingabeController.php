<?php

namespace app\controllers;

use app\Components\Generic;
use Yii;
use app\models\Eingabe;
use app\models\Testfragetrace;
use app\models\Evaluierung;
use app\models\EingabeSearch;
use app\Components\Ccontroller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * EingabeController implements the CRUD actions for Eingabe model.
 */
class EingabeController extends Ccontroller
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
                'only' => ['update','delete','index','view','ansehen','testfrage','neueingabe','rechnen','result','rangliste'],
                'rules' => [
                    /*[
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],*/
                    [
                        'allow' => true,
                        'actions' => ['update','delete','index','view','ansehen','testfrage','neueingabe','rechnen','result','rangliste'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Eingabe models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EingabeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Eingabe model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new Eingabe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($round)
    {
        $username = Generic::getCurrentuser(Yii::$app->user->id,'username');
        $eingabe = Eingabe::find()->where(['username' => $username,'round'=>$round])->one();
        if(!empty($eingabe)){
            return $this->redirect(['update', 'id' => $eingabe->id]);
        }

        $model = new Eingabe();
        if ($model->load(Yii::$app->request->post())) {
            $eingabe_post_data = Yii::$app->request->post("Eingabe");
            $field_arr = ['x0', 'x1', 'x2', 'e2', 'e5', 'x31', 'x32', 'lk', 'kk', 'zpf', 'zpp', 'vpf', 'vpp'];
            foreach($field_arr as $field){
                if(!isset($eingabe_post_data[$field]) || $eingabe_post_data[$field] == ''){
                    $model->$field = 0;
                }
            }
            $model->username = $username;
            $model->round = $round;
            if($model->save()){
                return $this->redirect(['ansehen', 'id' => $model->round]);
            }
        }

        $g = Generic::getCurrentuser(Yii::$app->user->id,'gruppe');
        $c1  = explode("#", Yii::$app->params['c1']); array_unshift( $c1, 0);
        $c2a = explode("#", Yii::$app->params['c2a']); array_unshift($c2a, 0);

        return $this->render('create', [
            'model' => $model, 'c1'=>$c1, 'c2a'=>$c2a, 'g'=>$g, 'round' => $round
        ]);
    }

    /**
     * Updates an existing Eingabe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $round = $model->round;

        if ($model->load(Yii::$app->request->post())) {

            $eingabe_post_data = Yii::$app->request->post("Eingabe");
            $field_arr = ['x0', 'x1', 'x2', 'e2', 'e5', 'x31', 'x32', 'lk', 'kk', 'zpf', 'zpp', 'vpf', 'vpp'];
            foreach($field_arr as $field){
                if(!isset($eingabe_post_data[$field]) || $eingabe_post_data[$field] == ''){
                    $model->$field = 0;
                }
            }
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $g = Generic::getCurrentuser(Yii::$app->user->id,'gruppe');
        $c1  = explode("#", Yii::$app->params['c1']); array_unshift( $c1, 0);
        $c2a = explode("#", Yii::$app->params['c2a']); array_unshift($c2a, 0);

        return $this->render('update', [
            'model' => $model, 'c1'=>$c1, 'c2a'=>$c2a, 'g'=>$g, 'round' => $round
        ]);

    }

    /**
     * Deletes an existing Eingabe model.
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
     * Finds the Eingabe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Eingabe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Eingabe::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Action for test frage steps
     * @param $round
     * @return string
     */
    public function actionTestfrage($round)
    {
        $username = Generic::getCurrentuser(Yii::$app->user->id,'username');
        if($round == 1){
            $model = Testfragetrace::find()->where(['username' => $username, 'round' => $round])->one();
            if(empty($model)){ // user not yet completed test levels
                return $this->render('testfrage',['round'=>$round]);
            }
        }elseif ($round == 8){
            $model = Evaluierung::find()->where(['username' => $username, 'round' => $round])->one();
            if(empty($model)){ // user not yet completed test levels
                return $this->render('evaluierung',['round'=>$round]);
            }
        }else{  // for round 3,6,9 test frage steps are same
            return $this->redirect(['marktspiel/create','round'=>$round]);
        }
        return $this->redirect(['create', 'round' => $round]);
    }

    /**
     * Action for creting new eingabe with test frage check
     * @param $id
     * @return \yii\web\Response
     */
    public function actionNeueingabe($id)
    {
        $round = $id;
        $test_frage_rounds = [1,3,6,8,9];  // these rounds has test frage steps

        if(in_array($round,$test_frage_rounds)){   // check if current round has test frage staeps
            return $this->redirect(['testfrage', 'round' => $round]);
        }
        return $this->redirect(['create', 'round' => $round]);   // for those round has no testfrage steps
    }


    /**
     * Action for producing result
     * @return string
     */
    public function actionRechnen(){

        $round = Yii::$app->params['rmax'];
        $rechnen = Generic::getEingabe($round);
        if(!empty($rechnen)){
            Generic::fowCalculation();
            return $this->render('rechnen',['round' => $round,'rechnen' => $rechnen]);
        }else{
            Yii::$app->session->setFlash('danger', "No data for this round.");
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Action for showing result
     * @return string
     */
    public function actionResult(){

        $users = Generic::getAllUserDetails(['id','username'],['rolle'=>'user', 'status' => '1']);
        return $this->render('result',['users' => $users]);
    }

    /**
     * action for showing ranglist
     * @return string
     */
    public function actionRangliste(){
        $round = Yii::$app->params['current_round'];
        $file_path = Yii::$app->basePath."/web/berichte/rangliste.html";
        if(file_exists($file_path)){
            $fd = file_get_contents($file_path);
            return $this->render('rangliste',['fd' => $fd,'round'=>$round]);
        }else{
            Yii::$app->session->setFlash('danger', "No rangliste calculated for this round.");
            return $this->redirect(['site/index']);
        }

    }

    /**
     * Displays Spielerbereich page.
     *
     * @return string
     */
    public function actionSpieler()
    {
        return $this->render('spieler');
    }

    /**
     * action for showing ranglist
     * @return string
     */
    public function actionBewertungen(){

        $evaluierung = Evaluierung::find()->asArray()->all();
        if(empty($evaluierung)){
            Yii::$app->session->setFlash('danger', "No data for this round.");
            return $this->redirect(['site/index']);
        }
        $user_details = Generic::getAllUserDetails(['user_id','username'],['rolle' => 'user','status' => '1']);
        $data =[];
        $data_header = [];
        $count = 1;
        foreach($user_details as $user){
            $eval_data = [];
            foreach ($evaluierung as $eval_each){
                if($user['username'] == $eval_each['username']){ // if user is active then the certain evaluering will be considered
                    unset($eval_each['id']);
                    $round = $eval_each['round'];
                    unset($eval_each['round']);
                    foreach($eval_each as $key => $value){
                        if($key == 'f4'){
                            $eval_data = Generic::makeFcolumn(['a','b','c','d','e'],$eval_each,$eval_data,'f4');
                            unset($eval_each['f4']);
                        }else if($key == 'f6'){
                            $eval_data = Generic::makeFcolumn(['a','b','c','d','e'],$eval_each,$eval_data,'f6');
                            unset($eval_each['f6']);
                        }else if($key == 'f7'){
                            $eval_data = Generic::makeFcolumn(['a','b','c'],$eval_each,$eval_data,'f7');
                            unset($eval_each['f7']);
                        }else if($key == 'username'){
                            $eval_data['name']= $eval_each[$key];
                        }else{
                            $eval_data[$key]= $eval_each[$key];
                        }
                    }
                    $eval_data = ['id' => $user['user_id']] + $eval_data;
                    $data[] = $eval_data;

                    if($count == 1){ //for genartring column name
                        $data_header = array_keys($eval_data);
                        $count++;
                    }
                }
            }
        }
        //echo '<pre>';print_r($data);die();
        return $this->render('bewertungen',['data' => $data,'data_header' => $data_header,'round' => $round]);
    }

    /**
     * action for viewing einagbe
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionAnsehen($id)
    {
        $round = $id;
        $username = Generic::getCurrentuser(Yii::$app->user->id,'username');
        $eingabe = Eingabe::find()->where(['username' => $username,'round'=>$round])->one();
        if(!empty($eingabe)){
            return $this->render('view', [
                'model' => $this->findModel($eingabe->id), 'round' => $round
            ]);
        }else{
            Yii::$app->session->setFlash('danger', "Bitte geben Sie zunüchst Daten ein. Danach können Sie sie sich auch ansehen.");
            return $this->redirect(['spieler']);
        }

    }

    /**
     * action for showing result for user end
     *
     */
    public function actionMitteilung($id){

        $round = $id;
        $name = Generic::getCurrentuser(Yii::$app->user->id,'username');
        $file_path = Yii::$app->basePath."/web/data/" . rawurlencode($name) . "_ausgabe_".$round.".html";
        if(file_exists($file_path)){
            $fd = file_get_contents($file_path);
            return $this->render('mitteilung', [
                'fd' => $fd
            ]);
        }else{
            Yii::$app->session->setFlash('danger', "Für diese Runde gibt es kein Ergebnis.");
            return $this->redirect(['spieler']);
        }

    }
}
