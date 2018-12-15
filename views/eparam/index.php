<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EparamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Eparams');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eparam-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Eparam'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'value:ntext',
            [
                'attribute'=>'data_type',
                'filter'=>[ 'int' => 'Integer', 'double' => 'Double', 'varchar' => 'Character'],
            ],
            'data_type',
            'unit',
            'description',
            [
                'attribute'=>'type',
                'filter'=>[ 'parameter' => 'Parameter', 'other' => 'Others'],
            ],
            'type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
