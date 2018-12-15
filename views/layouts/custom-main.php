<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\Components\Generic;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php

$user_role = Generic::getCurrentuser(Yii::$app->user->id,'rolle');

$menu_items = [

        /*['label' => 'Startseite', 'url' => Yii::$app->homeUrl],*/
        /*['label' => 'Manage Question Set', 'url' => ['/questionset/generateqnset']]*/
];
if(Yii::$app->user->isGuest){

    $menu_items[] = ['label' => 'Anmeldung', 'url' => ['/benutzer/create']];
    $menu_items[] = ['label' => 'Einloggen', 'url' => ['/site/login']];

}else{

    if($user_role == 'admin'){
        $menu_items[] = ['label' => 'Benutzer', 'url' => ['/benutzer/index']];
        $menu_items[] = ['label' => 'Parameter', 'url' => ['/eparam/index']];
        /*$menu_items[] = ['label' => 'Question Set', 'url' => ['/questionset/index']];*/
        /*$menu_items[] = ['label' => 'Eingeben', 'url' => ['/eingeben/index']];*/
        $menu_items[] = ['label' => 'Eingaben', 'url' => ['/eingabe/index']];
        $menu_items[] = ['label' => 'Rechnen', 'url' => ['/eingabe/rechnen']];
        $menu_items[] = ['label' => 'Result', 'url' => ['/eingabe/result']];
        $menu_items[] = ['label' => 'Rangliste', 'url' => ['/eingabe/rangliste']];
        $menu_items[] = ['label' => 'Bewertungen', 'url' => ['/eingabe/bewertungen']];
        $menu_items[] = ['label' => 'Evaluierung', 'url' => ['/evaluierung/index']];
        $menu_items[] = ['label' => 'Marktspiel', 'url' => ['/marktspiel/index']];
        $menu_items[] = ['label' => 'Testfrage', 'url' => ['/testfragetrace/index']];
    }else{
        $menu_items[] = ['label' => 'Spielerbereich', 'url' => ['/eingabe/spieler']];
    }

    $menu_items[] = '<li>'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            'Ausloggen (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
}

?>

<input id = "baseurl" type="hidden" value="<?= Yii::$app->request->baseUrl?>">

<div class="wrap body-main">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top header-top2',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right header-top2'],
        'items' => $menu_items
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Feld, Wald oder Schweine Sommersemester 2019 Göttingen</p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
