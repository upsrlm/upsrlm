<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use kartik\icons\FontAwesomeAsset;
use kartik\form\ActiveField;

FontAwesomeAsset::register($this);
$this->title = 'इंडिविजुअल रिपोर्ट';

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row margin-set">
    <div class="col-xl-12 p-0 clf-form">
        <div class="panel panel-default">
        <div class="card-title mb-0 px-1 py-2 border-bottom">
                <h2 class="mb-0 px-1">इंडिविजुअल रिपोर्ट </h2> 

            </div>
            <div class='panel-body p-0'>
                <?php $form = ActiveMobileForm::begin(['id' => 'form-return-fund', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
                <div class='card px-1'>
                    <div class="col-lg-12 mb-2">    
                        <?=
                        $form->field($model, 'retrun_amount', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->textInput(['type' => 'number', 'min' => 50, 'max' => '75000']);
                        ?>  
                    </div>
                </div>
                <div class='card px-1'>
                    <div class="col-lg-12 mb-2">    
                        <?=
                        $form->field($model, 'due_amount', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->textInput(['type' => 'number', 'min' => 0, 'max' => '80000']);
                        ?>  
                    </div>
                </div>
                <div class='card px-1'>
                    <div class="col-lg-12 mb-2">    
                        <?=
                        $form->field($model, 'due_after_installment', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->textInput(['type' => 'number', 'min' => 0, 'max' => '80000']);
                        ?>  
                    </div>
                </div>

                <div class='card px-1'>
                    <div class="col-lg-12 mb-2">    
                        <?=
                        $form->field($model, 'shg_has_received_refund', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']);
                        ?>  
                    </div>
                </div>
                <div class='card px-1'>
                    <div class="col-lg-12 mb-2">    
                        <?=
                        $form->field($model, 'time_left_full_loan_repay', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->textInput(['type' => 'number', 'min' => 0, 'max' => '1095']);
                        ?>  
                    </div>
                </div>
                <div class="form-group text-center">
                    <div style="display: none">
                        <?= $form->field($model, 'bc_application_id')->hiddenInput()->label(false); ?>
                        <?= $form->field($model, 'srlm_bc_selection_user_id')->hiddenInput()->label(false); ?>
                        <?= $form->field($model, 'user_id')->hiddenInput()->label(false); ?>
                        <?= $form->field($model, 'district_code')->hiddenInput()->label(false); ?>
                        <?= $form->field($model, 'block_code')->hiddenInput()->label(false); ?>
                        <?= $form->field($model, 'gram_panchayat_code')->hiddenInput()->label(false); ?>
                    </div>     
                    <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-lg btn-info py-2 my-2', 'name' => 'save_b', 'id' => 'save_b']) ?>
                </div>
                <?php ActiveMobileForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<<JS
$('#form-return-fund').on('beforeSubmit', function (e) {
    var form = $(this);
    var submit = form.find(':submit');
    submit.html('<span class="fal fa fa-spin fa-spinner"></span> प्रतीक्षा...');
    submit.prop('disabled', true);

});       
JS;
$this->registerJs($js);
?>