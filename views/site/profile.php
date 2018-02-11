<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $model app\models\ViewAndUpdateForm */



$this->title = 'Профиль';
?>

<div class="site-profile">
	<h1 class="text-center"><?= Html::encode($this->title . ' ' . $model->username) ?>
	<small><?php
			if (Yii::$app->user->can('updateUser', ['userId' => Users::findOne(Yii::$app->user->getId())])) {
			echo Html::a(
				'Изменить',
				Url::toRoute(['site/update-profile', 'id' => $model->userId])
			);
		}?></small>
	</h1>
	<div class="profile col-sm-offset-1 col-sm-10">
		<div class="col-xs-5 key">Логин</div>
		<div class="col-xs-7 value"><?= Html::encode($model->username) ?></div>
	</div>
</div>
