<?php

/* @var $this yii\web\View */
/* @var $model app\models\Registrate */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use app\models\RetrievePasswordForm;

$this->title = 'Восстановление пароля';
?>

<div class="site-retrieve-password">
	<h1 class="text-center"><?= Html::encode($this->title); ?></h1>

	<?php $form = ActiveForm::begin([
		'id' => 'retrieve-password-form',
		'layout' => 'horizontal',
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-sm-6 col-lg-4\">{input}</div>\n<div class=\"col-sm-3 col-lg-4\">{error}</div>",
			'labelOptions' => ['class' => 'control-label col-sm-3 col-lg-4'],
		]
	]);

	if ($model->scenario === RetrievePasswordForm::SCENARIO_FIND_USERNAME) {
		echo $form->field($model, 'username')->textInput(['autofocus' => true]);
	} else {
		echo $form->field($model, 'password')->passwordInput(['autofocus' => true]);
		echo $form->field($model, 'repeatePassword')->passwordInput();
	} ?>
	
	<div class="form-group">
		<div class="text-center">
			<?= Html::submitInput('Восстановить пароль', ['class' => 'btn btn-primary', 'name' => 'retrieve-password-button']) ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>