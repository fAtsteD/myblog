<?php

/* @var $this yii\web\View */
/* @var $model app\models\RegistrateForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="site-registrate">

	<?php $form = ActiveForm::begin([
		'id' => 'registrate-form',
		'layout' => 'horizontal',
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-sm-6 col-lg-4\">{input}</div>\n<div class=\"col-sm-3 col-lg-4\">{error}</div>",
			'labelOptions' => ['class' => 'control-label col-sm-3 col-lg-4'],
		]
	]);	?>

		<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

		<?= $form->field($model, 'password')->passwordInput() ?>
		
		<?= $form->field($model, 'repeatePassword')->passwordInput() ?>

		<div class="form-group">
			<div class="text-center">
				<?= Html::submitInput('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
			</div>
		</div>

	<?php ActiveForm::end(); ?>
</div>