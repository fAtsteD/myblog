<?php 

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\ViewAndUpdateForm */

$this->title = 'Редактирование профиля';
?>

<div class="site-profile-update">
	<h1 class="text-center"><?= Html::encode($this->title . ' ' . $model->username) ?></h1>
	<div class="col-sm-offset-1 col-sm-10">
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

					<?php Modal::begin([
					'header' => '<h3>Удаление аккаунта</h3>',
					'headerOptions' => [
						'class' => 'text-left',
					],
					'toggleButton' => [
						'label' => 'Удалить аккаунт',
						'class' => 'btn btn-danger',
					],
					'footer' => Html::beginForm(['/site/delete-user'], 'post', ['id' => 'delete-user'])
						. Html::submitInput('Подтвердить', ['class' => 'btn btn-primary', 'name' => 'delete-accept-button'])
						. Html::button('Отмена', ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])
						. Html::endForm(),
				]); ?>
						<p class="text-left">Вы уверены что хотите удалить аккаунт?</p>
					<?php Modal::end(); ?>
				</div>
			</div>
	</div>
</div>