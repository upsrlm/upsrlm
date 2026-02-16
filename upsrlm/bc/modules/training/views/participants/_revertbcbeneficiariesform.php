<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => FALSE,
                                'enableAjaxValidation' => TRUE,
                                'options' => ['class' => 'form-horizontal', 'id' => 'approve-form', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>

                    <div class="col-md-12">
                        <?php echo $form->field($model, 'revert')->checkbox(); ?> 
                        <?= $form->field($model, 'revert_bc_beneficiaries_reason')->label("Select Reason ")->dropDownList($model->reason_option, ['prompt' => "Select Reason"]) ?>
                    </div>    
                    <div class="col-md-12">
                        <div class="text-center">
                            <?= Html::submitButton('<i class="fal fa-save"></i> Revert', ['class' => 'btn btn-success']) ?>
                            <button type="button" class="btn btn-danger" id="btnclose" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>        
            </div>
        </div>   
    </div>
</div>     