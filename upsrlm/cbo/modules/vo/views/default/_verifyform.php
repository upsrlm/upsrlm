<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use dosamigos\tinymce\TinyMce;
use app\models\nfsa\NfsaBaseSurvey;
use yii\widgets\DetailView;

$this->title = 'Verify';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => FALSE,
                                'enableAjaxValidation' => TRUE,
                                'layout' => 'default',
                                'options' => ['class' => 'form-horizontal', 'id' => 'approve-form', 'enctype' => 'multipart/form-data'],
//                    'fieldConfig' => [
//                        'template' => "{label}\n<div class=\"col-lg-6\">{input}{error}</div>",
//                        'labelOptions' => ['class' => 'col-md-6 control-label'],
//                    ],
                    ]);
                    ?>
                 
                    <div class="row">           
                        <div class="col-lg-3">
                            <?php echo $form->field($model, 'verify_vo_name_code_address')->radioList($model->option)->label("VO के नाम, कोड, स्थान व पता "); ?> 

                        </div>
                        <div class="col-lg-3">
                             <?php echo $form->field($model, 'verify_vo_formation_date_no_shg')->radioList($model->option)->label("VO गठन की तिथि एवं सम्बद्ध स्वयं सहायता समूह (एसएचजी) की संख्या "); ?> 

                        </div>
                        <div class="col-lg-3">
                           <?php echo $form->field($model, 'verify_vo_related_to_bank_account')->radioList($model->option)->label("बैंक अकाउंट से जुड़े सभी विवरण "); ?> 

                        </div>
                        <div class="col-lg-3">
                           <?php echo $form->field($model, 'verify_vo_total_amount')->radioList($model->option)->label("VO द्वारा योजना-वार अबतक प्राप्त कुल धनराशि एवं अद्यतन बैंक बैलेन्स "); ?> 
                        </div>
                    </div> 
                    <div class="row">           
                        
                        <div class="col-lg-3">
                             <?php echo $form->field($model, 'verify_vo_affiliated_shg_detail')->radioList($model->option)->label("VO के साथ सम्बद्ध सभी SHG के विवरण"); ?> 
                        </div>
                        <div class="col-lg-3">
                          <?php echo $form->field($model, 'verify_vo_members_detail')->radioList($model->option)->label("VO के सभी सदस्यों के नाम एवं पूर्ण विवरण"); ?> 

                        </div>
                        <div class="col-lg-3">
     
                            <?php echo $form->field($model, 'verify_vo_any_other_info')->radioList($model->option)->label("कोई अन्य सूचना"); ?> 
                        </div>
                    </div> 

<!--                    <div class="panel-tag mt-3">
                        <div style="text-decoration: underline;padding-bottom:10px;font-weight: bold">Note:</div>
                        'Skip' का उपयोग तभी करें जब किसी का फ़ोन busy हो, न लग रहा हो या 'switched off' हो I सभी Skip किये गए रजिस्ट्रेशन को पुनः कॉल करना है एवं सत्यापन (Verification)  सुनिश्चित करना अनिवार्य है I Skip किया गए रजिस्ट्रेशन 2-3 दिनों के अंदर अवश्य सत्यापित (Verify) हो जाने चाहिए I
                    </div>-->

                    <div class="form-group">
                        <div class="col-lg-offset-5 col-lg-11">
                            <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="mt-3">
                <?=
                    $this->render('_view', [
                        'model' => $model->vo_model,
                    ])
                    ?>
            </div>
        </div>
    </div>
