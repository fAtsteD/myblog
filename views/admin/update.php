<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdminUsers */

$this->title = 'Редактирование для ' . $model->username;
?>
<div class="admin-update">
	<h1 class="text-center"><?= Html::encode($this->title); ?></h1>
	<?php $form = ActiveForm::begin([
		'id' => 'admin-update-form',
		'layout' => 'horizontal',
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-sm-6 col-lg-4\">{input}</div>\n<div class=\"col-sm-3 col-lg-4\">{error}</div>",
			'labelOptions' => ['class' => 'control-label col-sm-3 col-lg-4'],
		]
	]);?>

			<?= $form->field($model, 'username')->textInput(); ?>

			<?= $form->field($model, 'userRole')->dropDownList($allRoles); ?>
		<div class="form-group text-center">
			<?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']); ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>