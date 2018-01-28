<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

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

		<?php ActiveForm::end();?>

					<?php Modal::begin([
						'header' => '<h4>Удаление аккаунта</h4>',
						'headerOptions' => [
							'class' => 'text-left',
						],
						'toggleButton' => [
							'label' => 'Удалить аккаунт',
							'class' => 'btn btn-danger',
						],
					]);?>
						<p class="text-left">Вы уверены что хотите удалить аккаунт?</p>
						<?= Html::beginForm(['/site/delete-user'], 'post', ['id' => 'delete-user']);?>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
						<?= Html::submitInput('Подтвердить', ['class' => 'btn btn-primary', 'name' => 'delete-accept-button']); ?>
						</div>
						<?= Html::endForm(); ?>
						
					<?php Modal::end(); ?>
				</div>
			</div>
<?php else : ?>
		<div class="col-xs-5 key">Логин</div>
		<div class="col-xs-7 value"><?= Html::encode($model->username) ?></div>
<?php endif; ?>
	</div>
</div>
