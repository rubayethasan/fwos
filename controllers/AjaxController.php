<?php

namespace app\controllers;

use app\Components\Generic;
use Yii;
use app\models\Testfragetrace;
use app\models\Evaluierung;
use app\models\Eingabe;
class AjaxController extends \yii\web\Controller
{
    /**
     * Ajax action for checking and storing rounds in test frage trace table
     * @return bool
     */
    public function actionTestfragecompletion()
    {
        $response = false;
        if (Yii::$app->request->post('round')) {
            $model =new Testfragetrace();

            $model-> round = Yii::$app->request->post('round');;
            $model-> username = Generic::getCurrentuser(Yii::$app->user->id,'username');;
            if($model->save()){
                $response = true;
            }
        }
        return $response;
    }

    /**
     * ajax action for storing evaluering data
     * @return bool
     */
    public function actionStoreeval(){

        $response = false;

        if (Yii::$app->request->post('round')) {
            $evaluiering_data = Yii::$app->request->post('evaluiering_data');
            $eval_processed = [];
            $f4 = [];
            $f6 = [];
            foreach($evaluiering_data as $eval_data){
                foreach($eval_data as $data){
                    if($data['name'] == 'f4[]'){
                        $f4[]=$data['value'];
                    }else if($data['name'] == 'f6[]'){
                        $f6[]=$data['value'];
                    }else{
                        $eval_processed[$data['name']] = $data['value'];
                    }
                }
            }
            $f7 = [$eval_processed['text1f7'],$eval_processed['text2f7'], $eval_processed['text3f7']];

            $round = Yii::$app->request->post('round');
            $model = new Evaluierung();
            $model-> round = $round;
            $model-> username = Generic::getCurrentuser(Yii::$app->user->id,'username');
            $model-> f1 = $eval_processed['f1'];
            $model-> f2 = $eval_processed['f2'];
            $model-> f3 = $eval_processed['f3'];
            $model-> f4 = json_encode($f4);
            $model-> f5 = $eval_processed['f5'];
            $model-> f6 = json_encode($f6);
            $model-> f7 = json_encode($f7);
            $model-> f8 = $eval_processed['f8'];
            $model-> f9 = $eval_processed['f9'];
            $model-> f10 = $eval_processed['f10'];
            $model-> f11 = $eval_processed['f11'];
            $model-> f12 = $eval_processed['f12'];
            $model-> f13 = $eval_processed['f13'];
            $model-> XY1 = $eval_processed['XY1'];
            $model-> XY2 = $eval_processed['XY2'];
            $model-> XY3 = $eval_processed['XY3'];
            $model-> XY4 = $eval_processed['XY4'];
            $model-> XY5 = $eval_processed['XY5'];
            $model-> XY6 = $eval_processed['XY6'];
            $model-> XY7 = $eval_processed['XY7'];
            $model-> XY8 = $eval_processed['XY8'];
            $model-> XY9 = $eval_processed['XY9'];
            $model-> XY10 = $eval_processed['XY10'];

            if($model->save()){
                $response = true;
            }
        }
        return $response;
    }

    /**
     * ajax action for loading result
     * @return bool|string
     */
    public function actionLoadresult(){

        $fd = '';
        $round = Yii::$app->request->post('round');
        $name= Yii::$app->request->post('name');
        $type = Yii::$app->request->post('type');
        if($type==2){
            $file_path = Yii::$app->basePath."/web/data/" . rawurlencode($name) . "_ausgabe_".$round.".html";
            if(file_exists($file_path)){
                $fd = file_get_contents($file_path);
            }
        }else{
            $eingabe = Eingabe::find()->where(['username' => $name,'round'=>$round])->one();
            if(!empty($eingabe)){
                return $this->renderPartial('//eingabe/view', [
                    'model' => Eingabe::findOne($eingabe->id), 'round' => $round ,'ref' => 'res'
                ]);
            }
        }
        return $fd;
    }
}
