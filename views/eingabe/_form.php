<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Eingabe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eingabe-form">
    <div class="col-lg-12 benutzer-create-heading">
        <h4>Bitte beachten Sie:</h4>
        <p>Der Anbau, die Düngung usw. von Silomais kostet       <?=$c1[$g]?> €/ha </p>
        <p>Der Anbau, die Düngung usw. von Kurzumtrieb kostet    <?=$c2a[$g]?> €/ha</p>
    </div>
    <div class="col-lg-12 eingabe-form-heading">
        <h4>Diese Eingaben sind für Runde <?=$round?></h4>
    </div>

    <?php $form = ActiveForm::begin(); ?>
    <div class='col-lg-12 form-body'>
        <div class="eingabe-section">
            <div>
                <h4>1. Produktion</h4>
                <p>Bitte geben Sie ein, welche Fläche (in ha) Sie mit der jeweiligen Produktion in Betrieb nehmen möchten!</p>
            </div>
            <div>
                <?= $form->field($model, 'x0')->textInput()->label('Flächenstilllegung') ?>
                <?= $form->field($model, 'x1')->textInput()->label('Mais') ?>
                <?= $form->field($model, 'x2')->textInput()->label('Kurzumtrieb') ?>
            </div>
        </div>

        <div class="eingabe-section">
            <div>
                <h4>2. Kurzumtrieb-Ernte</h4>
                <p>Welche Fläche (in ha) Kurzumtrieb möchten Sie abernten?</p>
            </div>
            <div>
                <?= $form->field($model, 'e2')->textInput()->label('Kurzumtrieb') ?>
            </div>
        </div>
        <div class="eingabe-section">
            <div>
                <h4>3. Forstbewirtschaftung</h4>
            </div>
            <div>
                <?= $form->field($model, 'e5')->textInput()->label('Wie viel Holz (in Festmetern) möchten Sie ernten?') ?>
            </div>
        </div>
        <div class="eingabe-section">
            <div>
                <h4>4. Schweinemast</h4>
            </div>
            <div>
                <?= $form->field($model, 'x31')->textInput()->label('Wie viele Schweinemastställe à '.number_format(Yii::$app->params['aw3'], 0, ",", ".").' € möchten Sie bauen?') ?>
                <?= $form->field($model, 'x32')->textInput()->label('Wie viele Schweinemastplätze möchten Sie für je '.number_format(Yii::$app->params['c32'], 0, ",", ".").' € belegen?') ?>
            </div>
        </div>
        <div class="eingabe-section">
            <div>
                <h4>5. Maschine</h4>
                <p>Zur Bestellung und zur Ernte benötigen Sie zwingend Maschinen!</p>
            </div>
            <div>
                <?= $form->field($model, 'q')->radioList(['J'=>'ja','N'=>'nein'])->label('Möchten Sie entsprechende Maschinen kaufen?') ?>
            </div>
        </div>
        <div class="eingabe-section">
            <div></div>
            <div>
                <h4>6. Fremdkapital</h4>
                <p>Bitte geben Sie ein, wie viel Fremdkapital (in €) Sie verwenden möchten!</p>
            </div>
            <div>
                <?= $form->field($model, 'lk')->textInput()->label('Annuitätendarlehen') ?>
                <?= $form->field($model, 'kk')->textInput()->label('kurzfristiges Darlehen') ?>
            </div>
        </div>
        <div class="eingabe-section">
            <div>
                <h4>7. Pachtmarkt</h4>
            </div>
            <div>
                <?= $form->field($model, 'zpf')->textInput()->label('zupachten Fläche') ?>
                <?= $form->field($model, 'zpp')->textInput()->label('zupachten Preis') ?>
                <?= $form->field($model, 'vpf')->textInput()->label('verpachten Fläche') ?>
                <?= $form->field($model, 'vpp')->textInput()->label('verpachten Preis') ?>
            </div>
        </div>
    </div>
    <div class="col-lg-12 form-group form-footer">

        <?= Html::resetButton(Yii::t('app', 'löschen'), ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton(Yii::t('app', 'weiter'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
