<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use dosamigos\tinymce\TinyMce;
use app\models\nfsa\NfsaBaseSurvey;
use yii\widgets\DetailView;

$this->title = 'Verify';
?>
<div class="action_form">  
    <div class='table-header'>

<!--        <i class='fa fa-thumbs-down'></i>-->

        <?= $this->title ?>
    </div>
    <div class='box-content'>
        <?php
        $form = ActiveForm::begin([
                    'enableClientValidation' => FALSE,
                    'enableAjaxValidation' => TRUE,
                    'options' => ['class' => 'form-horizontal', 'id' => 'approve-form', 'enctype' => 'multipart/form-data'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-6\">{input}{error}</div>",
                        'labelOptions' => ['class' => 'col-md-6 control-label'],
                    ],
        ]);
        ?>
        <div class="row">

            <div class="col-lg-6">

                <?=
                DetailView::widget([
                    'model' => $model->shg_model,
                    'attributes' => [
                        'id',
                        'name_of_shg',
                        'shg_code',
                        'district_name',
                        'block_name',
                        'gram_panchayat_name',
                        'village_name',
                        'hamlet',
                        'name_of_shg',
                        
//            'chaire_person_name',
//            'chaire_person_mobile_no',
//            'secretary_name',
//            'secretary_mobile_no',
//            'treasurer_name',
//            'treasurer_mobile_no',
                    ],
                ])
                ?> 
            </div>
            <div class="col-lg-6">

                <?php
                echo DetailView::widget([
                    'model' => $model->shg_model,
                    'attributes' => [
                        'no_of_members',
                        'chaire_person_name',
                        'chaire_person_mobile_no',
                        'secretary_name',
                        'secretary_mobile_no',
                        'treasurer_name',
                        'treasurer_mobile_no',
                    ],
                ])
                ?> 
            </div>
        </div>    
        <div class="col-lg-8">
            <?php echo $form->field($model, 'verify_shg_code')->radioList($model->yes_no_option)->label("Verify SHG Code"); ?> 
            <?php echo $form->field($model, 'verify_shg_location')->radioList($model->yes_no_option)->label("Verify location (GP/ Village & hamlet) of the SHG"); ?> 
            <?php echo $form->field($model, 'verify_shg_name')->radioList($model->yes_no_option)->label("Verify Name of SHG"); ?> 
            <?php echo $form->field($model, 'verify_shg_members')->radioList($model->yes_no_option)->label("Verify no. of SHG members"); ?> 
            <?php echo $form->field($model, 'verify_chaire_person_mobile_no')->radioList($model->yes_no_option)->label("Verify mobile no. of Chair person"); ?> 
            <?php echo $form->field($model, 'verify_secretary_mobile_no')->radioList($model->yes_no_option)->label("Verify mobile no. of Secretary"); ?> 
            <?php echo $form->field($model, 'verify_treasurer_mobile_no')->radioList($model->yes_no_option)->label("Verify mobile no. of treasurer"); ?> 
        </div>

        <div class="col-lg-4" style="text-align: left;line-height: 30px;">
            <div style="text-decoration: underline;padding-bottom:10px;font-weight: bold">Note:</div>
            'Skip' का उपयोग तभी करें जब किसी का फ़ोन busy हो, न लग रहा हो या 'switched off' हो I सभी Skip किये गए रजिस्ट्रेशन को पुनः कॉल करना है एवं सत्यापन (Verification)  सुनिश्चित करना अनिवार्य है I Skip किया गए रजिस्ट्रेशन 2-3 दिनों के अंदर अवश्य सत्यापित (Verify) हो जाने चाहिए I
        </div>

        <div class="form-group">
            <div class="col-lg-offset-5 col-lg-11">
                <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>













