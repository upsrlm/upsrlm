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
/* @var $form yii\widgets\ActiveForm */
//echo "<pre>";
//print_r($model->weekly_planning_model);exit;
?>

<div class="planning-form">
    <?php $form = ActiveForm::begin(['id' => 'form-planning', 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
    <div class="row">
        <table class="table table-striped table-bordered table-responsive">
            <tr>
                <th width="10%">Week</th>
                <th>Onboarding</th>
                <th>A/c opening</th>
                <th>Supply Equipment</th>
                <th>Operational</th>

            </tr>   
            <?php
            if (isset($model->weekly_planning_model)) {
                $fno = 1;
                foreach ($model->weekly_planning_model as $i => $weekly_planning) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $form->field($weekly_planning, "[$i]week")->hiddenInput(['value' => $weekly_planning->week])->label('') ?>    
                            <?php echo $weekly_planning->week_name ?>
                        </td>

                        <td><?php echo $form->field($weekly_planning, "[$i]onboarding")->textInput()->label('') ?></td>
                        <td><?php echo $form->field($weekly_planning, "[$i]ac_opening")->textInput()->label('') ?></td>
                        <td><?php echo $form->field($weekly_planning, "[$i]supply_equipment")->textInput()->label('') ?></td>
                        <td><?php echo $form->field($weekly_planning, "[$i]operational")->textInput()->label('') ?></td>
                    </tr>
                    <?php
                    $fno++;
                }
            }
            ?>
        </table>   

    </div>
    <div class="col-md-12">
        <div class="text-center">
            <?php echo $form->field($model, "partner_bank_district_planning_id")->hiddenInput(['value' => $model->partner_bank_district_planning_id])->label('') ?>    
            <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-success']) ?>
            <button type="button" class="btn btn-danger" id="btnclose" data-dismiss="modal">Close</button>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>


