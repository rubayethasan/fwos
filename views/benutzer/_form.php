<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use app\Components\Generic;

/* @var $this yii\web\View */
/* @var $model app\models\Benutzer */
/* @var $form yii\widgets\ActiveForm */

$user_role = Generic::getCurrentuser(Yii::$app->user->id,'rolle');

?>

<div class="benutzer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-lg-12 form-heading">
        <?= HTML::label("Es ist nicht erlaubt, mit mehr als einer Identität an diesem Planspiel teilzunehmen. Ein Verstoß gegen diese Regel führt zur unmittelbaren Disqualifikation")?>
    </div>

    <div class="col-lg-12 form-body">
        <div class="col-lg-6">

            <?= $form->field($model, 'regel')->radioList([ 'ja' => 'ja', 'nein' => 'nein'])->label('Ich habe diese Regel gelesen und akzeptiere sie')?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder' => "Name ist erforderlich"])?>

            <?= $form->field($model, 'vorname')->textInput(['maxlength' => true,'placeholder' => "Vorname ist erforderlich"])?>

            <?= $form->field($model, 'geschlecht')->radioList([ 'M' => 'männlich', 'W' => 'weiblich'])?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true,'placeholder' => "example@example.com"]) ?>

            <?= $form->field($model, 'studienfach')->dropDownList(['' => 'Bitte auswählen', 'Forstökonomie und Forsteinrichtung' => 'Forstökonomie und Forsteinrichtung','Agrarökonomie und Rurale Entwicklung' => "Agrarökonomie und Rurale Entwicklung"])->label('Welches Fach studieren Sie?') ?>

        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'semester')->dropDownList(['' => 'Bitte auswählen', 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16 ])->label('In welchem Hochschulsemester studieren Sie?')?>

            <?= $form->field($model, 'kenntnisse')->radioList([ 1 => 'sehr gut', 2 => 'gut', 3 => 'mittelmäßig', 4 => 'weniger gut', 5 => ' nicht gut', ])->label('Wie schätzen Sie selbst Ihre ökonomischen Fähigkeiten und Kenntnisse ein?') ?>

            <?= $form->field($model, 'username')->textInput(['maxlength' => true,'placeholder' => "Benutzername ist erforderlich"]) ?>

            <?php if(Yii::$app->controller->action->id == 'create'){?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => "Mindestens 6 Zeichen enthalten"]) ?>

                <?= $form->field($model, 'password_wiederholen')->passwordInput(['placeholder' => "Wie oben beschriebenes Passwort"]) ?>
            <?php }

            if($user_role == 'admin'){
                echo $form->field($model, 'rolle')->radioList([ 'admin' => 'admin', 'user' => 'user']);
                echo $form->field($model, 'status')->radioList([ 1 => "Active", 0 => "Inactive"]) ;
            }
            ?>
        </div>

    </div>

    <div class="col-lg-12 form-instruc">
        <p>Ihr Login-Name und Ihr Passwort gelten nur für dieses Spiel. Sie haben nichts mit Ihren Legitimationen anderen Rechnern gegenüber zu tun. Bitte beachten Sie, dass bei beiden Zeichenketten die Groß-/Kleinschreibung von Bedeutung ist.</p>
        <p>Der Evaluierungsbogen soll uns helfen, das Planspiel in Zukunft noch besser zu gestalten.</p>
        <p><b>Datenschutzerklärung:</b> Wir versichern, dass Ihre persönlichen Daten vertraulich behandelt werden, nicht an Dritte weitergegeben werden und ausschließlich in Verbindung mit dem Planspiel an der Georg-August-Universität Göttingen Verwendung finden.</p>
    </div>


    <div class="form-footer">
        <?= Html::submitButton(Yii::t('app', 'abschicken'), ['class' => 'btn btn-lg btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="col-lg-12 form-instruc">
        <h3>Vielen Dank!</h3>
    </div>

</div>
