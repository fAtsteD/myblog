<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use yii\helpers\Url;
use yii\bootstrap\Dropdown;

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
    <?= $this->registerLinkTag([
        'rel' => 'shortcut icon',
        'type' => 'image/x-icon',
        'href' => Yii::$app->request->baseUrl . '/image/MyFace.ico',
    ]); ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::encode('Блог Андрея'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav nav-tabs'],
        'items' => [
            [
                'label' => 'Домой',
                'url' => Yii::$app->homeUrl,
                Url::current() !== Url::to('@web/site/index') ? : 'options' => ['class' => 'active']

            ],
            [
                'label' => 'О сайте',
                'url' => Url::to('@web/site/about'),
                Url::current() !== Url::to('@web/site/about') ? : 'options' => ['class' => 'active']
            ],
            [
                'label' => 'Обратная связь',
                'url' => Url::to('@web/site/contact'),
                Url::current() !== Url::to('@web/site/contact') ? : 'options' => ['class' => 'active']
            ],
        ],
    ]); ?>

    <?php if (Yii::$app->user->isGuest) :
        echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav nav-tabs navbar-right'],
        'items' => [
            [
                'label' => 'Войти',
                'url' => Url::to('@web/site/login'),
                Url::current() !== Url::to('@web/site/login') ? : 'options' => ['class' => 'active']
            ],
            [
                'label' => 'Регистрация',
                'url' => Url::to('@web/site/registrate'),
                Url::current() !== Url::to('@web/site/registrate') ? : 'options' => ['class' => 'active']
            ],
        ],
    ]);
    else : ?>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false">
                <?= Yii::$app->user->identity->username ?>
                <span class="caret"></span>
                </a>
                <?= Dropdown::widget([
                    'items' => [
                        ['label' => 'Профиль', 'url' => Url::to('@web/site/about')],
                        '<li>'
                            . Html::a('Выйти', '#', ['onclick' => "document.getElementById('logout').submit(); return false;"])
                            . (Html::beginForm(['/site/logout'], 'post', ['id' => 'logout'])
                            . Html::endForm())
                            . '</li>',
                    ]
                ]) ?>
            </li>
        </ul>
    <?php endif; ?>

    <?php
    NavBar::end();
    ?>

    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
