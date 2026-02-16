<?php

use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Agree for training';
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
//                                'fieldConfig' => [
//                                    'template' => "{label}\n<div class=\"col-lg-6\">{input}{error}</div>",
//                                    'labelOptions' => ['class' => 'col-md-6 control-label'],
//                                ],
                    ]);
                    ?>
                    <div class="panel-hdr">
                        <h2>
                            <?= 'ट्रेनिंग वार्तालाप' ?>
                        </h2>

                    </div>
                  <div class="panel-content">  
                    जी नमस्ते,
                    <p>मै उत्तर प्रदेश राज्य ग्रामीण आजीविका मिशन के मुख्यालय लखनऊ से बात कर रहा हूँ, कर रही हूँ |</p>
                    <div class="panel-tag"><b>एक महत्पूर्ण सूचना –</b> वर्तालाप की गुणवता हेतु ये काल रिकार्ड की जा रही है | इस लिय वार्तालाप में विनम्रता एवं अनुशासन बनाये रखिये |</div>
                    <p>आपका नाम आपकी ग्राम पंचायत से बी सी सखी के कार्य हेतु आपका नाम  शार्टलिस्ट हुआ है क्या आप कार्य हेतु इछुक है ,</p>
                    बी सी यदि हाँ करे <br/>
                    <p> आपको बी सी के के हेतु 7 दिन के ट्रेनिंग पर भेजा जायेगा जोकि आपके जिले में ही होगी उक्त ट्रेनिग पूरी तरह से निःशुल्क है आपको केवल आने जाने का व्यय वहन करना होगा | 
                        चुकी बी सी के ट्रेनिंग rseti कार्यालय के माध्यम से होती है जिसके लिए सोमवार को पंजीकरण किया जाता है ट्रेनिंग बुधवार से सोमवार तक होती है एवं बुधवार को पेपर होता है पेपर पास हो जाने के बाद आप सर्टिफिकेट धारक बी सी सखी बन जाती है |</p>
                    <p>बी सी के सवाल<br/>
                    प्रश्न --क्या ट्रेनिंग का पैसा लगेगा <br/>
                    उत्तर  जी नहीं निःशुल्क है |
                    </p>
                    
                    <p>बी सी के ट्रेनिंग हेतु जरुरी प्रपत्र <br/>
                    1- आधार कार्ड मूलरूप एवं फोटोकॉपी <br/>
                    2- हाई स्कूल पास मार्कशीट <br/>
                    3- स्वयं की फोटो </p>
                    <p>यदि बी सी के अलावा कोई 
                    सम्बन्धित मोबाइल नंबर का फ़ोन उठता है 
                    पति /पिता /भाई /देवर / बेटा /पड़ोसी  तो केवल इतना कहना है 
                    की मै उत्तर प्रदेश राज्य ग्रामीण आजीविका मिशन के मुख्यालय लखनऊ से बात कर रहा हूँ, कर रही हूँ |
                    कृपया सरकारी कार्य हेतु सम्बन्धित महिला से तुरंत बात करवा दे |</p>


                </div>
                <div class="row">

                    <div class="col-lg-6">

                        <?=
                        DetailView::widget([
                            'model' => $model->bc_model,
                            'attributes' => [
                                'name',
                                'guardian_name',
                                'age',
                                [
                                    'attribute' => 'reading_skills',
                                    'label' => 'Education',
                                    'format' => 'html',
                                    'value' => $model->bc_model->readingskills != null ? $model->bc_model->readingskills->name_eng : '',
                                ],
                                [
                                    'attribute' => 'OTP Verified mobile no',
                                    'enableSorting' => false,
                                    'format' => 'html',
                                    'contentOptions' => ['style' => 'width: 60%'],
                                    'value' => function ($model) {
                                        return $model->mobile_no;
                                    },
                                ],
                            ],
                        ])
                        ?> 
                    </div>
                    <div class="col-lg-6">

                        <?php
                        echo DetailView::widget([
                            'model' => $model->bc_model,
                            'attributes' => [
                                [
                                    'attribute' => 'address',
                                    'enableSorting' => false,
                                    'format' => 'html',
                                    'contentOptions' => ['style' => 'width: 60%'],
                                    'value' => function ($model) {
                                        return $model->fulladdress;
                                    },
                                ],
                            ],
                        ])
                        ?> 
                    </div>
                </div>

                <div class="col-lg-12 conection">
                    <?php echo $form->field($model, 'upsrlm_connection_status')->radioList($model->connection_status_option); ?> 
                </div>
                <div class="col-lg-12">
                    <div class="connection_status_1">
                        <?php echo $form->field($model, 'upsrlm_call_status')->radioList($model->call_status_option); ?> 
                        <div class="call_status_10"> 
                            <?php echo $form->field($model, 'action_status')->radioList($model->action_option); ?> 
                        </div>
                        <div class="action_status_2">
                            <?= $form->field($model, 'unwilling_reason')->checkboxList($model->unwilling_reason_option) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group pt-2">
                    <?= $form->field($model, 'log_id')->hiddenInput()->label(''); ?>
                    <div class="col-lg-offset-3 col-lg-11">
                        <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>
