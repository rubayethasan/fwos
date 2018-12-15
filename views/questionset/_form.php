<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Questionset */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questionset-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'round')->textInput() ?>

    <?= $form->field($model, 'qn_des')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'qn_ans')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <?= $form->field($model, 'update_date')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
