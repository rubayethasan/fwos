<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Eingabe */

$this->title = Yii::t('app', 'Create Eingabe');
/*$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Eingabes'), 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eingabe-create">
    <?= $this->render('_form', [
        'model' => $model, 'c1'=>$c1, 'c2a'=>$c2a, 'g'=>$g ,'round' => $round
    ]) ?>

</div>
