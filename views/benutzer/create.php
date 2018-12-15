<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Benutzer */

$this->title = Yii::t('app', 'Anmeldung zu einem Planspiel');
$this->params['breadcrumbs'][] = $this->title;
$model->regel = 'ja';
$model->kenntnisse = 3;
?>
<div class="benutzer-create">

    <div class="benutzer-create-heading">
        <h3><?= Html::encode($this->title) ?></h3>
        <h4><?= Html::encode('An den Planspielen des Departments für Agrarökonomie und Rurale Entwicklung darf nur teilnehmen, wer sich dafür angemeldet hat.') ?></h4>
    </div>

    <div class ='user-form'>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>


</div>
