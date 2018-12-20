<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 22.08.18
 * Time: 03:56
 */
use yii\helpers\Html;
$this->title = Yii::t('app', 'Forsternteexperiment');
$this->params['breadcrumbs'][] = $this->title;

$zins_eigenkapital = Yii::$app->params['zins_eigenkapital'];
$Preis_Mais = Yii::$app->params['Preis_Mais'];
$Preis_HHS = Yii::$app->params['Preis_HHS'];
$Preis_Fleisch = Yii::$app->params['Preis_Fleisch'];
$preis_string = $Preis_Mais.'_'.$Preis_HHS.'_'.$Preis_Fleisch;
?>

    <!------------------------------------------------Top progress tab---------------------------------------------------------->
<div class="porogress-tab-bar">
    <?php for($i = 1; $i <= 4; $i++){?>
        <div class="porogress-tab" id="tab-<?=$i?>"><?=$i?></div>
    <?php } ?>
</div>


    <!------------------------------------------------Testfrage 1---------------------------------------------------------->
<div class="testfrage" id = "testfrage-1">
    <div class="benutzer-create-heading">
        <h3>1.Testfragen</h3>
    </div>
    <div class="form-heading">
        Liebe TeilnehmerInnen des Planspiels, im folgenden werden Ihnen vier Testfragen gestellt. Diese sollen sicherstellen, dass sie die Spielanleitung richtig verstanden haben.
    </div>
    <?= Html::beginForm('Javascript:void(0)','get',['onsubmit'=>'testFrageInput(this,1,20)']) ?>

    <div class='form-body'>
        <?= Html::label('Wie hoch ist die Verzinsung des nicht in Produktionsprozessen gebundenen Kapitals?') ?>
        <?= Html::radioList('wert',[],
            [
                18 => round($zins_eigenkapital*100-2, 0).'%',
                19 => round($zins_eigenkapital*100-1, 0).'%',
                20 => round($zins_eigenkapital*100,   0).'%'
            ],
            ['class' => 'testfrage-radio']
        ) ?>
    </div>

    <div class="form-group form-footer">
        <?= Html::submitButton('weiter', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
</div>


    <!------------------------------------------------Testfrage 2---------------------------------------------------------->
<div class="testfrage" id = "testfrage-2">
    <div class="benutzer-create-heading">
        <h3>2.Testfragen</h3>
    </div>
    <div class="form-heading">
        Hier sehen Sie eine Pachtbilanz. In welchem Jahr fällt die zugepachtete Flüche von 100 ha wieder an den Verpüchter zurück?
    </div>
    <?= Html::beginForm('Javascript:void(0)','get',['onsubmit'=>'testFrageInput(this,2,6)']) ?>

    <div class='form-body'>
        <?= Html::img('@web/images/Pachtbilanz.png');?>
        <div class="custom-input">
            <?= Html::label('im Jahr') ?>
            <?= Html::textInput('wert'); ?>
        </div>

    </div>

    <div class="form-group form-footer">
        <?= Html::submitButton('weiter', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
</div>


    <!------------------------------------------------Testfrage 3---------------------------------------------------------->
<div class="testfrage" id = "testfrage-3">
    <div class="benutzer-create-heading">
        <h3>3.Testfragen</h3>
    </div>
    <div class="form-heading">
    </div>
    <?= Html::beginForm('Javascript:void(0)','get',['onsubmit'=>'testFrageInput(this,3,30)']) ?>

    <div class='form-body'>
        <?= Html::label('Welche der folgenden Kosten werden nicht zu Beginn einer Runde abgezogen, müssen also nicht mit Eigenkapital und kurzfristigem Kredit vorfinanziert werden?') ?>
        <?= Html::radioList('wert',[],
            [
                23 => 'ggf. Anbaukosten (Pflanzkosten) für Mais',
                24 => 'ggf. Anbaukosten für Kurzumtriebsplantage',
                25 => 'ggf. Erntekosten für Kurszumtriebsplantage',
                26 => 'ggf. Belegung des Schweinestalls mit 300 €/Mastplatz',
                27 => 'ggf. Investitionsausgaben für Maschine oder Stall',
                28 => 'Fixkosten in Hähe von 20.000 € für Lebenshaltung des Betriebsleiters',
                29 => 'Pachtzahlungen',
                30 => 'ggf. Kapitaldienst (Zinsen und Raten) für Kredite',
            ], ['class' => 'testfrage-3-radio']
        ) ?>
    </div>

    <div class="form-group form-footer">
        <?= Html::submitButton('weiter', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
</div>


    <!------------------------------------------------Testfrage 4---------------------------------------------------------->
<div class="testfrage" id = "testfrage-4">
    <div class="benutzer-create-heading">
        <h3>3.Testfragen</h3>
    </div>
    <div class="form-heading">

    </div>
    <?= Html::beginForm('Javascript:void(0)','get',['onsubmit'=>'testFrageInput(this,4,/'.$preis_string.'/)']) ?>

    <div class='form-body'>
        <div>
            <?= Html::label('Welcher Preis kann sich bei den folgenden Produkten <b>maximal</b> ergeben?') ?>
        </div>
        <div class="custom-input">
            <?= Html::label('Silomais:') ?>
            <?= Html::textInput('wert_Mais'); ?> € / t
        </div>

        <div class="custom-input">
            <?= Html::label('Holzhackschnitzel aus Kurzumtriebsplantage:') ?>
            <?= Html::textInput('wert_HHS'); ?> € / t
        </div>

        <div class="custom-input">
            <?= Html::label('Fleisch von Mastschweinen:') ?>
            <?= Html::textInput('wert_Fleisch'); ?> € / kg
        </div>

    </div>

    <div class="form-group form-footer">
        <?= Html::submitButton('weiter', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
</div>

<?= Html::a('Spielanleitung', ['site/openpdf'], ['class' => 'btn btn-primary', 'target' => '_blank',]); ?>