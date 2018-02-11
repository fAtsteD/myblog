<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $usersData app\models\AdminUsers */

$this->title = 'Пользователи';

?>
<div class="admin-users">
	<h1 class="text-center"><?= Html::encode($this->title); ?></h1>
	<?= $this->render('_search', ['model' => $usersData]) ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			[
				'label' => 'ID',
				'attribute' => 'id',
			],
			[
				'label' => 'Логин',
				'attribute' => 'username',
			],
			['class' => 'yii\grid\ActionColumn'],
		],
		'summary' => false,
		'options' => [
			'class' => 'table table-condensed table-striped',
		],
	]) ?>
</div>