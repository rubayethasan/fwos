<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EvaluierungSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Evaluierungs';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Evaluierungs'), 'url' => ['index']];
?>
<div class="evaluierung-index">

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
            'f1:ntext',
            'f2:ntext',
            'f3:ntext',
            'f4:ntext',
            'f5:ntext',
            'f6:ntext',
            'f7:ntext',
            'f8:ntext',
            'f9:ntext',
            'f10:ntext',
            'f11:ntext',
            'f12:ntext',
            'f13:ntext',
            'XY1:ntext',
            'XY2:ntext',
            'XY3:ntext',
            'XY4:ntext',
            'XY5:ntext',
            'XY6:ntext',
            'XY7:ntext',
            'XY8:ntext',
            'XY9:ntext',
            'XY10:ntext',

            ['class' => 'yii\grid\ActionColumn','template' => '{delete}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
