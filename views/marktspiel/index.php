<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MarktspielSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Marktspiels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marktspiel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'round',
            'VK1',
            'VK2',
            'VK3',
            'VK4',
            'VK5',
            'VK6',
            'VK7',
            'VK8',
            'VK9',
            'VK10',
            'VK11',
            'VK12',
            'VK13',
            'VK14',
            'VK15',
            'VK16',
            'VK17',

            ['class' => 'yii\grid\ActionColumn','template' => '{delete}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
