<?php

/* @var $this yii\web\View */
/* @var $model app\models\EditPostForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;


$this->registerJsFile('//cdn.ckeditor.com/4.8.0/standard/ckeditor.js');
$this->registerJs("CKEDITOR.replace('editor');");
?>

<?php
$form = ActiveForm::begin([
	'layout' => 'horizontal',
	'fieldConfig' => [
		'template' => "{label}\n<div class=\"\">{input}</div>\n<div class=\"\">{error}</div>",
		'labelOptions' => ['class' => 'control-label'],
	],
]);
?>
<?= $form->field($model, 'title')->textInput(); ?>
<?= $form->field($model, 'category')->textInput(); ?>
<?= $form->field($model, 'article')->textarea(['id' => 'editor']); ?>
<?= $form->field($model, 'tags'); ?>

<div class="form-group">
	<div class="text-center">
		<?= Html::submitInput('Сохранить', ['class' => 'btn btn-success', 'name' => 'create-post-button']) ?>
	</div>
</div>

<?php ActiveForm::end(); ?>