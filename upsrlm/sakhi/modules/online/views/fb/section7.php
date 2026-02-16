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
            'id' => 'fd6-section',
            'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
//            'action' => $action_url,
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
            <?php if ($model->fd_section_qno == '701') { ?>    
                <div class='card'>
                    <div class="col-lg-12">   

                        <?=
                        $form->field($model, 'sec6_you_currently_able_watch_ott_id', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->sec6_you_currently_able_watch_ott_option)->label("6.1 क्या वर्तमान में आप यूट्यूब या OTT प्लेटफार्म जैसे कि – हॉटस्टार, नेटफ़्लिक्स, प्राइमवीडियो, ज़ी या सोनी टीवी  इत्यादि देख पाते हैं <button asrc='/images/audio/assessment/pre/ott_7/Ott aur manoranjan 6.1.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>")
                        ?>

                    </div>
                </div>
            <?php } ?>  
            <?php if ($model->fd_section_qno == '702') { ?>        
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec6_entertainment_low_cost_id', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->sec6_entertainment_low_cost_option, $option)->label("6.2 क्या हाई स्पीड इंटरनेट के साथ ऐसी सेवाओं के सुनिश्चित होने से आप को कम खर्चें में मनोरंजन के अच्छी सुविधा उपलब्ध होगी <button asrc='/images/audio/assessment/pre/ott_7/0tt aur manoranjan 6.2.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
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