<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Eparam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eparam-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-lg-12 form-body">
        <div class="col-lg-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'value')->textInput() ?>

            <?= $form->field($model, 'data_type')->radioList([ 'int' => 'Integer', 'double' => 'Double', 'varchar' => 'Character']) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'type')->radioList([ 'parameter' => 'Parameter', 'other' => 'Others']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
