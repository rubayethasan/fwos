<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\Components\Generic;

/* @var $this yii\web\View */
/* @var $model app\models\Benutzer */

$this->title = $model->name;
/*$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Benutzers'), 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
$user_role = Generic::getCurrentuser(Yii::$app->user->id,'rolle');
?>
<div class="benutzer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($user_role == 'admin'){ ?>

        <div class="alert-danger">
            <h4>WARNUNG! Das Löschen eines angemeldeten Teilnehmers sollte nur vor der 1. Runde geschehen! Sonst kann der fehlerfreie Ablauf des Planspiels nicht garantiert werden.</h4>
        </div>
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'user_id',
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
            //'password',
            //'rolle',
            //'status',
        ],
    ]) ?>

</div>
