<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\Components\Generic;

$this->title = 'Spielerbereich';
$this->params['breadcrumbs'][] = $this->title;
$total_round = Yii::$app->params['total_round'];
$current_round = Yii::$app->params['rmax'];
?>

<div class="site-spieler">
    <h3><?= Html::encode('Willkommen im Spielerbereich') ?></h3>

    <div style="background-color: lightblue;padding: 10px; margin-bottom: 15px;">
        <div style="text-align: right"><?= Html::a('Spielanleitung', ['site/openpdf'], ['class' => 'btn btn-primary', 'target' => '_blank',]); ?></div>
        <p>Hier haben Sie die Möglichkeit,</p>
        <ul>
            <li>Ihre bisherigen Eingaben noch einmal zu lesen,</li>
            <li>die daraufhin erfolgten persönlichen Mitteilungen einzusehen und / oder</li>
            <li>Ihre Eingaben für die laufende und künftige Runden vorzunehmen.</li>
        </ul>
        <p>Bitte wählen Sie!</p>
    </div>

    <table class="table custom-tbl">
            <thead>
            <tr>
                <th class="custom-tbl-header">Runde</th>
                <th class="custom-tbl-header">Eingabe</th>
            </tr>
            </thead>
            <tbody>


            <?php
            $tr_class = '';
            $inside_tbl_class = 'table-hover';
            $anchor_class='';
            $eingeben_anchor_class='';
            $ansehen_class = 'info';
            $eingeben_class = 'success';
            $mitteilung_class ='info';
            for($i=1; $i<=$total_round; $i++) {
                if($i != $current_round ){ //for eingeben
                    $eingeben_class = 'cutom-td-deactivate';
                    $eingeben_anchor_class = 'not-active';
                }else{
                    $eingeben_class = '';
                    $eingeben_anchor_class = '';
                }

                if($i > $current_round ){ //for ansehen
                    $ansehen_class = 'cutom-td-deactivate';
                    $ansehen_anchor_class = 'not-active';
                    $tr_class = 'custom-tr-deactive';
                    $inside_tbl_class = '';

                }else{
                    $ansehen_class = '';
                    $ansehen_anchor_class = '';
                }

                if($i >= $current_round ){ //for mitteilung
                    $mitteilung_class = 'cutom-td-deactivate';
                    $mitteilung_anchor_class = 'not-active';
                }else{
                    $mitteilung_class = '';
                    $mitteilung_anchor_class = '';
                }

                ?>
                <tr class =" <?= $tr_class ?>">
                    <td><?= $i ?></td>
                    <td>
                        <table class="table <?=$inside_tbl_class?>">
                            <tr>
                                <td class="<?=$ansehen_class?>">
                                    <!--<a class="<?/*=$ansehen_anchor_class*/?>" href="<?/*=Yii::$app->request->baseUrl.'/eingeben/ansehen/'.$i*/?>">ansehen</a>-->
                                    <a class="<?=$ansehen_anchor_class?>" href="<?=Yii::$app->request->baseUrl.'/eingabe/ansehen/'.$i?>">ansehen</a>
                                </td>
                                <td class="<?=$eingeben_class?>">
                                    <!--<a class="<?/*=$eingeben_anchor_class*/?>" href="<?/*=Yii::$app->request->baseUrl.'/eingeben/neueingeben/'.$i*/?>">eingeben</a>-->
                                    <a class="<?=$eingeben_anchor_class?>" href="<?=Yii::$app->request->baseUrl.'/eingabe/neueingabe/'.$i?>">eingeben</a>
                                </td>
                                <td class="<?=$mitteilung_class?>">
                                    <a class="<?=$mitteilung_anchor_class?>" href="<?=Yii::$app->request->baseUrl.'/eingabe/mitteilung/'.$i?>">Mitteilung</a>
                                </td>
                            </tr>
                        </table>
                    </td>

                </tr>
            <?php } ?>

            </tbody>
        </table>

</div>
