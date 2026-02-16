<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Verify Secretary';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>

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
                    <div class="row">

                        <div class="col-lg-6">

                            <?=
                            DetailView::widget([
                                'model' => $model->shg_model,
                                'attributes' => [
                                    'name_of_shg',
                                    'shg_code',
                                ],
                            ])
                            ?> 
                        </div>
                        <div class="col-lg-6">

                            <?php
                            echo DetailView::widget([
                                'model' => $model->shg_model,
                                'attributes' => [
                                    'secretary_name',
                                    'secretary_mobile_no',
                                ],
                            ])
                            ?> 
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-lg-12">
                            
                           <?php echo $form->field($model, 'verify_s_ques1')->radioList($model->yes_no_option)->label("समूह का नाम, पदाधिकारीयों के नाम व फ़ोन नम्बर सत्यापित करें"); ?> 
                            <?php echo $form->field($model, 'verify_s_ques2')->radioList($model->yes_no_option)->label("क्या आपके पास स्मार्ट्फ़ोन है?"); ?> 
                            <?php echo $form->field($model, 'verify_s_ques3')->radioList($model->yes_no_option)->label("अगर हाँ तो, क्या आप समूह सम्बन्धी मोबाइल ऐप अपने फ़ोन पर चलने के लिए सहमत हैं?"); ?> 

                        </div>
                    </div>    


                    <div class="form-group text-center">

                        <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>


                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
