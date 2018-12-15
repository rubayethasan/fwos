<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Marktspiel */

$this->title = 'Marktspiel';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marktspiel-create">

    <?= $this->render('_form', [
        'model' => $model, 'runde' => $runde
    ]) ?>

</div>
