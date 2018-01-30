<?php

/* @var $this yii\web\View */
/* @var $model app\models\Post */

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;

$this->title = Html::encode($model->title);
$tags = '';
foreach ($model->tagForPosts as $value) {
	$tags .= Html::encode($value->tag) . ', ';
}
$tags = substr($tags, 0, -2);
?>

<div class="post-view">
	<div class="page-header">
		<h1><?= $this->title; ?></h1>
		<div class="author text-left">
			<p>
				<a href="<?= Url::toRoute(['site/profile', 'id' => $model->author->id]) ?>" class="author">
					<span class="glyphicon glyphicon-pencil"></span> <?= $model->author->username; ?>
				</a>
				<?php
			if (Yii::$app->user->getId() === $model->author->id) {
				echo '<a class="btn btn-sm btn-default" href="'
					. Url::toRoute(['article/edit-post', 'id' => $model->id])
					. '">Редактировать</a>';
			}
			?>
			</p>
		</div>

		<div class="container-fluid">
			<div class="category col-xs-8 text-left">
				<p><?= Html::encode($model->category->categ); ?></p>
			</div>

			<div class="date col-xs-4 text-right">
				<p><?= Yii::$app->formatter->asDatetime($model->created_at, 'Создана d MMMM y в H:mm'); ?></p>
			</div>
		</div>
	</div>

	<div class="article"><?= HtmlPurifier::process($model->body); ?></div>
	<div class="tags">
		<p><b>Теги:</b> <?= $tags; ?></p>
	</div>
</div>