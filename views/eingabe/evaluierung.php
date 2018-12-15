<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 27.08.18
 * Time: 10:47
 */
use yii\helpers\Html;
$this->title = Yii::t('app', 'Planspielevaluierung');
$this->params['breadcrumbs'][] = $this->title;
?>
<!------------------------------------------------Top progress tab---------------------------------------------------------->
<div class="porogress-tab-bar">
    <?php for($i = 1; $i <= 4; $i++){?>
        <div class="porogress-tab" id="tab-<?=$i?>"><?=$i?></div>
    <?php } ?>
</div>

<!------------------------------------------------evaluierung 1---------------------------------------------------------->
<div class="evaluierung" id = "evaluierung-1">
    <div class="benutzer-create-heading">
        <h3>Planspielevaluierung</h3>
    </div>
    <div class="form-heading">
        Lieber Teilnehmer,<br>
        wie schon per E-Mail angek&uuml;ndigt, m&ouml;chten wir Sie um eine Evaluierung
        des Planspiels bitten. Die Befragung wird insgesamt nicht mehr als 10 Minuten in
        Anspruch nehmen. Danach k&ouml;nnst Sie Ihre Entscheidungen f&uuml;r die n&auml;chste
        Runde treffen. In diese Befragung ist außerdem ein kleines Experiment integriert,
        das nochmals eine zus&auml;tzliche Chance auf Geldgewinne erm&ouml;glicht.
        Voraussetzung ist nur die Beantwortung <i>aller</i> Fragen, die Teilnahme am
        Experiment und etwas Gl&uuml;ck.
    </div>
    <?= Html::beginForm('Javascript:void(0)','get',['onsubmit'=>'evaluierungInput(this,1)']) ?>

    <div class='form-body'>
        <div class="evaluierung-input">
            <?= Html::label('1. Bitte bewerten Sie das Planspiel mit einer Schulnote') ?>
            <?= Html::textInput('f1')?>
        </div>

        <div class="evaluierung-input">
            <?= Html::label('2. Die Spielanleitung war verständlich geschrieben und lieferte alle notwendigen Informationen.') ?>
            <?= Html::radioList('f2',[],
                [
                    '-2' => 'stimme überhaupt nicht zu',
                    '-1' => 'stimme nicht zu',
                    '0' => 'weder noch',
                    '1' => 'stimme zu',
                    '2' => 'stimme vollkommen zu'
                ]
            )?>
        </div>

        <div class="evaluierung-input">
            <?= Html::label('3. Die Bedienung der onlinebasierten Eingabeoberfläche hat mir keine Probleme bereitet.' )?>
            <?= Html::radioList('f3',[],
                [
                    '-2' => 'stimme überhaupt nicht zu',
                    '-1' => 'stimme nicht zu',
                    '0' => 'weder noch',
                    '1' => 'stimme zu',
                    '2' => 'stimme vollkommen zu'
                ]
            )?>
        </div>



        <div class="evaluierung-input">
            <?= Html::label('4. Welche Hilfsmittel haben Sie zur Entscheidungsfindung genutzt? (Mehrfachnennung möglich)') ?>
            <?= Html::checkboxList('f4',[],
                [
                    'a' => 'Lineares Programmierungsmodell',
                    'b' => 'Tabellenkalkulationsprogramm',
                    'c' => 'Taschenrechner',
                    'd' => 'Gefühl / Bauch',
                    'e' => 'Sonstige (bitte nennen)'
                ]
            )?>
            <?= Html::hiddenInput('sonstigef4'); ?>
        </div>


        <div class="evaluierung-input">
            <?= Html::label(' 5. Wie viel Minuten haben Sie sich im Durchschnitt pro Runde genommen, um Entscheidungen zu treffen?') ?>
            <?= Html::textInput('f5')?>
        </div>


        <div class="evaluierung-input">
            <?= Html::label('6. Was für Informationen haben Sie zur Entscheidungsfindung genutzt? (Mehrfachnennung möglich)') ?>
            <?= Html::checkboxList('f6',[],
                [
                    'a' => 'Spielanleitung',
                    'b' => 'Nachfragen beim Spielleiter',
                    'c' => 'Rundenergebnisse',
                    'd' => 'Alte Eingaben',
                    'e' => 'Gespräche mit anderen Teilnehmern',
                    'f' => 'Sonstige (bitte nennen)'
                ]
            )?>
            <?= Html::hiddenInput('sonstigef6'); ?>
        </div>


    </div>

    <div class="form-group form-footer">
        <?= Html::submitButton('weiter', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
</div>

<!------------------------------------------------evaluierung 1---------------------------------------------------------->
<div class="evaluierung" id = "evaluierung-2">
    <div class="benutzer-create-heading">
        <h3>Planspielevaluierung</h3>
    </div>
    <div class="form-heading">
        <i>Im Folgenden wollen wir Ihre Risikoeinstellung einschätzen.</i>Wir möchten Sie bitten, die Fragen mit großer Sorgfalt auszufüllen, da sie für unsere Auswertungen von großer Bedeutung sind.
    </div>
    <?= Html::beginForm('Javascript:void(0)','get',['onsubmit'=>'evaluierungInput(this,2)']) ?>

    <div class='form-body'>

        <h4>7. Gegeben, das Planspiel w&uuml;rde unendlich oft durchgef&uuml;hrt.</h4>

        <div class="evaluierung-input">
            <?= Html::label('1. Schätzen Sie bitte den Preis, der sich für <b>Mais</b> im Mittel der Runden ergeben würde.'); ?>
            <?= Html::textInput('text1f7'); ?>
        </div>

        <div class="evaluierung-input">
            <?= Html::label('2. Schätzen Sie bitte den mittleren Preis f&ür <b>Holzhackschnitzel</b>.'); ?>
            <?= Html::textInput('text2f7'); ?>
        </div>

        <div class="evaluierung-input">
            <?= Html::label('3. Schätzen Sie bitte den mittleren Preis für <b>Fleisch</b>.'); ?>
            <?= Html::textInput('text3f7'); ?>
        </div>

        <h4>Bitte bewerten Sie die jeweilige Produktionsweise nach Ihren persönlichen Vorlieben.</h4>
        <div class="evaluierung-input">
            <?= Html::label('8. Mais'); ?>
            <?= Html::radioList('f8',[],
                [
                    '-2' => 'lehne vollkommen ab',
                    '-1' => 'lehne ab',
                    '0' => 'neutral',
                    '1' => 'präferiere',
                    '2' => 'präferiere sehr'
                ]
            )?>
        </div>

        <div class="evaluierung-input">
            <?= Html::label('9. Kurzumtrieb'); ?>
            <?= Html::radioList('f9',[],
                [
                    '-2' => 'lehne vollkommen ab',
                    '-1' => 'lehne ab',
                    '0' => 'neutral',
                    '1' => 'präferiere',
                    '2' => 'präferiere sehr'
                ]
            )?>
        </div>

        <div class="evaluierung-input">
            <?= Html::label('10. Schweinemast'); ?>
            <?= Html::radioList('f10',[],
                [
                    '-2' => 'lehne vollkommen ab',
                    '-1' => 'lehne ab',
                    '0' => 'neutral',
                    '1' => 'präferiere',
                    '2' => 'präferiere sehr'
                ]
            )?>
        </div>

    </div>

    <div class="form-group form-footer">
        <?= Html::submitButton('weiter', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
</div>

<!------------------------------------------------evaluierung 1---------------------------------------------------------->
<div class="evaluierung" id = "evaluierung-3">
    <div class="benutzer-create-heading">
        <h3>Planspielevaluierung</h3>
    </div>
    <div class="form-heading">
        <h3>Holt and Laury - Experiment</h3>
        Aus allen Teilnehmern, die diese Evaluation <i>komplett</i> ausf&uuml;llen, ermitteln wir per Zufall 3 &quot;Gewinner&quot;,
        die eine Auszahlung erhalten. Diese Auszahlung h&auml;ngt von Ihren eigenen Entscheidungen auf der n&auml;chsten Seite und
        dem Zufall ab.<br>
        <br>
        Es werden Ihnen zehn Wahlm&ouml;glichkeiten zwischen zwei Lotterien gegeben: Lotterie A und Lotterie B
        (z. B. A: 40%: x &euro;; 60%: y &euro; / B: 40%: z &euro;; 60%: v &euro;).<br>
        <br>
        Die Prozentangaben zeigen, mit welcher Wahrscheinlichkeit Sie den jeweiligen Geldbetrag gewinnen oder verlieren k&ouml;nnen.
        Bitte entscheiden Sie sich immer f&uuml;r jeweils eine der vorgestellten Optionen.<br>
        <br>
        Im Folgenden bitten wir Sie, sich f&uuml;r eine der zwei Optionen X oder Y zu entscheiden. Bitte entscheiden Sie
        in jeder der zehn Zeilen. Im Anschluss an das Experiment wird zuf&auml;llig eine der zehn Entscheidungen als auszahlungsrelevant
        ausgew&auml;hlt.<br>
    </div>
    <?= Html::beginForm('Javascript:void(0)','get',['onsubmit'=>'evaluierungInput(this,3)']) ?>

    <div class='form-body'>
        <?php
        $gewinn_1 = 10;
        $gewinn_2 = 90;
        for($i = 1; $i <= 10; $i++){
        ?>

            <div class="col-md-12" style="background-color: whitesmoke; border-bottom: 1px solid lightgrey">
                <div class="col-md-5">
                    <div>mit <?=$gewinn_1?>% Gewinn von <b>10,00 €</b></div>
                    <div>mit <?=$gewinn_2?>% Gewinn von <b>8,00 €</b></div>

                </div>
                <?= Html::radioList('XY'.$i,[],
                    [
                        'X' => 'X',
                        'Y' => 'Y',
                    ],['class' => 'col-md-2' ]
                )?>
                <div class="col-md-5">
                    <div>mit <?=$gewinn_1?>% Gewinn von <b>19,25 €</b></div>
                    <div>mit <?=$gewinn_2?>% Gewinn von <b>0,50 €</b></div>

                </div>
            </div>

        <?php
        $gewinn_1 += 10;
        $gewinn_2 -= 10;
        } ?>
    </div>

    <div class="form-group form-footer">
        <?= Html::submitButton('weiter', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
</div>

<!------------------------------------------------evaluierung 1---------------------------------------------------------->
<div class="evaluierung" id = "evaluierung-4">
    <div class="benutzer-create-heading">
        <h3>Soziodemographische Daten</h3>
    </div>
    <div class="form-heading">
        Zum Abschluss m&ouml;chten wir bitte noch einige Daten betreffend Ihrer Person erheben. Die Daten werden
        selbstverst&auml;ndlich vertrauchlich behandelt und nicht an Dritte weitergegeben.<br>
    </div>
    <?= Html::beginForm('Javascript:void(0)','get',['onsubmit'=>'evaluierungInput(this,4)']) ?>

    <div class='form-body'>

        <div class="evaluierung-input">
            <?= Html::label('11. Alter'); ?>
            <?= Html::textInput('f11') ?>
        </div>


        <div class="evaluierung-input">
            <?= Html::label('12. Haben Sie, abgesehen vom Studium, einen direkten Bezug zur Landwirtschaft? (z.B. elterlicher Betrieb)'); ?>
            <?= Html::radioList('f12',[],
                [
                    '1' => 'ja',
                    '0' => 'nein',
                ]
            )?>
        </div>


        <div class="evaluierung-input">
            <?= Html::label('13. Haben Sie, abgesehen vom Studium, einen direkten Bezug zur Forstwirtschaft? (z.B. elterlicher Betrieb)'); ?>
            <?= Html::radioList('f13',[],
                [
                    '1' => 'ja',
                    '0' => 'nein',
                ]
            )?>
        </div>
    </div>

    <div class="form-group form-footer">
        <?= Html::submitButton('weiter', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
</div>


