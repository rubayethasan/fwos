<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Eparam */

$this->title = Yii::t('app', 'Create Essential Parameters');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Eparams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eparam-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
