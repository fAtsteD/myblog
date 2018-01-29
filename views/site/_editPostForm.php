<?php

/* @var $this yii\web\View */
/* @var $model app\models\EditPostForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use app\models\Category;
use yii\helpers\ArrayHelper;


$this->registerJsFile('//cdn.ckeditor.com/4.8.0/standard/ckeditor.js');
$this->registerJs("CKEDITOR.replace('editor');");
?>

<?php
$form = ActiveForm::begin([
	'layout' => 'horizontal',
	'fieldConfig' => [
		'template' => "{label}\n{input}\n{hint}\n{error}",
		'horizontalCssClasses' => [
			'label' => '',
			'offset' => '',
			'error' => '',
			'hint' => '',
		],
	],
]);
?>
<?= $form->field($model, 'title')->textInput()->label('Заголовок статьи'); ?>
<?= $form->field($model, 'categoryId')->dropDownList(ArrayHelper::map(Category::find()->indexBy('id')->all(), 'id', 'categ')); ?>
<?= $form->field($model, 'article')->textarea([
	'id' => 'editor',
])->label(false); ?>
<?= $form->field($model, 'tags', [
	'inputOptions' => [
		'placeholder' => 'кошка,енот,собака',
	]
])->textInput()->hint('Теги вводятся через запятую, без пробела.'); ?>

<div class="form-group">
	<div class="text-center">
		<?= Html::submitInput('Сохранить', ['class' => 'btn btn-success', 'name' => 'create-post-button']) ?>
	</div>
</div>

<?php ActiveForm::end(); ?>