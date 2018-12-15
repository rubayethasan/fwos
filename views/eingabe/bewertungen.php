<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 21.09.18
 * Time: 23:46
 */
use yii\helpers\Html;
$this->title = Yii::t('app', 'Bewertungen');
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h3><?= Html::encode('Bewertungen. Runde: ') ?><?=$round?></h3>
    <table class="table table-striped table-result">
        <thead>
        <tr>
            <?php
            foreach($data_header as $header){?>
                <th><?=$header?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($data as $row){?>
            <tr>
                <?php
                foreach ($row as $val){
                    ?>

                    <td><?=$val?></td>

                    <?php
                } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

