<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use app\models\UserModel;
use kartik\date\DatePicker;
use kartik\password\PasswordInput;

/* @var $this yii\web\View */
/* @var $model app\models\Team */

$this->title = 'update User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
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
                                'id' => 'bdo-form',
                                'options' => ['class' => 'form-horizontal', 'id' => 'bdo-form'],
                                'fieldConfig' => [
                                    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div >{error}</div>",
                                    'labelOptions' => ['class' => 'col-md-3 control-label'],
                                ],
                                'enableAjaxValidation' => true,
                                'enableClientValidation' => false,
                    ]);
                    ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>
                    <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true, 'placeholder' => 'Mobile No']) ?>
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Login']) ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email Id']) ?>
                    <?=
                    $form->field($model, 'password')->widget(PasswordInput::classname(), [
                        'pluginOptions' => ['showMeter' => false]
                    ]);
                    ?>

                    <div class="form-group">
                        <div class="col-sm-offset-4 ">
                            <?= Html::submitButton('Save33', ['class' => 'btn btn-info']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div> 
        </div> 
    </div>
</div>
