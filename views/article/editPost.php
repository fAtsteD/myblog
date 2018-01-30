<?php

/* @var $this yii\web\View */
/* @var $model app\models\EditPostForm */

use yii\bootstrap\Html;

$this->title = 'Редактирование статьи';
?>

<div class="site-create-post">
	<h1 class="text-center"><?= Html::encode($this->title); ?></h1>

	<?= $this->render('_editPostForm', ['model' => $model]); ?>
</div>
