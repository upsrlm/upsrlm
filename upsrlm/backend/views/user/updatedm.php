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
use common\models\master\MasterRole;

if ($model->user_model->role == MasterRole::ROLE_DM) {
    $this->title = 'Update District Magistrate';
    $this->params['breadcrumbs'][] = ['label' => 'District Magistrate', 'url' => ['dm']];
    $this->params['breadcrumbs'][] = $this->title;
}
if ($model->user_model->role == MasterRole::ROLE_DPRO) {
    $this->title = 'Update DPRO';
    $this->params['breadcrumbs'][] = ['label' => 'DPRO', 'url' => ['dpro']];
    $this->params['breadcrumbs'][] = $this->title;
}
if ($model->user_model->role == MasterRole::ROLE_DPM) {
    $this->title = 'Update District Project Managers (DPM)';
    $this->params['breadcrumbs'][] = ['label' => 'District Project Managers (DPM)', 'url' => ['dpm']];
    $this->params['breadcrumbs'][] = $this->title;
}
if ($model->user_model->role == MasterRole::ROLE_DIVISIONAL_CONSULTANTS) {
    $this->title = 'Update Divisional Consultants';
    $this->params['breadcrumbs'][] = ['label' => 'Divisional Consultants', 'url' => ['divisionalconsultants']];
    $this->params['breadcrumbs'][] = $this->title;
}
if ($model->user_model->role == MasterRole::ROLE_DISTRICT_CONSULTANTS) {
    $this->title = 'Update District Consultants';
    $this->params['breadcrumbs'][] = ['label' => 'District Consultants', 'url' => ['districtconsultants']];
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse"
                            data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen"
                            data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
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
                        <div class="col-xl-3 col-md-4 mb-3" style="margin-top:27px;">
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