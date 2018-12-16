<?php

/* @var $this yii\web\View */

$this->title = 'Feld, Wald oder Schweine Sommersemester 2019 Göttingen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="body-content">
            <div>
                <h3>Herzlich willkommen bei unserem Planspiel</h3>
            </div>
            <div>
                <div class="col-md-6">
                    <img src="<?=yii::$app->request->baseUrl?>/images/feld.jpeg" width= "80%" height = "350" alt="Feld">
                </div>
                <div class="col-md-6">
                    <img src="<?=yii::$app->request->baseUrl?>/images/wald.jpeg" width= "80%"  height = "350" alt="Feld">
                </div>
            </div>
            <div>
                <h3>oder</h3>
            </div>
            <div>
                <div class="col-md-6">
                    <img src="<?=yii::$app->request->baseUrl?>/images/stall.jpeg" width= 80%" height = "350" alt="Feld">
                </div>
            </div>
    </div>
</div>