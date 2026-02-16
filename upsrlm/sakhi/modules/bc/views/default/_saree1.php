<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$scenario_form = '';
?>
<script>
    function takePictureSarre1(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDatasaree1(data) {
        document.getElementById('saree1-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('bcsareeackform-get_saree1_quality_photo').setAttribute('value', data);


    }
    function takePictureSarre2(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDatasaree2(data) {
        document.getElementById('bcsareeackform-get_saree2_quality_photo').setAttribute('value', data);
        document.getElementById('saree2-image').setAttribute('src', 'data:image/png;base64,' + data);

    }
    var date1 = <?= isset($model->get_saree1_date) ? strtotime($model->get_saree1_date) . '000' : 0 ?>;
    var date2 = <?= isset($model->get_saree2_date) ? strtotime($model->get_saree2_date) . '000' : 0 ?>;
    var mindate = <?= strtotime('2021-06-01') . '000' ?>;
    var maxdate = <?= time() . '000' ?>;
</script>
<div class='card'>
    <div class="col-lg-12">    
        <?= $form->field($model, 'saree1_acknowledge')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>  
    </div>
</div>
<div class="saree1_acknowledge">
    <div class='card'>
        <div class="col-lg-12"> 
            <?php
            echo $form->field($model, "get_saree1_date")->widget(DatePicker::classname(), [
                'value' => $model->get_saree1_date,
                'options' => ['placeholder' => 'बीसी सखी यूनिफ़ॉर्म साड़ी 1 प्राप्त दिनांक', 'class' => 'calculateday', 'readonly' => 'readonly'],
                'pickerIcon' => '<i class="fal fa-calendar-alt text-primary"></i>',
                'removeIcon' => '<i class="fal fa-trash text-danger"></i>',
                'pluginOptions' => [
                    'readonly' => 'readonly',
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose' => true,
                    'minDate' => '2022-01-01',
                    'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
                ],
            ])->label('बीसी सखी यूनिफ़ॉर्म साड़ी 1 प्राप्त दिनांक');
            ?>
            <?php
//            $form->field($model, 'get_saree1_date', [
//                'inputTemplate' => '<div class="input-group"><div class="input-group-prepend">
//        <span class="input-group-text"><i class="fal fa-calendar-alt text-primary"></i> </span>
//    </div>{input}</div>',
//            ])->textInput(['placeholder' => 'बीसी सखी यूनिफ़ॉर्म साड़ी 1 प्राप्त दिनांक', 'readonly' => 'readonly', 'onclick' => "javascript:return showCalender(date1,mindate,maxdate,'bcsareeackform-get_saree1_date');"])->label('बीसी सखी यूनिफ़ॉर्म साड़ी 1 प्राप्त दिनांक')
//            
           ?>  
        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <?= $form->field($model, 'get_saree1_packed_new')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>
        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">
            <?= $form->field($model, 'get_saree1_quality')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>  
        </div>
    </div>
    <div class='card quality'>
        <div class="col-lg-12">  
            <?php
            echo Html::activeLabel($model, "get_saree_quality_no")
            ?>
            <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                <?= $form->field($model, 'get_saree1_quality_no_1')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>  
                <?= $form->field($model, 'get_saree1_quality_no_2')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>  
                <?= $form->field($model, 'get_saree1_quality_no_3')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>  
                <?= $form->field($model, 'get_saree1_quality_no_4')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?> 
                <?= $form->field($model, 'get_saree1_quality_no_other')->radioList([1 => 'हाँ', 2 => 'नहीं'], ['separator' => '']); ?>  
            </div>     
        </div>     
    </div>
    <div class='card'>
        <div class="col-lg-12">
            <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePictureSarre1('imageDatasaree1')">
                <i class="fal fa-camera"></i> बीसी सखी यूनिफ़ॉर्म साड़ी 1 फोटो अपलोड करें
            </button>
            <?= $form->field($model, 'get_saree1_quality_photo')->hiddenInput()->label('') ?>
            <img id="saree1-image" src="" class="img-responsive" width="200" height="300" />
        </div>
    </div>
</div>    
<?php
$js = <<<JS
    $(document).ready(function() {
        $(".saree1_acknowledge").css("display","none");
        $(".quality").css("display","none");
       $('input[type=radio][name="BCSareeAckForm[get_saree1_quality]"]').change(function() {
        if($(this).val()=='1') {
        $(".quality").css("display","none");
        } else{
        $(".quality").css("display","block");
        }
    });
         if($('input[type=radio][name="BCSareeAckForm[saree1_acknowledge]"]:checked').val()=='1'){
              $(".saree1_acknowledge").css("display","block");
        }  

         if($('input[type=radio][name="BCSareeAckForm[saree1_acknowledge]"]:checked').val()=='2'){
            $(".saree1_acknowledge").css("display","none");
        }

        $('input[type=radio][name="BCSareeAckForm[saree1_acknowledge]"]').change(function() {
            if($(this).val() =='1'){
                $(".saree1_acknowledge").css("display","block");
               
               
            }else{ 
               $(".saree1_acknowledge").css("display","none");
             

            }
        })

        // Rest Element Values of This Form
        $('form').change(function(e)
        {
            
            
        });

       
    });
JS;
$this->registerJs($js);
?>