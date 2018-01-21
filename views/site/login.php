<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Войти';
?>
<div class="site-login">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-6 col-lg-4\">{input}</div>\n<div class=\"col-sm-3 col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'control-label col-sm-3 col-lg-4'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-4 col-sm-offset-3 col-lg-4 col-sm-6\">{input} {label}</div>\n<div class=\"col-sm-3 col-lg-4\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4 text-center">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>
        
                <a class="btn btn-info" href=<?= Url::to('registrate') ?> role="button">Регистрация</a>
                
            </div>
        </div>

    

</div>
