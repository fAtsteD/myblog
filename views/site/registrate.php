<?php

/* @var $this yii\web\View */
/* @var $model app\models\Registrate */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
?>
<div class="site-registrate">
	<h1 class="text-center"><?= Html::encode($this->title) ?></h1>

	<?php $form = ActiveForm::begin([
		'id' => 'registrate-form',
		'layout' => 'horizontal',
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-sm-6 col-lg-4\">{input}</div>\n<div class=\"col-sm-3 col-lg-4\">{error}</div>",
			'labelOptions' => ['class' => 'control-label col-sm-3 col-lg-4'],
		]
	]); ?>

		<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

		<?= $form->field($model, 'password')->passwordInput() ?>

		<div class="form-group">
			<div class="text-center">
				<?= Html::submitInput('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
			</div>
		</div>

	<?php ActiveForm::end(); ?>
</div>