<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdminUsers */
/* @var $allRoles */
?>
<div class="search-line">
<?php
$form = ActiveForm::begin([
	'action' => ['admin/index'],
	'method' => 'get',
	'layout' => 'inline',
]);
?>

	<?= $form->field($model, 'userId')->textInput(['placeholder' => 'ID']); ?>
	<?= $form->field($model, 'username')->textInput(['placeholder' => 'Логин']); ?>
	<?= $form->field($model, 'userRole')->dropDownList($allRoles, ['prompt' => 'Выбрать роль']); ?>

	<div class="form-group">
		<?= Html::submitButton('Найти', ['class' => 'btn btn-primary']); ?>
	</div>

<?php ActiveForm::end(); ?>
</div>