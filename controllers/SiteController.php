<?php

namespace app\controllers;

use app\models\Benutzer;
use app\models\Questionset;
use Yii;
use yii\filters\AccessControl;
//use yii\web\Controller;
use app\Components\Ccontroller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\Components\Generic;

class SiteController extends Ccontroller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionOpenpdf()
    {
        $filename = 'spielbeschreibung.pdf';
        $storagePath = Yii::getAlias('@app/web/files/pdf');
        return Yii::$app->response->sendFile("$storagePath/$filename", $filename, ['inline'=>true]);
     }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionPreview(){
        $data = Yii::$app->request->post('all_data');
        return $this->renderPartial('preview',['data' => $data]);
    }

    public function actionStoredata(){
        $response = false;
        $data = Yii::$app->request->post('processed_data');
        $model = new Questionset();
        $model->round = $data['round'];
        $model->qn_des = $data['additional_description'];
        $model->qn_ans = json_encode($data);
        $model->create_date = date("Y-m-d H:i:s");
        //$model->created_by = Generic::getCurrentuser(Yii::$app->user->id,'username');
        if($model->save()){
            $response = true;
        }
        return $response;
    }

    public function actionCheckqnexists(){
        $response = false;
        $round = Yii::$app->request->post('round');
        $user = Questionset::find()->where(["round" => $round])->asArray()->one();
        if(!empty($user)){
            $response = true;
        }
        return $response;
    }
}
