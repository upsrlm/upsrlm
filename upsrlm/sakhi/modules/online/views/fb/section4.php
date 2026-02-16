<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = $name;
$app = new \sakhi\components\App();
$option = [];
?>
<?php
$form = ActiveMobileForm::begin([
            'id' => 'fd3-section',
            'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
        ]);
?>
<div class='card'>
<div class="col-lg-12">
    <div class="text-center"> 
        <h3>
            <?= $this->title ?>
        </h3>
    </div>
</div>
    <div class="col-lg-12">

        <div class='card-body'>

            <?php if ($model->fd_section_qno == '401') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec3_agri_related_features_accessed_mobile', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->checkboxList($model->sec3_agri_related_features_accessed_mobile1_option)->label("3.1 क्या स्मार्टफ़ोन/ टच-वाला मोबाइल फ़ोन के माध्यम से कृषि-संबंधी सुविधाएँ प्राप्त की जा सकते है <button asrc='/images/audio/assessment/pre/agri_tech_4/Agri tech 3.1.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>
                    </div>
                </div>
            <?php } ?>
            <?php if ($model->fd_section_qno == '402') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec3_facility_available_benefit_you', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->checkboxList($model->sec3_facility_available_benefit_you_option)->label("3.2 अगर ऐसी सुविधा हैं/ हो, तो क्या इससे आपको फ़ायदा होगा? <button asrc='/images/audio/assessment/pre/agri_tech_4/Agri tech 3.2.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>
                    </div>
                </div>
            <?php } ?>
            <?php if ($model->fd_section_qno == '403') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec3_interested_agriculture_provided_smartphones', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->checkboxList($model->sec3_interested_agriculture_provided_smartphones_option)->label("3.3 अगर स्मार्टफ़ोन पर कृषि संबंधी सेवाओं की सुविधा दे जाती है, तो निम्न में से किन किन सुविधा में आप रुचि लेंगे? <button asrc='/images/audio/assessment/pre/agri_tech_4/Agri tech 3.3.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>
                    </div>
                </div>
            <?php } ?>
            <?php if ($model->fd_section_qno == '404') { ?>  
            <div class='card'>
                <div class="col-lg-12">    
                    <?=
                    $form->field($model, 'sec3_maximum_fee_agri_related_facilities_arranged', [
                        'labelOptions' => ['class' => 'bold_lable']
                    ])->radioList($model->sec3_maximum_fee_agri_related_facilities_arranged_option, $option)->label("3.4 अगर स्मार्टफ़ोन आधारित कृषि-संबंधित सुविधाएँ व्यवस्थित की जाये तो अधिकतम कितनी फ़ीस होनी चाहिए <button asrc='/images/audio/assessment/pre/agri_tech_4/Agri tech 3.4.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                    ?>  
                </div>
            </div>
            <?php } ?>
            <div class="form-group text-center">
                <div style="display: none">
                    <?= $form->field($model, 'fd_section_qno')->hiddenInput()->label('') ?> 
                    <?= $form->field($model, 'fd_section')->hiddenInput(['value' => $section])->label('') ?> 
                    <?= $form->field($model, 'user_id')->hiddenInput()->label('') ?>
                    <?= $form->field($model, 'id')->hiddenInput()->label('') ?>
                </div>     
                <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                <a href="<?= '/online/fb/form' ?>" class="btn btn-dark"><i class="fal fa fa-arrow-left" aria-hidden="true"></i><span> वापस</span> </a> 
            </div>     
        </div>
    </div>    
</div>  
<?php ActiveMobileForm::end(); ?>
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