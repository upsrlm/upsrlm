<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12 p-0">
        <div id="panel-1" class="panel">
            <div class="card-title mb-0 p-2 border-bottom">
                <h2 class="mb-0"><?= $this->title ?></h2>   
            </div>
            <div class='panel-body mt-2 label-set'>
                <?php $form = ActiveMobileForm::begin(['id' => 'form-ack_payment', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
               
                <div class='card px-2'>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'fraud_transaction')->checkboxList($model->fraud_transaction_option, ['separator' => '']); ?>
                        
                    </div>
                </div>

                <div class="form-group text-center">
                    <div style="display:none">
                    <?= $form->field($model, 'bc_application_id')->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'srlm_bc_selection_user_id')->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'district_code')->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'block_code')->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'gram_panchayat_code')->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'group')->hiddenInput()->label(false); ?>
                    </div>   
                    <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                </div>
                <?php ActiveMobileForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
//$js = <<<JS
//    $(document).ready(function() {   
//        $(".field-bcgrievanceform-machine_problem").css("display","none");
//        $(".field-bcgrievanceform-machine_problem_99_text").css("display","none");  
//        $('input[type=radio][name="BcGrievanceForm[machine_work]"]').change(function() {
//        if($(this).val()=='1') {
//        $(".field-bcgrievanceform-machine_problem").css("display","none");
//        $(".field-bcgrievanceform-machine_problem_99_text").css("display","none");
//            $("#bcgrievanceform-machine_problem_99_textt").val("");
//        } else{
//        $(".field-bcgrievanceform-machine_problem").css("display","block");
//        }
//    });
//       $("#bcgrievanceform-machine_problem").on("change", function() {
//            ApCheck=[];
//            $("input[name='BcGrievanceForm[machine_problem][]']:checked").each(function() {
//             ApCheck.push($(this).val());
//             console.log(ApCheck);
//             if(ApCheck.includes('99')) {
//            $(".field-bcgrievanceform-machine_problem_99_text").css("display","block");
//           }else {
//            $(".field-bcgrievanceform-machine_problem_99_text").css("display","none");
//            $("#bcgrievanceform-machine_problem_99_textt").val("");
//           }
//            });  
//       }); 
//    
//    });         
//JS;
//$this->registerJs($js);
?>

<style>
    .col-lg-12 {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }

    .card .card-body {
        padding: 0px
    }

    .card-body .card {
        margin: 5px 0px
    }

    .card-body .card> :last-child,
    .card-group> :last-child {
        margin-bottom: 10px;
        margin-top: 5px;
    }

    .form-group:last-child,
    .form-group:only-child {
        margin-bottom: 10px;
    }
</style>