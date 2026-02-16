<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
?>

<div class="clf-form">
    <div class="panel panel-default">
        
        <div class="col-lg-12">
            <div>
                <h2>क्या आपको UPSRLM से सम्बद्ध पार्ट्नर एजेन्सी बैंक ने निम्न विषयों के बारे में विस्तार में सूचित, संवेदित और सचेत किया ?</h2> 
                
            </div>
            <div class='panel-body'>
                <?php $form = ActiveForm::begin(['id' => 'form-bc-feedback', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?= $form->field($model, 'ques_1')->radioList($model->ques_1_option, ['separator' => '<br/>']); ?>  
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">  
                        <?= $form->field($model, 'ques_2')->radioList($model->ques_2_option, ['separator' => '<br/>']); ?>
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'ques_3')->radioList($model->ques_3_option, ['separator' => '<br/>']); ?>  
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">  
                        <?= $form->field($model, 'ques_4')->radioList($model->ques_4_option, ['separator' => '<br/>']); ?> 
                    </div>     
                </div>
               
                <div class="form-group text-center">
                    <?= Html::submitButton('सेव', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>    
    </div>    

</div>
