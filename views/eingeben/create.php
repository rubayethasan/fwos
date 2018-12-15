<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Eingeben */

$this->title = Yii::t('app', 'Create Eingeben');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Eingebens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eingeben-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
