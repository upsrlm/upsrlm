<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\password\PasswordInput;
use kartik\date\DatePicker;
use app\models\UserModel;

$this->title = 'Update Nodal Bank user';
$this->params['breadcrumbs'][] = ['label' => 'Rsetis Nodal Bank', 'url' => ['nodalbank']];
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
                                    'template' => "{label}\n<div >{input}</div>\n<div >{error}</div>",
                                    'labelOptions' => ['class' => ' control-label'],
                                ],
                                'enableAjaxValidation' => true,
                                'enableClientValidation' => false,
                    ]);
                    ?>
                    <div class="row">
                        <div class="col-xl-3 col-md-4 mb-3">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>
                        </div>
                        <div class="col-xl-3 col-md-4 mb-3">
                            <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true, 'placeholder' => 'Mobile No']) ?>
                        </div>
                        <div class="col-xl-3 col-md-4 mb-3">
                            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Login']) ?>
                        </div>
                        <div class="col-xl-3 col-md-4 mb-3">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email Id']) ?>
                        </div>
                        <div class="col-xl-3 col-md-4 mb-3">
                            <?=
                            $form->field($model, 'password')->widget(PasswordInput::classname(), [
                                'pluginOptions' => ['showMeter' => false]
                            ]);
                            ?>
                        </div>
                        <div class="col-xl-3 col-md-4 mb-3">
                            <?php
                            echo $form->field($model, 'district_code')->widget(kartik\select2\Select2::classname(), [
                                'data' => $model->district_option,
                                'size' => Select2::MEDIUM,
                                'options' => ['placeholder' => 'Select District', 'multiple' => TRUE],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-xl-3 col-md-4 mb-3" style="margin-top:28px;">
<?= Html::submitButton('Save', ['class' => 'btn btn-info', 'style' => 'padding:7px 20px;']) ?>
                        </div>
                    </div>

<?php ActiveForm::end(); ?>

                </div>   
            </div>
        </div> 
    </div> 
</div>
<?php
$css = <<<css
   div.required label.control-label:after {
    content: " *";
    color: red;
}
css;
$this->registerCss($css);
?>