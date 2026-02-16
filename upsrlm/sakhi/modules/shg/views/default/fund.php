<?php

use yii\helpers\Html;
//use yii\bootstrap4\ActiveForm;
use sakhi\widgets\ActiveMobileForm;
use kartik\date\DatePicker;
?>
<div class="subheader mb-2">
    <h1 class="subheader-title">
        फंड जोड़ें
    </h1>
</div>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">

                    <?php
                    $form = ActiveMobileForm::begin(['id' => 'form-shgbankdetail',
                                // 'action'=>$model->action_url,
                                //'validationUrl' => $model->action_validate_url,
                                'method' => 'POST',
                                'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]);
                    ?>  
                    <div class="row">

                        <div class="col-lg-6">
                            <h3><?= $model->fund_type ?></h3>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <?php echo $form->field($model, "received_from")->dropDownList([1 => 'UPSRLM', 2 => 'VO', 3 => 'CLF'], ['prompt' => 'चयन कीजिए'])->label('से प्राप्त किया') ?>
                        </div>

                        <div class="col-lg-6">      
                            <?=
                            $form->field($model, 'date_of_receipt')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'प्राप्ति की तारीख'],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd',
                                    'endDate' => "0d",
                                ],
                                'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                                'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                            ])->label('प्राप्ति की तारीख')
                            ?> 
                        </div>

                        <div class="col-lg-6">
                            <?php echo $form->field($model, "amount_received")->label('रकम प्राप्त')->textInput() ?>
                        </div>

                    </div>

                    <div class="form-group text-center">
                        <?= $form->field($model, 'fund_type')->hiddenInput()->label(false); ?>
                        <?= $form->field($model, 'shgid')->hiddenInput()->label(false); ?>
                        <?= $form->field($model, 'editfundid')->hiddenInput()->label(false); ?>
                        <?= Html::submitButton('सेव', ['class' => 'btn btn-lg btn-info mt-2', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    </div>
                    <?php ActiveMobileForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>




<?php
$script = <<< JS
   $('form').on('beforeSubmit',function(e) {
       var form =$(this);
       formdata = new FormData(form[0]);
       formdata.append('SubmitRequest', '1');
           jQuery.ajax({
               url: form.attr('action'),
                   type: form.attr('method'),
                   data: formdata,
                   mimeType: 'multipart/form-data',
                   contentType: false,
                   cache: false,
                   processData: false,
                   dataType: 'json',
                   success: function (data) {
                       if(data.success === true){
                           history.go(-1);
                           console.log('req 1');
                       }
                   },
                   error  : function (e)
                   {
                       console.log(e);
                   }   
           });
           return false;        
   }).on('submit', function(e){
       e.preventDefault();
   })
   ;
        
JS;
$this->registerJs($script);
?>