<?php

/* @var $this yii\web\View */
/* @var $model app\models\Post */

use yii\bootstrap\Html;
use yii\helpers\Url;

$this->title = Html::encode($model->title);
$tags = '';
foreach ($model->tagForPosts as $value) {
	$tags .= $value->tag . ', ';
}
$tags = substr($tags, 0, -2);
?>

<div class="post-view">
	<div class="page-header">
		<h1><?= $this->title; ?></h1>
		<div class="author text-left">
			<p>
				<a href="<?= Url::toRoute(['site/profile', 'id' => $model->author->id]) ?>" class="">
					<span class="glyphicon glyphicon-pencil"></span> <?= $model->author->username; ?>
				</a>
			</p>
		</div>

		<div class="container">
			<div class="category col-xs-7 text-left">
				<p><?= $model->category->categ; ?></p>
			</div>

			<div class="date text-right col-xs-push-1 col-xs-4">
				<p><?php setlocale(LC_TIME, 'ru_RU');
						echo date_format(DateTime::createFromFormat('Y-m-d H:i:s', $model->created_at), 'Создана j.m.Y в G:i'); ?></p>
			</div>
		</div>
	</div>

	<div class="article container-fluid"><?= $model->body; ?></div>
	<div class="tags">
		<p><b>Теги:</b> <?= $tags; ?></p>
	</div>
</div>