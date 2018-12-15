<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 05.06.18
 * Time: 05:56
 */
$this->title = 'Eingeben';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'spieler'), 'url' => ['site/spieler']];
$this->params['breadcrumbs'][] = $this->title;

if(isset($data) && !empty($data)){?>
    <div class="preview-answers-form">
        <div class="preview-top-heading">
            <h3>Round: <?=$data['round']?></h3>
        </div>
        <div class="preview-form-heading">
            <h3>Bitte beachten Sie:</h3>
            <h4><?=$data['additional_description']?></h4>
        </div>
        <div class="preview-form-body">
            <form action="javascript:void(0);" id="section-set-form" onsubmit="prviewEingeben(this)">
            <!--<form method="post">-->
                <input type="hidden" name="round" value="<?=$data['round']?>">
                <?php foreach($data['section'] as $section_data){
                    $section_number = $section_data['section_number'];
                    ?>
                    <div class="preview-individual-section-container">
                        <h3><?=$section_number?> . <?=$section_data['section_title_'.$section_number]?></h3>
                        <!--<h3><?/*=$section_data['section_description_'.$section_number]*/?></h3>-->
                        <div class="preview-questions-container">

                            <?php if(isset($section_data['qn']) && !empty($section_data['qn'])){
                                foreach($section_data['qn'] as $qn){
                                    $qn_number = $qn['qn_number'];
                                    ?>
                                    <div class = "preview-ans-container row">
                                        <h4><?/*=$qn_number*/?><!-- . --><?=$qn['single_qn_'.$qn_number.'_'.$section_number]?></h4>
                                        <?php
                                        if(isset($qn['ans']) && !empty($qn['ans'])){
                                            foreach($qn['ans'] as $ans){

                                                $ans_number = $ans['ans_number']
                                                ?>
                                                <div class = "preview-option-container col-md-12">
                                                    <div class="col-md-4">
                                                        <h5><?/*=$ans_number*/?><!-- . --><?=$ans['single_ans_'.$ans_number.'_'.$qn_number.'_'.$section_number]?></h5>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <?php if(isset($ans['option']) && !empty($ans['option'])){

                                                            $option_type = ($ans['option_type'] != 'text')? $ans['option_type']: 'number';
                                                            foreach($ans['option'] as $option){

                                                                $option_number = $option['option_number']; ?>
                                                                <?php
                                                                $req = 'required';
                                                                $val = $option['single_ans_option_value_'.$option_number.'_'.$ans_number.'_'.$qn_number.'_'.$section_number];
                                                                $name = 'single_ans_option_value_'.$option_number.'_'.$ans_number.'_'.$qn_number.'_'.$section_number;
                                                                $input_id = 'single_ans_option_id-'.$option_number.'_'.$ans_number.'_'.$qn_number.'_'.$section_number;
                                                                $attr = '';
                                                                $disabled = '';
                                                                $text = '';

                                                                if($option_type != 'number'){ // for radio button and checkbox
                                                                    if($val == 'on' && isset($preview))$attr = "checked='checked'";
                                                                    $text = $option['single_ans_option_text_'.$option_number.'_'.$ans_number.'_'.$qn_number.'_'.$section_number];
                                                                    if($option_type == 'radio'){
                                                                        $name = 'single_ans_option_value_radio_'.$ans_number.'_'.$qn_number.'_'.$section_number;
                                                                    }
                                                                    if($option_type == 'checkbox'){ // for checkbox no required needed
                                                                        $req = '';
                                                                    }
                                                                    $range = '';
                                                                    $placeholder ='';
                                                                }else{ // for text box range value
                                                                    $val_arr = explode('-',$val);
                                                                    $range = "min = '".$val_arr[0]."' max = '".$val_arr[1]."'";
                                                                    $placeholder = "placeholder='". $val_arr[0] . "-" .$val_arr[1]."'";

                                                                }

                                                                if(isset($preview)){ // for preview section
                                                                    $disabled = 'disabled';
                                                                }
                                                                ?>

                                                                <div class="col-md-4" style="text-align: center">
                                                                    <input id="<?=$input_id?>" class="form-control" name="<?=$name?>" type="<?=$option_type?>" <?=$range?> <?=$req?> <?=$attr?> <?=$disabled?> <?=$placeholder?>><?=$text?>
                                                                </div>

                                                            <?php }
                                                        }?>
                                                    </div>
                                                </div>
                                            <?php } } ?>
                                    </div>
                                <?php } }?>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-footer">
                    <input type="submit" value="Preview" class="btn btn-info">
                </div>

            </form>
            <input type="button" id ="eingeben-preview-button" data-toggle="modal" data-target="#eingeben-preview-popup-modal" value="preview" style="display:none">
        </div>
    </div>
<?php } ?>

<div id="eingeben-preview-popup-modal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Your feedback</h4>
            </div>

            <div class="modal-body" id="eingeben-preview-popup-body">

            </div>

            <div class="modal-footer">
                <div class="btn btn-info" data-dismiss="modal">Edit</div>
                <div class="btn btn-success" data-dismiss="modal" onclick=saveEingebenData()>Save</div>
            </div>

        </div>
    </div>

</div>
