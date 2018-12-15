<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Marktspiel */
/* @var $form yii\widgets\ActiveForm */

$variante = mt_rand(1, 2);
$kaufen  = array("", "kaufen", "verkaufen");
$kaufen2 = array("", "eine Münze zu diesem Preis erwerben möchten (K)", "Ihre Münze zu diesem Preis verkaufen würden (V)");
$kaufen3 = array("", "K", "V");
$input = ($runde == 6) ?
    array ("0,50", "1,00", "1,50", "2,00", "2,50", "3,00", "3,50", "4,00", "4,50", "5,00")
    :
    array ("0,50", "1,00", "1,50", "2,00", "2,50", "3,00", "3,50", "4,00", "4,50", "5,00", "5,50", "6,00", "6,50", "7,00", "7,50", "8,00", "8,50");
$rand = array_rand($input);
$text = ($variante == 1) ?
    "Sie haben <b>keine Münze</b> erhalten, haben aber die Möglichkeit eine solche zu erwerben. Diese Münze wäre 
        Ihnen persönlich <b>$input[$rand] € wert</b>. Am Ende des Spiels werden drei Spieler, die urspr&uuml;nglich nicht mit einer Münze ausgestattet
        wurden, zufällig ausgewählt. Haben diese Spieler eine Münze erworben, wird ihnen der persönliche Wert der 
        Münze ausbezahlt. Andernfalls wird Ihnen der Marktpreis<b>&sup1;</b> ausbezahlt."
    :
    "Sie haben <b>eine Münze</b> erhalten. Diese Münze ist Ihnen persönlich <b>$input[$rand] € wert</b>. Sie haben nun die Möglichkeit, 
        die Münze zu behalten oder sie zu verkaufen. Am Ende des Spiels werden drei Spieler, die mit einer Münze 
        ausgestattet wurden, zufällig ausgewählt. Den Spielern, die am Ende des Spiels noch eine Münze besitzen, 
        wird ihr persönlicher Wert der Münze ausbezahlt. Sollten Sie Ihre Münze verkauft haben, wird Ihnen der 
        Marktpreis<b>&sup1;</b> ausbezahlt.";

?>

<div class="marktspiel-form">
    <div class="benutzer-create-heading">
        <h3>Marktspiel</h3>
        Liebe TeilnehmerInnen des Planspiels, im folgenden werden Ihnen vier Testfragen gestellt. Diese sollen sicherstellen, dass sie die Spielanleitung richtig verstanden haben.
    </div>
    <div class="form-heading">
        <p><?=$text?></p>
        <p>
            <b>Zu welchem dieser Preise würden Sie die Münze <?=$kaufen[$variante];?>?</b><br>
            <i>Bitte klicken Sie in jedem Fall an, ob Sie <?=$kaufen2[$variante];?> oder nicht (N)</i>
        </p>
    </div>

    <?php $form = ActiveForm::begin(); ?>
    <div class='form-body marktspiel-section col-md-12'>
        <?php for($i = 1; $i <= 17; $i++){ ?>
            <div class="col-md-4">
                <?= $form->field($model, 'VK'.$i)->radioList(['VK' => $kaufen3[$variante], 'N' => 'N'])->label(str_replace(".", ",", sprintf("%.2f", (18-$i)*0.5))) ?>
            </div>
        <?php } ?>
    </div>

    <?= $form->field($model, 'variante')->hiddenInput(['value' => $variante])->label(false) ?>
    <?= $form->field($model, 'input')->hiddenInput(['value' => str_replace(',','.',$input[$rand])])->label(false) ?>

    <div class="col-md-12 form-footer">
        <div class="form-group">
            <?= Html::submitButton('weiter', ['class' => 'btn btn-success']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
    <p style="font-size: 12px;">
        <b>&sup1;</b> Beim Marktpreis entspricht die angebotene Menge gleich der nachgefragten Menge.<br>
        Die Münzen auf dem Markt werden nun zu diesem Preis gekauft und verkauft. Anbieter
        die mehr als den Marktpreis für ihre Münze verlangen, werden nichts verkaufen. Nachfrager
        die weniger als den Marktpreis bezahlen wollen, werden keine Münze erhalten.
    </p>

</div>
