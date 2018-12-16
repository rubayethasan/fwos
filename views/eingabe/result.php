<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 21.09.18
 * Time: 03:35
 */
use yii\helpers\Html;

$this->title = Yii::t('app', 'Result');
$this->params['breadcrumbs'][] = $this->title;

for($i = 1; $i <= Yii::$app->params['rmax']; $i++){
    $round[$i] = $i;
}
foreach($users as $user){
    $name[$user['username']] = $user['username'];
}
?>

<div>
    <div class="benutzer-create-heading">
        <h3>Ein- & Ausgabe </h3>
    </div>

    <?= Html::beginForm('Javascript:void(0)','get',['onsubmit'=>'loadResult(this)']) ?>
    <div class='col-md-12' style="background-color: lightgrey; padding:5px">
        <div class="col-md-4">
            <?= Html::dropDownList('round',[], $round,['class' => 'form-control','prompt' => ' -- Runde --', 'required' => true])?>
        </div>

        <div class="col-md-4">
            <?= Html::dropDownList('name',[],$name,['class' => 'form-control','prompt' => ' -- Name --','required' => true])?>
        </div>

        <div class="col-md-4">
            <?= Html::radioList('result_type',[],
                [
                    '1' => 'Eingabe',
                    '2' => 'Ausgabe',

                ],['class' => 'form-control','required']
            )?>
        </div>
    </div>
    <div class="form-group form-footer">
        <?= Html::submitButton('Ansehen', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
</div>

<div id="result-container">

</div>
