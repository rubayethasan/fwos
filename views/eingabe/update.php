<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Eingabe */

$this->title = Yii::t('app', 'Update Eingabe: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
/*$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Eingabes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];*/
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="eingabe-update">
    <?= $this->render('_form', [
        'model' => $model, 'c1'=>$c1, 'c2a'=>$c2a, 'g'=>$g, 'round' => $round
    ]) ?>

</div>