</div>
<?php
$js = <<<JS
    $(document).ready(function() {
        $(".connection_status_1").css("display","none");
        $(".call_status_10").css("display","none");
        $(".action_status_2").css("display","none");
        $('input[type=radio][name="CloudLog[upsrlm_connection_status]"]').change(function() {
        if($(this).val()) {
           var upsrlm_connection_status =$('input[name="CloudLog[upsrlm_connection_status]"]:checked').val();
           var upsrlm_call_status =$('input[name="CloudLog[upsrlm_call_status]"]:checked').val();
          var log_id =$('#cloudlog-log_id').val();
    $.ajax({
            type: "POST",
            url: "/call/upsrlmstatus",
            data: { 'log_id' : log_id , 'upsrlm_connection_status' : upsrlm_connection_status},
            
            dataType: "json",
            success: function (data) {
               
            },
            error: function (errormessage) {
                

            }
        });
        }
           if($(this).val() =='1') {
            $(".connection_status_1").css("display","block");
            }else{
            $('input[name="CloudLog[upsrlm_call_status]"]').prop('checked', false);
            $('input[name="CloudLog[action_status]"]').prop('checked', false);
            $('input[type=checkbox]').prop('checked', false);
            $(".connection_status_1").css("display","none");
             }
    });
    $('input[type=radio][name="CloudLog[upsrlm_call_status]"]').change(function() {
        if($(this).val()) {
         var upsrlm_connection_status =$('input[name="CloudLog[upsrlm_connection_status]"]:checked').val();
         var upsrlm_call_status =$('input[name="CloudLog[upsrlm_call_status]"]:checked').val();
          var log_id =$('#cloudlog-log_id').val();
    $.ajax({
            type: "POST",
            url: "/call/upsrlmstatus",
            data: { 'log_id' : log_id , 'upsrlm_connection_status' : upsrlm_connection_status, 'upsrlm_call_status' : upsrlm_call_status},
            
            dataType: "json",
            success: function (data) {
               
            },
            error: function (errormessage) {
                

            }
        });
        }
           if($(this).val() =='10') {
             $(".call_status_10").css("display","block");
            }else{
             $('input[type=checkbox]').prop('checked', false);
             $(".call_status_10").css("display","none");
             $(".action_status_2").css("display","none");
             $('input[name="CloudLog[action_status]"]').prop('checked', false);
             }
    });
    $('input[type=radio][name="CloudLog[action_status]"]').change(function() {
           if($(this).val() =='2') {
             $(".action_status_2").css("display","block");
            }else{
             $('input[type=checkbox]').prop('checked', false); 
             $(".action_status_2").css("display","none");
             
             }
    });    
    });         
JS;
$this->registerJs($js);
?>











