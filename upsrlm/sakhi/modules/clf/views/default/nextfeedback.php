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
            <div class="text-center"> <b>उत्तर प्रदेश राज्य ग्रामीण आजीविका मिशन,</b> <br/>
                ग्राम्य विकास विभाग, उत्तर प्रदेश शासन <br/>
                संकुल के बहीखातों के रखरखाव का कार्य: हस्त-लिखित रजिस्टर या मोबाइल ऐप का विकल्प 
            </div>
        </div>
        <div class="col-lg-12">
            <div>
                <h2>क्लस्टर-स्तरीय संकुल द्वारा मोबाइल ऐप के उपयोगिता पर आँकलन प्रपत्र</h2> 
                <p>
                    <strong>दिशा निर्देश –</strong>
                <ul>
                    <li>ये प्रश्नावली कोई भी संकुल सदस्य अकेले ना भरें । कम से कम संकुल के पदाधिकारी एवं लेखाकार साथ मिलकर भरें ।</li>  
                    <li>सभी प्रश्नों के उत्तर भरना अनिवार्य है । कोई भी प्रश्न ना छोड़े ।</li>
                    <li>पूरा प्रश्नावली एक ही बार में भरना आवश्यक है । अगर आप प्रश्नावली अधूरे छोड़ देते हैं तो आपको दोबारा भरना शुरू करना पड़ सकता है ।</li>
                    <!--                    <li>सबसे अंत में, जिन्होंने मिलकर ये प्रश्नावली भरा वे एक ग्रुप-सेल्फी अपलोड करें ।</li>-->
                </ul>    
                </p>
            </div>
            <div class='panel-body'>
                <?php $form = ActiveForm::begin(['id' => 'form-clf-feedback', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
                <?php
                if (isset($model->p9ques)) {
                    echo "<div class='card'>";
                    echo "<div class='col-lg-12'>";
                    echo $form->field($model, 'ques_9a')->hiddenInput();
                    foreach ($model->p9ques as $pques) {
                        echo "<div class='card'>";
                        echo "<div class='col-lg-12'>";
                        echo $form->field($model, $pques)->hiddenInput();
                        echo $form->field($model, $pques . 'a', [
                            'template' => '{input}{error}',
                        ])->textInput(['placeholder' => 'न्यूनतम शुल्क', 'type' => 'number', 'min' => 1, 'max' => 99, 'step' => 1, 'pattern' => "[0-9]{10}"])->label('');
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "</div>";
                }
                ?>
                <?php
                if (isset($model->other9ques)) {
                    echo "<div class='card'>";
                    echo "<div class='col-lg-12'>";
                    echo $form->field($model, 'ques_9b')->hiddenInput();
                    foreach ($model->other9ques as $oques) {
                        echo "<div class='card'>";
                        echo "<div class='col-lg-12'>";
                        echo $form->field($model, $oques)->checkbox(['value' => 1]);
                        echo $form->field($model, $oques . 'a', [
                            'template' => '{input}{error}',
                        ])->textInput(['placeholder' => 'न्यूनतम शुल्क', 'type' => 'number', 'min' => 1, 'max' => 99, 'step' => 1, 'pattern' => "[0-9]{10}"])->label('');
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "</div>";
                }
                ?>


                <div class='card'>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'ques_10')->radioList($model->ques_10_option, ['separator' => '<br/>']); ?>  
                        <?php $form->field($model, 'group_photo', ['enableClientValidation' => true])->fileInput(['multiple' => false, 'accept' => 'image/*']) ?>
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
<?php
$js = <<<JS
    $(document).ready(function() {
        var ques8 = $('input[name="CboClfFeedbackForm[ques_8]"]:checked').val();
        if(ques8 == '1')
    {
        $('#yes').css("display","block");
    }
    else
    {
        $('#yes').css("display","none");
    }
       $('input[type="radio"]').click(function(){
        var ques8 = $('input[name="CboClfFeedbackForm[ques_8]"]:checked').val();
        if(ques8 == '1')
    {
        $('#yes').css("display","block");
    }
    else
    {
        $('#yes').css("display","none");
    }
    });
    var toc =["cboclffeedbackform-ques_91","cboclffeedbackform-ques_92","cboclffeedbackform-ques_93","cboclffeedbackform-ques_94","cboclffeedbackform-ques_95","cboclffeedbackform-ques_96","cboclffeedbackform-ques_97","cboclffeedbackform-ques_98","cboclffeedbackform-ques_99"];    
    
    $("#cboclffeedbackform-ques_91 , #cboclffeedbackform-ques_92 , #cboclffeedbackform-ques_93 , #cboclffeedbackform-ques_94, #cboclffeedbackform-ques_95, #cboclffeedbackform-ques_96 , #cboclffeedbackform-ques_97, #cboclffeedbackform-ques_98, #cboclffeedbackform-ques_99").on('change', function() {
    var cha=[]
    if ($("#cboclffeedbackform-ques_91").is(':checked')){
         cha.push("cboclffeedbackform-ques_91");
        }
        if ($("#cboclffeedbackform-ques_92").is(':checked')){
         cha.push("cboclffeedbackform-ques_92");
        }
        if ($("#cboclffeedbackform-ques_93").is(':checked')){
           cha.push("cboclffeedbackform-ques_93");
        }
        if ($("#cboclffeedbackform-ques_94").is(':checked')){
        cha.push("cboclffeedbackform-ques_94");
        }
        if ($("#cboclffeedbackform-ques_95").is(':checked')){
        cha.push("cboclffeedbackform-ques_95");
        }
        if ($("#cboclffeedbackform-ques_96").is(':checked')){
        cha.push("cboclffeedbackform-ques_96");
        }
         if ($("#cboclffeedbackform-ques_97").is(':checked')){
           cha.push("cboclffeedbackform-ques_97");
        }
        if ($("#cboclffeedbackform-ques_98").is(':checked')){
        cha.push("cboclffeedbackform-ques_98");
        }
        if ($("#cboclffeedbackform-ques_99").is(':checked')){
        cha.push("cboclffeedbackform-ques_99");
        
        }
        if(cha.length==3){
        array1 = toc.filter(val => !cha.includes(val));
        
        $.each( array1, function( index, value ){
         $("#"+value).attr("disabled", true);
         });
        
        }
        if(cha.length < 3){
        array2 = toc.filter(val => !cha.includes(val));
        
        $.each( array2, function( index, value ){
         $("#"+value).attr("disabled", false);
         });
        }
       
});
    });         
JS;
$this->registerJs($js);
?>