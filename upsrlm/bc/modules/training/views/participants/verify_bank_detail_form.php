<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use dosamigos\tinymce\TinyMce;
use app\modules\hsc\models\HscAmrutApplication;
use kartik\checkbox\CheckboxX;

$this->title = 'Verify BC/SHG Bank Account Detail';
?>
<div class="panel panel-default">
    <div class='panel-body'>


        <?php
        $form = ActiveForm::begin([
                    'enableClientValidation' => false,
                    'enableAjaxValidation' => true,
                    'options' => ['id' => 'verify-form', 'enctype' => 'multipart/form-data'],
        ]);
        ?>
        <div class="row">
            <div class="col-lg-6">    
                <?php
                $bcdup = '';
                if (in_array($model->bc_bank, [1, 2, 3])) {
                    if ($model->participant_model->dupacno > 1) {
                        $bcdup = '<span class="label label-danger">Duplicate</span>';
                    }
                    $optionsbc = [];
                    if (in_array($model->bc_bank, [2, 3])) {
                        $optionsbc = ['itemOptions' => ['disabled' => true]];
                    }
                    ?>
                    <div class="row">
                        <div class="col-lg-12"><h4>BC Name : <?= $model->participant_model->name ?>  </h4></div>
                        <div class="col-lg-12"><h3>BC bank account verification </h3></div>
                        <div class="col-lg-6">
                            <?php echo $form->field($model, 'verify_bc_passbook_photo')->radioList($model->option, $optionsbc)->label('बीसी सखी के बैंक खातों के फोटो स्पष्ट एवं सटीक है'); ?> 
                            <?php echo $form->field($model, 'verify_bc_bank_account_no')->radioList($model->option, $optionsbc)->label('बीसी सखी के बैंक खाते के सापेक्ष उनके बैंक अकाउंट नम्बर जाँच लिया-सही पाया' . '<br/> (<b>' . $model->participant_model->bank_account_no_of_the_bc . '</b>)' . $bcdup); ?> 
                            <?php echo $form->field($model, 'verify_bc_branch_code_or_ifsc')->radioList($model->option, $optionsbc)->label('बीसी सखी समूह के बैंक अकाउंट का IFSC कोड सही है' . '<br/> (<b>' . $model->participant_model->branch_code_or_ifsc . '</b>)'); ?> 
                            <?php echo $form->field($model, 'verify_bc_shg')->radioList($model->option, $optionsbc)->label('यह जाँच लिया कि बीसी सखी उल्लेखित स्वयं सहायता समूह की सदस्य हैं - किसी दूसरे समूह की नहीं'); ?> 
                        </div> 
                        <div class="col-lg-6">
                            <?= $model->participant_model->passbook_photo != null ? '<span class="profile-picture">
                                        <img style="height:300px" src="' . $model->participant_model->passbook_photo_url . '" data-src="' . $model->participant_model->passbook_photo_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?>  
                        </div>
                    </div>    
                <?php } ?>
            </div>
            <div class="col-lg-6">    
                <?php
                $shgdup = '';
                if (in_array($model->shg_bank, [1, 2, 3])) {
                    if ($model->shg_model->dupacno > 1) {
                        $shgdup = ' <span class="label label-danger">Duplicate</span>';
                    }
                    $optionsshg = [];
                    if (in_array($model->shg_bank, [2, 3])) {
                        $optionsshg = ['itemOptions' => ['disabled' => true]];
                    }
                    ?>
                    <div class="row">
                        <div class="col-lg-12"><h4>Name of SHG : <?= $model->shg_model->name_of_shg ?>  </h4></div>
                        <div class="col-lg-12"><h3>SHG bank account verification </h3></div>
                        <div class="col-lg-6">
                            <?php echo $form->field($model, 'verify_bc_shg_passbook_photo')->radioList($model->option, $optionsshg)->label('समूह के बैंक खातों के फ़ोटो स्पष्ट एवं सटीक है'); ?> 
                            <?php echo $form->field($model, 'verify_bc_shg_bank_account_no')->radioList($model->option, $optionsshg)->label('स्वयं सहायता समूह के बैंक खाते से बैंक अकाउंट का मिलान कर लिया - जाँच लिया कि बैंक अकाउंट नम्बर सही है' . '<br/> (<b>' . $model->participant_model->bank_account_no_of_the_shg . '</b>)' . $shgdup); ?> 
                            <?php echo $form->field($model, 'verify_bc_shg_branch_code_or_ifsc')->radioList($model->option, $optionsshg)->label('स्वयं सहायता समूह के बैंक अकाउंट का IFSC कोड सही है' . '<br/> (<b>' . $model->participant_model->branch_code_or_ifsc_shg . '</b>)'); ?> 
                        </div>
                        <div class="col-lg-6">
                            <?= $model->participant_model->passbook_photo_shg != null ? '<span class="profile-picture">
                                        <img style="height:300px" src="' . $model->participant_model->passbook_photo_shg_url . '" data-src="' . $model->participant_model->passbook_photo_shg_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?> 
                        </div>
                    </div>  
                <?php } ?>
            </div>
        </div>    
        <div class="row" style="display: none">
            <?php echo $form->field($model, 'bc_bank')->hiddenInput()->label(''); ?>
            <?php echo $form->field($model, 'shg_bank')->hiddenInput()->label(''); ?>
        </div>    
        <?php if ($model->bc_bank == 1 or $model->shg_bank == 1) { ?>    
            <div class="form-group">
                <div class="col-lg-offset-5 col-lg-12">
                    <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                </div>
            </div>
        <?php } ?>   
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$js = <<<JS
observer = lozad('.lozad', {
load: function (el) {
el.src = el.getAttribute('data-src');
$(el).elevateZoom({
//zoomType: 'inner',
//cursor: 'crosshair'        
scrollZoom: true,
responsive: true,       
zoomWindowOffetx: -600
});
}
}); 
observer.observe();     
        
JS;
$this->registerJs($js);
?> 



















