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
                <div class='card'>
                    <div class="col-lg-12">   
                        <?= $form->field($model, 'ques_5')->radioList($model->ques_5_option, ['separator' => '<br/>']); ?>
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'ques_6')->hiddenInput(); ?>
                        <?= $form->field($model, 'ques_61')->checkbox(); ?>
                        <?= $form->field($model, 'ques_62')->checkbox(); ?>
                        <?= $form->field($model, 'ques_63')->checkbox(); ?>
                        <?= $form->field($model, 'ques_64')->checkbox(); ?>
                        <?= $form->field($model, 'ques_65')->checkbox(); ?>
                        <?= $form->field($model, 'ques_66')->checkbox(); ?>
                    </div>     
                </div>  
                <div class='card'>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'ques_7')->radioList($model->ques_7_option, ['separator' => '<br/>']); ?> 
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">
                        <?= $form->field($model, 'ques_8')->radioList($model->ques_8_option, ['separator' => '<br/>']); ?>
                    </div>
                </div>  
                <div id="yes" style="display: none" >
                    <div class='card'>
                        <div class="col-lg-12">
                            <?= $form->field($model, 'ques_9')->hiddenInput(); ?>
                            <div class='card'>
                                <div class="col-lg-12">
                                    <?= $form->field($model, 'ques_91')->checkbox(['value' => 2]); ?>
                                    <?php
                                    echo $form->field($model, 'ques_91oa', [
                                        'template' => '{input}{error}',
                                    ])->radioList($model->ques_9_option, ['separator' => '<br/>']);
                                    ?>

                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">
                                    <?= $form->field($model, 'ques_92')->checkbox(['value' => 2]); ?>
                                    <?php
                                    echo $form->field($model, 'ques_92oa', [
                                        'template' => '{input}{error}',
                                    ])->radioList($model->ques_9_option, ['separator' => '<br/>']);
                                    ?>

                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">
                                    <?= $form->field($model, 'ques_93')->checkbox(['value' => 2]); ?>
                                    <?php
                                    echo $form->field($model, 'ques_93oa', [
//                                        'template' => '{input}{error}',
                                    ])->radioList($model->ques_9_option, ['separator' => '<br/>']);
                                    ?>

                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">
                                    <?= $form->field($model, 'ques_94')->checkbox(['value' => 2]); ?>
                                    <?php
                                    echo $form->field($model, 'ques_94oa', [
//                                        'template' => '{input}{error}',
                                    ])->radioList($model->ques_9_option, ['separator' => '<br/>']);
                                    ?>
                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">
                                    <?= $form->field($model, 'ques_95')->checkbox(['value' => 2]); ?>
                                    <?php
                                    echo $form->field($model, 'ques_95oa', [
//                                        'template' => '{input}{error}',
                                    ])->radioList($model->ques_9_option, ['separator' => '<br/>']);
                                    ?>
                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">
                                    <?= $form->field($model, 'ques_96')->checkbox(['value' => 2]); ?>
                                    <?php
                                    echo $form->field($model, 'ques_96oa', [
//                                        'template' => '{input}{error}',
                                    ])->radioList($model->ques_9_option, ['separator' => '<br/>']);
                                    ?>
                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">
                                    <?= $form->field($model, 'ques_97')->checkbox(['value' => 2]); ?>
                                    <?php
                                    echo $form->field($model, 'ques_97oa', [
//                                        'template' => '{input}{error}',
                                    ])->radioList($model->ques_9_option, ['separator' => '<br/>']);
                                    ?>
                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">
                                    <?= $form->field($model, 'ques_98')->checkbox(['value' => 2]); ?>
                                    <?php
                                    echo $form->field($model, 'ques_98oa', [
//                                        'template' => '{input}{error}',
                                    ])->radioList($model->ques_9_option, ['separator' => '<br/>']);
                                    ?>
                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">
                                    <?= $form->field($model, 'ques_99')->checkbox(['value' => 2]); ?>
                                    <?php
                                    echo $form->field($model, 'ques_99oa', [
//                                        'template' => '{input}{error}',
                                    ])->radioList($model->ques_9_option, ['separator' => '<br/>', 'class' => 'cboclffeedbackform-ques_99oa']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>  
                <div  >
                    <div class='card'>
                        <div class="col-lg-12">
                            <?= $form->field($model, 'ques_10')->radioList($model->ques_10_option, ['separator' => '<br/>']); ?>  
                            <?php $form->field($model, 'group_photo', ['enableClientValidation' => true])->fileInput(['multiple' => false, 'accept' => 'image/*']) ?>
                        </div>
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
        $('#no').css("display","none");
    }
    else
    {
        $('#no').css("display","block");
        $('#yes').css("display","none");
    }
       $('input[type="radio"]').click(function(){
        var ques8 = $('input[name="CboClfFeedbackForm[ques_8]"]:checked').val();
        if(ques8 == '1')
    {
        $('#no').css("display","none");
        $('#yes').css("display","block");
    }
    else
    {   $('#no').css("display","block");
        $('#yes').css("display","none");
    }
    });
    var toc =["cboclffeedbackform-ques_91","cboclffeedbackform-ques_92","cboclffeedbackform-ques_93","cboclffeedbackform-ques_94","cboclffeedbackform-ques_95","cboclffeedbackform-ques_96","cboclffeedbackform-ques_97","cboclffeedbackform-ques_98","cboclffeedbackform-ques_99"];    
       var cha=[];
      if ($("#cboclffeedbackform-ques_91").is(':checked')){
         cha.push("cboclffeedbackform-ques_91");
        $("#i23").attr("disabled", false);
        $("#i24").attr("disabled", false);
        $("#i25").attr("disabled", false);
        $("#i26").attr("disabled", false);
        }
        else {
        $("#i23").prop("checked", false);
        $("#i24").prop("checked", false);
        $("#i25").prop("checked", false);
        $("#i26").prop("checked", false);
        $("#i23").attr("disabled", true);
        $("#i24").attr("disabled", true);
        $("#i25").attr("disabled", true);
        $("#i26").attr("disabled", true);
        }
        
        if ($("#cboclffeedbackform-ques_92").is(':checked')){
         cha.push("cboclffeedbackform-ques_92");
        $("#i27").attr("disabled", false);
        $("#i28").attr("disabled", false);
        $("#i29").attr("disabled", false);
        $("#i30").attr("disabled", false);
        }
        else {
        $("#i27").prop("checked", false);
        $("#i28").prop("checked", false);
        $("#i29").prop("checked", false);
        $("#i30").prop("checked", false);
        $("#i27").attr("disabled", true);
        $("#i28").attr("disabled", true);
        $("#i29").attr("disabled", true);
        $("#i30").attr("disabled", true);
        }
        if ($("#cboclffeedbackform-ques_93").is(':checked')){
           cha.push("cboclffeedbackform-ques_93");
        $("#i33").attr("disabled", false);
        $("#i33").attr("disabled", false);
        $("#i33").attr("disabled", false);
        $("#i34").attr("disabled", false);
        }
        else {
        $("#i31").prop("checked", false);
        $("#i32").prop("checked", false);
        $("#i33").prop("checked", false);
        $("#i34").prop("checked", false);
        $("#i31").attr("disabled", true);
        $("#i32").attr("disabled", true);
        $("#i33").attr("disabled", true);
        $("#i34").attr("disabled", true);
        }
        if ($("#cboclffeedbackform-ques_94").is(':checked')){
        cha.push("cboclffeedbackform-ques_94");
        $("#i35").attr("disabled", false);
        $("#i36").attr("disabled", false);
        $("#i37").attr("disabled", false);
        $("#i38").attr("disabled", false);
        }
        else {
        $("#i35").prop("checked", false);
        $("#i36").prop("checked", false);
        $("#i37").prop("checked", false);
        $("#i38").prop("checked", false);
        $("#i35").attr("disabled", true);
        $("#i36").attr("disabled", true);
        $("#i37").attr("disabled", true);
        $("#i38").attr("disabled", true);
        }
        if ($("#cboclffeedbackform-ques_95").is(':checked')){
        cha.push("cboclffeedbackform-ques_95");
        $("#i39").attr("disabled", false);
        $("#i40").attr("disabled", false);
        $("#i41").attr("disabled", false);
        $("#i42").attr("disabled", false);
        }
        else {
        $("#i39").prop("checked", false);
        $("#i40").prop("checked", false);
        $("#i41").prop("checked", false);
        $("#i42").prop("checked", false);
        $("#i39").attr("disabled", true);
        $("#i40").attr("disabled", true);
        $("#i41").attr("disabled", true);
        $("#i42").attr("disabled", true);
        }
        if ($("#cboclffeedbackform-ques_96").is(':checked')){
        cha.push("cboclffeedbackform-ques_96");
        $("#i43").attr("disabled", false);
        $("#i44").attr("disabled", false);
        $("#i45").attr("disabled", false);
        $("#i46").attr("disabled", false);
        }
        else {
        $("#i43").prop("checked", false);
        $("#i44").prop("checked", false);
        $("#i45").prop("checked", false);
        $("#i46").prop("checked", false);
        $("#i43").attr("disabled", true);
        $("#i44").attr("disabled", true);
        $("#i45").attr("disabled", true);
        $("#i46").attr("disabled", true);
        }
         if ($("#cboclffeedbackform-ques_97").is(':checked')){
           cha.push("cboclffeedbackform-ques_97");
        $("#i47").attr("disabled", false);
        $("#i48").attr("disabled", false);
        $("#i49").attr("disabled", false);
        $("#i50").attr("disabled", false);
        }
        else {
        $("#i47").prop("checked", false);
        $("#i48").prop("checked", false);
        $("#i49").prop("checked", false);
        $("#i50").prop("checked", false);
        $("#i47").attr("disabled", true);
        $("#i48").attr("disabled", true);
        $("#i49").attr("disabled", true);
        $("#i50").attr("disabled", true);
        }
        if ($("#cboclffeedbackform-ques_98").is(':checked')){
        cha.push("cboclffeedbackform-ques_98");
        $("#i51").attr("disabled", false);
        $("#i52").attr("disabled", false);
        $("#i53").attr("disabled", false);
        $("#i54").attr("disabled", false);
        }
        else {
        $("#i51").prop("checked", false);
        $("#i52").prop("checked", false);
        $("#i53").prop("checked", false);
        $("#i54").prop("checked", false);
        $("#i51").attr("disabled", true);
        $("#i52").attr("disabled", true);
        $("#i53").attr("disabled", true);
        $("#i54").attr("disabled", true);
        }
        if ($("#cboclffeedbackform-ques_99").is(':checked')){
        cha.push("cboclffeedbackform-ques_99");
        $("#i55").attr("disabled", false);
        $("#i56").attr("disabled", false);
        $("#i57").attr("disabled", false);
        $("#i58").attr("disabled", false);
        
        }
        else { 
        $("#i55").prop("checked", false);
        $("#i56").prop("checked", false);
        $("#i57").prop("checked", false);
        $("#i58").prop("checked", false);
        $("#i55").attr("disabled", true);
        $("#i56").attr("disabled", true);
        $("#i57").attr("disabled", true);
        $("#i58").attr("disabled", true);
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
    $("#cboclffeedbackform-ques_91 , #cboclffeedbackform-ques_92 , #cboclffeedbackform-ques_93 , #cboclffeedbackform-ques_94, #cboclffeedbackform-ques_95, #cboclffeedbackform-ques_96 , #cboclffeedbackform-ques_97, #cboclffeedbackform-ques_98, #cboclffeedbackform-ques_99").on('change', function() {
    var cha=[];
      if ($("#cboclffeedbackform-ques_91").is(':checked')){
         cha.push("cboclffeedbackform-ques_91");
        $("#i23").attr("disabled", false);
        $("#i24").attr("disabled", false);
        $("#i25").attr("disabled", false);
        $("#i26").attr("disabled", false);
        }
        else {
        $("#i23").prop("checked", false);
        $("#i24").prop("checked", false);
        $("#i25").prop("checked", false);
        $("#i26").prop("checked", false);
        $("#i23").attr("disabled", true);
        $("#i24").attr("disabled", true);
        $("#i25").attr("disabled", true);
        $("#i26").attr("disabled", true);
        }
        
        if ($("#cboclffeedbackform-ques_92").is(':checked')){
         cha.push("cboclffeedbackform-ques_92");
        $("#i27").attr("disabled", false);
        $("#i28").attr("disabled", false);
        $("#i29").attr("disabled", false);
        $("#i30").attr("disabled", false);
        }
        else {
        $("#i27").prop("checked", false);
        $("#i28").prop("checked", false);
        $("#i29").prop("checked", false);
        $("#i30").prop("checked", false);
        $("#i27").attr("disabled", true);
        $("#i28").attr("disabled", true);
        $("#i29").attr("disabled", true);
        $("#i30").attr("disabled", true);
        }
        if ($("#cboclffeedbackform-ques_93").is(':checked')){
           cha.push("cboclffeedbackform-ques_93");
        $("#i31").attr("disabled", false);
        $("#i32").attr("disabled", false);
        $("#i33").attr("disabled", false);
        $("#i34").attr("disabled", false);
        }
        else {
        $("#i31").prop("checked", false);
        $("#i32").prop("checked", false);
        $("#i33").prop("checked", false);
        $("#i34").prop("checked", false);
        $("#i31").attr("disabled", true);
        $("#i32").attr("disabled", true);
        $("#i33").attr("disabled", true);
        $("#i34").attr("disabled", true);
        }
        if ($("#cboclffeedbackform-ques_94").is(':checked')){
        cha.push("cboclffeedbackform-ques_94");
        $("#i35").attr("disabled", false);
        $("#i36").attr("disabled", false);
        $("#i37").attr("disabled", false);
        $("#i38").attr("disabled", false);
        }
        else {
        $("#i35").prop("checked", false);
        $("#i36").prop("checked", false);
        $("#i37").prop("checked", false);
        $("#i38").prop("checked", false);
        $("#i35").attr("disabled", true);
        $("#i36").attr("disabled", true);
        $("#i37").attr("disabled", true);
        $("#i38").attr("disabled", true);
        }
        if ($("#cboclffeedbackform-ques_95").is(':checked')){
        cha.push("cboclffeedbackform-ques_95");
        $("#i39").attr("disabled", false);
        $("#i40").attr("disabled", false);
        $("#i41").attr("disabled", false);
        $("#i42").attr("disabled", false);
        }
        else {
        $("#i39").prop("checked", false);
        $("#i40").prop("checked", false);
        $("#i41").prop("checked", false);
        $("#i42").prop("checked", false);
        $("#i39").attr("disabled", true);
        $("#i40").attr("disabled", true);
        $("#i41").attr("disabled", true);
        $("#i42").attr("disabled", true);
        }
        if ($("#cboclffeedbackform-ques_96").is(':checked')){
        cha.push("cboclffeedbackform-ques_96");
        $("#i43").attr("disabled", false);
        $("#i44").attr("disabled", false);
        $("#i45").attr("disabled", false);
        $("#i46").attr("disabled", false);
        }
        else {
        $("#i43").prop("checked", false);
        $("#i44").prop("checked", false);
        $("#i45").prop("checked", false);
        $("#i46").prop("checked", false);
        $("#i43").attr("disabled", true);
        $("#i44").attr("disabled", true);
        $("#i45").attr("disabled", true);
        $("#i46").attr("disabled", true);
        }
         if ($("#cboclffeedbackform-ques_97").is(':checked')){
           cha.push("cboclffeedbackform-ques_97");
         $("#i47").attr("disabled", false);
        $("#i48").attr("disabled", false);
        $("#i49").attr("disabled", false);
        $("#i50").attr("disabled", false);
        }
        else {
        $("#i47").prop("checked", false);
        $("#i48").prop("checked", false);
        $("#i49").prop("checked", false);
        $("#i50").prop("checked", false);
        $("#i47").attr("disabled", true);
        $("#i48").attr("disabled", true);
        $("#i49").attr("disabled", true);
        $("#i50").attr("disabled", true);
        }
        if ($("#cboclffeedbackform-ques_98").is(':checked')){
        cha.push("cboclffeedbackform-ques_98");
        $("#i51").attr("disabled", false);
        $("#i52").attr("disabled", false);
        $("#i53").attr("disabled", false);
        $("#i54").attr("disabled", false);
        }
        else {
        $("#i51").prop("checked", false);
        $("#i52").prop("checked", false);
        $("#i53").prop("checked", false);
        $("#i54").prop("checked", false);
        $("#i51").attr("disabled", true);
        $("#i52").attr("disabled", true);
        $("#i53").attr("disabled", true);
        $("#i54").attr("disabled", true);
        }
        if ($("#cboclffeedbackform-ques_99").is(':checked')){
        cha.push("cboclffeedbackform-ques_99");
        $("#i55").attr("disabled", false);
        $("#i56").attr("disabled", false);
        $("#i57").attr("disabled", false);
        $("#i58").attr("disabled", false);
        
        }
        else {
        $("#i55").prop("checked", false);
        $("#i56").prop("checked", false);
        $("#i57").prop("checked", false);
        $("#i58").prop("checked", false);
        $("#i55").attr("disabled", true);
        $("#i56").attr("disabled", true);
        $("#i57").attr("disabled", true);
        $("#i58").attr("disabled", true);
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