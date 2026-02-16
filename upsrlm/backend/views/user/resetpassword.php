<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
//use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;
$this->title = 'Reset Password of ' . $user->user->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
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
                    $form->field($user, 'new_password')->widget(PasswordInput::classname(), [
                        'options' => ['placeholder' => 'New Password'],
                        'pluginOptions' => ['showMeter' => false]
                    ]);
                    ?>
                    <?=
                    $form->field($user, 're_password')->widget(PasswordInput::classname(), [
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
    </div>
</div>
