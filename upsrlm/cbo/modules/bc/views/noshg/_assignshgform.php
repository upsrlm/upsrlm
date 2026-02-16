<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\shg\models\Shg */

$this->title = 'Assign SHG to ' . $model->bc_application_model->name;

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

<!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>-->
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?php $form = ActiveForm::begin(['id' => 'form-assign-shg', 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]); ?>  

                    <div class="row">

                        <div class="col-lg-3">
                            <?= $form->field($model->bc_application_model, 'name')->label("BC Name")->textInput(['readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-lg-3">
                            <?= $form->field($model->bc_application_model, 'district_name')->label("BC District")->textInput(['readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-lg-3">
                            <?= $form->field($model->bc_application_model, 'block_name')->label("BC Block")->textInput(['readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-lg-3">
                            <?= $form->field($model->bc_application_model, 'gram_panchayat_name')->label("BC GP")->textInput(['readonly' => 'readonly']) ?>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <?= $form->field($model->bc_application_model, 'your_group_name')->label("BC SHG Name")->textInput(['readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'cbo_shg_id')->label("Select SHG ")->dropDownList($model->shg_option, ['prompt' => "Select SHG"]) ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>  
        </div>
    </div>
</div>

