<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 04.07.18
 * Time: 15:52
 */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'questionset'), 'url' => ['index']];

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

                                                        $option_type = $ans['option_type'];
                                                        foreach($ans['option'] as $option){

                                                            $option_number = $option['option_number']; ?>
                                                            <?php
                                                            $val = $option['single_ans_option_value_'.$option_number.'_'.$ans_number.'_'.$qn_number.'_'.$section_number];
                                                            $attr = '';
                                                            $text = '';
                                                            if($option_type != 'text'){
                                                                if($val == 'on')$attr = 'checked';
                                                                $text = $option['single_ans_option_text_'.$option_number.'_'.$ans_number.'_'.$qn_number.'_'.$section_number];
                                                            } ?>

                                                            <div class="col-md-4" style="text-align: center">
                                                                <input class="form-control" type="<?=$option_type?>" value="<?=$val?>" <?=$attr?> readonly disabled><?=$text?>
                                                            </div>

                                                        <?php } }?>
                                                </div>
                                            </div>
                                        <?php } } ?>
                                </div>
                            <?php } }?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php }






