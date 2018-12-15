<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Questionset */

$this->title = Yii::t('app', 'Create Questionset');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questionsets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionset-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
