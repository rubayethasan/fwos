<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BenutzerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Benutzers');
$this->params['breadcrumbs'][] = ['label' => 'Benutzers', 'url' => ['index']];
?>
<div class="benutzer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <div class="alert-danger">
        <h4>WARNUNG! Das Löschen eines angemeldeten Teilnehmers sollte nur vor der 1. Runde geschehen! Sonst kann der fehlerfreie Ablauf des Planspiels nicht garantiert werden.</h4>
    </div>
    <p>
        <?= Html::a(Yii::t('app', 'Create Benutzer'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'regel',
            'name',
            'gruppe',
            'vorname',
            'geschlecht',
            'email:email',
            'studienfach',
            'semester',
            'kenntnisse',
            'username',
            'password',
            'rolle',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
