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
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">

            </div> 
            <div class="panel-container show">
                <div class="panel-content">
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

                    <div class="col-lg-8">

                        <?php echo $form->field($model, 'return')->radioList($model->yes_no_option)->label("Return"); ?> 
                    </div>

                    <!--        <div class="col-lg-4" style="text-align: left;line-height: 30px;">
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
        </div>
    </div>
</div>        













