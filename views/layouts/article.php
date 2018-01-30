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
use app\models\Category;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

AppAsset::register($this);
$dataProviderCategory = new ActiveDataProvider([
	'query' => Category::find(),
]);
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
			]); ?>

    <?php if (Yii::$app->user->isGuest) :
				echo Nav::widget([
				'options' => ['class' => 'nav navbar-nav nav-tabs navbar-right'],
				'items' => [
					[
						'label' => 'Войти',
						'url' => Url::toRoute('site/login'),
						Url::current() !== Url::toRoute('site/login') ? : 'options' => ['class' => 'active']
					],
					[
						'label' => 'Регистрация',
						'url' => Url::toRoute('site/registrate'),
						Url::current() !== Url::toRoute('site/registrate') ? : 'options' => ['class' => 'active']
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
						['label' => 'Создать статью', 'url' => Url::toRoute('article/create-post')],
						['label' => 'Профиль', 'url' => Url::toRoute(['site/profile', 'id' => Yii::$app->user->getId()])],
						'<li>'
							. Html::a('Выйти', '#', ['onclick' => "document.getElementById('logout').submit(); return false;"])
							. Html::beginForm(['/site/logout'], 'post', ['id' => 'logout'])
							. Html::endForm()
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
		<div class="col-md-9">
			<?= Alert::widget() ?>
			<?= $content ?>
		</div>
		<div class="sidebar-layout col-md-3">
			<h4>Категории</h4>
			<?= ListView::widget([
				'dataProvider' => $dataProviderCategory,
				'itemView' => '_category',
				'layout' => "{items}",
			])
		?>
		</div>
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