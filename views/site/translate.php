<?php

/* @var $this yii\web\View */
/* @var $translatedMessages app\models\translationMessageRU */
/* @var $translationSource app\models\TranslationSource */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Перевод';
?>
<div class="site-translate">
	<h1 class="text-center"><?= Html::encode($this->title) ?></h1>


	<?php
	$form = ActiveForm::begin([
		'id' => 'translate-form',
		'layout' => 'horizontal',
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-sm-6 col-lg-6\">{input}</div>\n<div class=\"col-sm-2 col-lg-3\">{error}</div>",
			'labelOptions' => ['class' => 'control-label col-sm-4 col-lg-3'],
		]
	]);

	foreach ($translatedMessages as $index => $message) {
		echo $form->field($message, "[$index]translation")->label($translationSource[$index]['message']);
	}?>

	<div class="form-group">
		<div class="text-center">
			<?= Html::submitInput('Запомнить', ['class' => 'btn btn-success', 'name' => 'translate-button']) ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>	
		

</div>