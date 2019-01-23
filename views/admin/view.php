<?php

/* @var $this yii\web\View */
/* @var $model app\models\AdminUsers */

use yii\bootstrap\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = "Пользователь " . $model->username;
?>
<div class="admin-view">
	<h1 class="text-center"><?= Html::encode($this->title); ?></h1>
	<p>
		<?= Html::a('Пользователи', Url::toRoute(['admin/']), ['class' => 'btn btn-primary']) ?>

		<?= Html::a('Изменить', Url::toRoute(['admin/update', 'id' => $model->userId]), ['class' => 'btn btn-success']) ?>

		<?php Modal::begin([
			'header' => '<h3>Удаление пользователя</h3>',
			'toggleButton' => [
				'label' => 'Удалить',
				'tag' => 'a',
				'class' => 'btn btn-danger',
			],
			'footer' => Html::a('Подтвердить', Url::toRoute(['admin/delete', 'id' => $model->userId]), ['class' => 'btn btn-primary', 'data-method' => 'post'])
				. Html::button('Отмена', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
		])?>
		<p>Вы уверены что хотите удалить пользователя?</p>
		<?php Modal::end(); ?>
	</p>
	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			[
				'label' => 'ID',
				'value' => $model->userId,
			],
			[
				'label' => 'Логин',
				'value' => $model->username,
			],
			[
				'label' => 'Роль',
				'value' => $model->userRole,
			],
		]
	]) ?>
</div>