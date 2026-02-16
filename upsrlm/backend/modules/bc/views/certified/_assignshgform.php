<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\shg\models\Shg */

$this->title = 'Assign SHG of ' . $model->bc_application_model->name;
$this->params['breadcrumbs'][] = ['label' => 'Certified BC', 'url' => ['/bc/certified']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shg-create">
    <div class="panel panel-default">
        <div class='panel-body'>

            <?php $form = ActiveForm::begin(['id' => 'form-clf', 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]); ?>  

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
                <button type="button" class="btn btn-danger" id="btnclose" data-dismiss="modal">Close</button>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>     

