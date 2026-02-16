<?php

use yii\helpers\Html;
//use kartik\widgets\ActiveForm;
use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;

$this->title = 'Reset Password of ' . $user->user->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user">
    <div class="panel panel-default">
        <div class='panel-body'>
            <?php
            $form = ActiveForm::begin([
                        'id' => 'change-password-form',
                        'options' => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-md-4\">{input}</div><div class=\"col-md-4\">{error}</div>",
                            'labelOptions' => ['class' => 'col-md-2 control-label'],
                        ],
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
            ]);
            ?>

            <?=
            $form->field($model, 'new_password')->widget(PasswordInput::classname(), [
                'options' => ['placeholder' => 'New Password'],
                'pluginOptions' => ['showMeter' => false]
            ]);
            ?>
            <?=
            $form->field($model, 're_password')->widget(PasswordInput::classname(), [
                'options' => ['placeholder' => 'Repeat Password'],
                'pluginOptions' => ['showMeter' => false]
            ]);
            ?>

            <div class="form-group">
                <div class="col-sm-offset-2 ">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?><br>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
