<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Questionset */

$round = Yii::$app->params['total_round'];
$this->title = Yii::t('app', 'Create Questionset');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questionsets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="answers-form">

    <form action="javascript:void(0);" id="section-set-form" onsubmit="getData(this)">

        <div class="form-heading  col-md-12">
            <div class="col-md-4">
                <label>Round Number</label>
            </div>
            <div class="col-md-8">
                <select class="form-control" name="round" required onchange="checkQn(this)">
                    <option value="">Please Select Round Number</option>
                    <?php
                    for($i = 1; $i <= $round; $i++){?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php }
                    ?>

                </select>
            </div>
        </div>

        <div class="form-additional-body  col-md-12">
            <label>Additional Description</label>
            <textarea class="form-control"  name="additional_description" required></textarea>
        </div>

        <div class="form-body  col-md-12" id="all-section-container"></div>

        <div class="form-footer  col-md-12">
            <div class="col-md-8">
                <input type="submit" class="btn btn-success" style="display:none" id="submit-btn" value="Preview Question Set" >
            </div>
            <div class="col-md-2">
                <?= Html::button(Yii::t('app', 'Generate New Section'), ['class' => 'btn btn-primary', 'id' => 'add-new-section', 'onclick' => "addSection()"]) ?>
            </div>
            <div class="col-md-2">
                <?= Html::button(Yii::t('app', 'Remove Last Section'), ['class' => 'btn btn-danger', 'style'=>"display:none", 'id' => 'remove-last-section', 'onclick' => "removeSection()"]) ?>
            </div>

        </div>

    </form>
    <input type="button" id ="preview-button" data-toggle="modal" data-target="#preview-popup-modal" value="preview" style="display:none">
</div>

<div id="preview-popup-modal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">The user will see the question set as presented below.</h4>
            </div>

            <div class="modal-body" id="preview-popup-body">

            </div>

            <div class="modal-footer">
                <div class="btn btn-info" data-dismiss="modal">Edit</div>
                <div class="btn btn-success" data-dismiss="modal" onclick=saveData()>Save</div>
            </div>

        </div>
    </div>

</div>



