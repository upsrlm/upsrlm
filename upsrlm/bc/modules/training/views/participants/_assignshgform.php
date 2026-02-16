<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

$this->title = 'Assign SHG of ' . $model->bc_application_model->name;
?>
<div class="row">
    <div class="col-xl-12">
        <div  class="panel">

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


                    <div class="form-group pt-3">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                    <div class="form-group">
                        <?php if (isset($model->bmmu_models)) { ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="45%">BMMU Name</th>
                                        <th >BMMU Mobile No.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($model->bmmu_models as $bmmu) { ?>   
                                        <tr>
                                            <td><?= $bmmu->name ?></td>
                                            <td><?= $bmmu->username ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>


                        <?php } ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>     

        </div>  
    </div>  
</div> 