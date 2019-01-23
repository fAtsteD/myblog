<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $usersData app\models\AdminUsers */

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = 'Пользователи';

?>
<div class="admin-users">
	<h1 class="text-center"><?= Html::encode($this->title); ?></h1>
	<p><?= $this->render('_search', [
				'model' => $usersData,
				'allRoles' => $allRoles,
			]) ?></p>

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
		[
			'label' => 'Роль',
			'attribute' => 'id',
			'content' => function ($data) {
				$roles = Yii::$app->authManager->getRolesByUser($data->getId());

				$result = '';
				foreach ($roles as $role) {
					$result .= $role->name . "\n";
				}

				return substr($result, 0, -1);
			}
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '80'],
		],
	],
	'summary' => false,
	'options' => [
		'class' => 'table table-condensed table-striped',
	],
]) ?>
</div>