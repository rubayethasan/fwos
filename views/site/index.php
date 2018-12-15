<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">
            <div class = "col-lg-12">
                <h3>Herzlich willkommen bei unserem Planspiel</h3>
            </div>
            <div class = "col-lg-12 ">
                <div class="col-lg-6">
                    <img src="<?=yii::$app->request->baseUrl?>/images/feld.jpeg" width= "80%" height = "350" alt="Feld">
                </div>
                <div class="col-lg-6">
                    <img src="<?=yii::$app->request->baseUrl?>/images/wald.jpeg" width= "80%"  height = "350" alt="Feld">
                </div>
            </div>
            <div class = "col-lg-12">
                <h3>oder</h3>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <img src="<?=yii::$app->request->baseUrl?>/images/stall.jpeg" width= 80%" height = "350" alt="Feld">
                </div>
            </div>
    </div>
</div>