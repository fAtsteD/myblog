<?php
/* @var $this yii\web\View */
/* @var $model app\models\Post */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>
<div class="post">
	<h3><a href="<?= Url::toRoute(['article/post', 'id' => $model->id]) ?>" class="title-article"><?= Html::encode($model->title); ?></a></h3>
	<div class="author text-left">
		<p>
			<a href="<?= Url::toRoute(['site/profile', 'id' => $model->author->id]) ?>" class="author">
				<span class="glyphicon glyphicon-pencil"></span> <?= $model->author->username; ?>
			</a>
		</p>
	</div>

	<div class="container-fluid">
		<div class="category col-xs-8 text-left">
			<p><?= Html::encode($model->category->categ); ?></p>
		</div>

		<div class="date col-xs-4 text-right">
			<p><?= Yii::$app->formatter->asDatetime($model->created_at, 'd MMMM y в H:mm'); ?></p>
		</div>
	</div>
</div>