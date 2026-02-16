<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = 'पोस्ट मूल्यांकन';
$app = new \sakhi\components\App();
$option = [];
?>

<?php
$form = ActiveMobileForm::begin([
            'id' => 'fd-section',
            'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
        ]);
?>
<div class="subheader" style="text-align: center">
    <h1 class="subheader-title">
        हाई स्पीड इंटरनेट परियोजना

    </h1>

</div>

<div class="subheader" style="text-align: center">

    <h1 class="subheader-title">
        प्रूफ ऑफ़ कॉन्सेप्ट (राउंड 2) की प्रगति तथा सभी पायलट ग्राम पंचायतों में मॉडल सिस्टम का बेंचमार्क स्थिति का निर्धारण
    </h1>
</div>
<div class="card">
    <div class="col-lg-12">
        <div class="text-center"> 
            <h1 class="subheader-title">
                <?= $this->title ?>
            </h1>
        </div>
    </div>
    <div class="col-lg-12">

        <div class='card-body'>
            <div class="card">
                <div class="col-lg-12"> 
                    <?php
                    echo $form->field($model, 'gram_panchayat_code')->label('ग्राम पंचायत')->widget(kartik\select2\Select2::classname(), [
                        'data' => $model->gp_option,
                        'size' => Select2::MEDIUM,
                        'options' => ['placeholder' => 'ग्राम पंचायत', 'multiple' => FALSE],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?> 
                </div>     
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'connection_availability', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->radioList($model->yes_no_option, $option)->label('Connection Availability कनेक्शन की उपलब्धता')
                    ?>  
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'internet_service_provider', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->checkboxList($model->internet_service_provider_option)
                    ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'installation_place', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->checkboxList($model->installation_place_option)
                    ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'connectivity_type', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->checkboxList($model->connectivity_type_option)
                    ?>
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'bandwidth_speed', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->textInput([]);
                    ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'population_of_gp', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->textInput([]);
                    ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'place_of_main_equipment', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->textInput([]);
                    ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'number_of_wifi_access_point', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->textInput([]);
                    ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'places_of_wifi_access_point', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->textInput([]);
                    ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'maximum_speed', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->textInput([]);
                    ?> 
                </div>
            </div>
             <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'latency_in_seconds', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->textInput([]);
                    ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'wifi_access_point_range', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->textInput([]);
                    ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'no_of_users', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->textInput([]);
                    ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'average_speed', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->textInput([]);
                    ?> 
                </div>
            </div>
            <h3>
                Kind of Activities
            </h3>
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'social_media', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->checkboxList($model->social_media_option)
                    ?>
                    <?=
                    $form->field($model, 'oot_platforms', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->checkboxList($model->oot_platforms_option)
                    ?>
                    <?=
                    $form->field($model, 'ecommerce_platforms', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->checkboxList($model->ecommerce_platforms_option)
                    ?>
                    <?=
                    $form->field($model, 'tele_medicine', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->checkboxList($model->tele_medicine_option)
                    ?>
                    <?=
                    $form->field($model, 'online_vc', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->checkboxList($model->online_vc_option)
                    ?>
                    <?=
                    $form->field($model, 'upi_wallets', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->checkboxList($model->upi_wallets_option)
                    ?>
                    <?=
                    $form->field($model, 'edutech', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->checkboxList($model->edutech_option)
                    ?>
                     <?=
                    $form->field($model, 'online_gaming_platforms', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->checkboxList($model->online_gaming_platforms_option)
                    ?>
                     <?=
                    $form->field($model, 'news', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->checkboxList($model->news_option)
                    ?>
                </div>
            </div>
           
            <div class="form-group text-center">
               
                <?= $form->field($model, 'user_id')->hiddenInput()->label('') ?>

                <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                <a href="<?= '/online/fb/form' ?>" class="btn btn-dark"><i class="fal fa fa-arrow-left" aria-hidden="true"></i><span> वापस</span> </a> 
            </div>     
        </div>
    </div>    
</div>  
<?php ActiveMobileForm::end(); ?>
<?php
$style = <<< CSS
 img[src=""] {
        display: none;
    }  

CSS;
$this->registerCss($style);
?>
<?php
$style1 = <<< CSS
 .card {
    margin-bottom: 5px !important;
}
.bold_lable {
  font-weight: bold !important;  
}
CSS;
$this->registerCss($style1);
?>
<?php
$style = <<< CSS
 .form-group {
  margin-bottom: 0.5rem !important;
}     
CSS;
$this->registerCss($style);
?>
<?php
$js = <<<JS
    $(document).ready(function() {     
     
    
    });         
JS;
$this->registerJs($js);
?>