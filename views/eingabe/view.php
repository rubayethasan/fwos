<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Eingabe */

/*$this->title = $model->id;*/
$this->title = Yii::t('app', 'Ansehen');
/*$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Eingabes'), 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="eingabe-view">

    <h3>Eingabeprotokoll einer früheren Runde.</h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'username',
            'round',
            'x0',
            'x1',
            'x2',
            'e2',
            'e5',
            'x31',
            'x32',
            'q',
            'lk',
            'kk',
            'zpf',
            'zpp',
            'vpf',
            'vpp',
        ],
    ]) ?>

</div>
