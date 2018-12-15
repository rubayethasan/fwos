<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Benutzer */

$this->title = Yii::t('app', 'Update Benutzer: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Benutzers'), 'url' => ['index']];
/*$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];*/
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$model->password = '';
?>
<div class="benutzer-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
