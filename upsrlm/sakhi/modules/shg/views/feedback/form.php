<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = 'SHG फ़ीडबैक';
$app = new \sakhi\components\App();
?>
<div class="card">
    <div class="col-lg-12">
        <div class="text-center"> <b>उत्तर प्रदेश राज्य ग्रामीण आजीविका मिशन,</b> <br/>
            ग्राम्य विकास विभाग, उत्तर प्रदेश शासन <br/>
            SHG के बहीखातों के रखरखाव का कार्य: हस्त-लिखित रजिस्टर या मोबाइल ऐप का विकल्प 
        </div>
    </div>
    <div class="col-lg-12">

        <div class='card-body'>
            <?php $form = ActiveMobileForm::begin(['id' => 'form-shg-feedback', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
            <div class='card'>
                <div class="col-lg-12">    
                    <?= $form->field($model, 'ques_1')->radioList($model->ques_1_option, ['separator' => '<br/>']); ?>  
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">  
                    <?= $form->field($model, 'ques_2')->textInput(['type' => 'number']); ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?= $form->field($model, 'ques_3')->textInput(['type' => 'number']); ?>  
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">  
                    <?= $form->field($model, 'ques_4')->textInput(['type' => 'number']); ?> 
                </div>     
            </div>
            <div class='card'>
                <div class="col-lg-12">   
                    <?= $form->field($model, 'ques_5')->radioList($model->ques_5_option, ['separator' => '<br/>']); ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12"> 
                    <?= $form->field($model, 'ques6p')->hiddenInput() ?>    
                    <?= $form->field($model, 'ques6p1')->checkboxList($model->ques6p1_option) ?>  
                    <?= $form->field($model, 'ques6p2')->checkboxList($model->ques6p2_option) ?> 
                    <?= $form->field($model, 'ques6p3')->checkboxList($model->ques6p3_option) ?>
                </div>     
            </div>  
            <div class='card'>
                <div class="col-lg-12">
                    <?= $form->field($model, 'ques_7')->textInput(['type' => 'number']); ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">
                    <?= $form->field($model, 'ques_8')->radioList($model->ques_8_option, ['separator' => '<br/>']); ?>
                </div>
            </div>  

            <div class="form-group text-center">
                <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label('') ?> 
                <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/feedback/form', ['shgid' => $model->cbo_shg_id])) { ?>  
                    <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    <?php Html::submitButton('सबमिट (Submit)', ['class' => 'btn btn-small btn-info', 'name' => 'submit_b', 'id' => 'submit_b']) ?>   
                <?php } ?>
            </div>
            <?php ActiveMobileForm::end(); ?>
        </div>
    </div>    
</div>    
