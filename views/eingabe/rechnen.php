<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 20.09.18
 * Time: 02:27
 */
use yii\helpers\Html;

$this->title = Yii::t('app', 'Rechen');
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h3><?= Html::encode('Feld oder Wald. Runde: ') ?><?=$round?></h3>
    <table class="table table-striped table-result">
        <thead>
        <tr>
            <?php
            foreach($rechnen[0] as $key => $val){
                if($key != 'id' && $key != 'round'){?>

                    <th><?=$key?></th>

                <?php } } ?>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($rechnen as $rech){?>
            <tr>
                <?php
                foreach ($rech as $key => $val){
                    if($key != 'id' && $key != 'round'){
                        if($key == 'm'){ // translating value  J = 1 and N = 0
                            if($val == 'J') $val = 1;
                            if($val == 'N') $val = 0;
                        } ?>
                        <td><?=$val?></td>
                    <?php }
                }
                ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>
