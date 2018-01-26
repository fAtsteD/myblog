<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ViewAndUpdateForm */



$this->title = 'Профиль';
?>

<div class="site-profile">
	<h1 class="text-center"><?= Html::encode($this->title . ' ' . $model->username) ?></h1>
	<div class="profile col-sm-offset-1 col-sm-10">
		<?php if ($model->edit) : ?>
			<?php $form = ActiveForm::begin([
			'id' => 'change-form',
			'layout' => 'horizontal',
			'fieldConfig' => [
				'template' => "{label}\n<div class=\"col-sm-6 col-lg-4\">{input}</div>\n<div class=\"col-sm-3 col-lg-4\">{error}</div>",
				'labelOptions' => ['class' => 'control-label col-sm-3 col-lg-4'],
			]
		]); ?>

			<?= $form->field($model, 'username')->textInput() ?>

			<?= $form->field($model, 'password')->passwordInput() ?>
			
			<?= $form->field($model, 'repeatePassword')->passwordInput() ?>

			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6 text-center">
					<?= Html::submitInput('Изменить', ['class' => 'btn btn-primary', 'name' => 'change-button']) ?>

		<?php ActiveForm::end(); ?>
					 
					<?= Html::a('Удалить аккаунт', ['delete-user'], [
						'class' => 'btn btn-danger',
						'data' => [
							'confirm' => 'Вы уверены что хотите удалить свой аккаунт?',
							'method' => 'post',
						],
					]) ?>
				</div>
			</div>
<?php else : ?>
		<div class="col-xs-5 key">Логин</div>
		<div class="col-xs-7 value"><?= Html::encode($model->username) ?></div>
<?php endif; ?>
	</div>
</div>
