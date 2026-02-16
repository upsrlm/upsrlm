<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use kartik\checkbox\CheckboxX;

$this->title = 'Verify BC/SHG Bank Account Detail';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div  class="panel">

            <div class="panel-container show">
                <div class="panel-content">


                    <?php
                    $form = ActiveForm::begin([
//                    'enableClientValidation' => false,
//                    'enableAjaxValidation' => true,
                                'options' => ['id' => 'verify-form', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>
                    <div class="row">

                        <div class="col-lg-6">    
                            <?php
                            $bcdup = '';
                            if (in_array($model->bc_bank, [0, 1, 2, 3])) {
                                if ($model->participant_model->dupacno > 1) {
                                    $bcdup = '<span class="label label-danger">Duplicate</span>';
                                }
                                ?>
                                <div class="row">

                                    <div class="col-lg-12"><h4>BC Name : <?= $model->participant_model->name ?>  </h4></div>
                                    <?php if (in_array($model->bc_bank, [0])) { ?>
                                        <div class="col-lg-12"><h3>बीसी बैंक विवरण अपलोड नहीं किया गया</h3></div>
                                    <?php } ?>
    <?php if (in_array($model->bc_bank, [1])) { ?>
                                        <div class="col-lg-12"><h3>BC bank account verification </h3></div>
                                        <div class="col-lg-12"><h4>सभी जानकारी सही है तो कोई विकल्प नहीं चुना गया है अन्यथा विकल्प का चयन करें </h4></div>
                                        <div class="col-lg-6">
                                            <?php echo $form->field($model, 'verify_bc_passbook_photo')->checkbox(['value' => 1]) ?> 
                                            <?php echo $form->field($model, 'verify_bc_passbook_not')->checkbox(['value' => 1]) ?> 
                                            <?php echo $form->field($model, 'verify_bc_bank_account_no')->checkbox(['value' => 1]) ?> 
                                            <?php echo $form->field($model, 'verify_bc_branch_code_or_ifsc')->checkbox(['value' => 1]); ?> 
                                            <?php echo $form->field($model, 'verify_bc_ifsc_code_entered')->checkbox(['value' => 1]) ?>
                                            <?php echo $form->field($model, 'verify_bc_other')->checkbox(['value' => 1]) ?> 
                                            <?php
                                            echo $form->field($model, 'verify_bc_other_reason', [
                                                'template' => '{input}{error}',
                                            ])->textInput()->label('');
                                            ?>
                                        </div> 
                                        <div class="col-lg-6">
                                            <?= $model->participant_model->passbook_photo != null ? '<span class="profile-picture">
                                        <img style="height:300px;width:300px" src="' . $model->participant_model->passbook_photo_url . '" data-src="' . $model->participant_model->passbook_photo_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?>
                                            <div> बैंक अकाउंट नम्बर : <?= $model->participant_model->bank_account_no_of_the_bc . ' ' . $bcdup ?></div>
                                            <div> बैंक अकाउंट का IFSC कोड : <?= $model->participant_model->branch_code_or_ifsc ?></div>
                                        </div>
                                    <?php } ?>
    <?php if (in_array($model->bc_bank, [2])) { ?>  
                                        <div class="col-lg-6">
                                            <div class="col-lg-6">
                                                <h4>बीसी बैंक विवरण सत्यापित </h4>  
                                            </div>
                                            <?= $model->participant_model->passbook_photo != null ? '<span class="profile-picture">
                                        <img style="height:300px" src="' . $model->participant_model->passbook_photo_url . '" data-src="' . $model->participant_model->passbook_photo_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?>
                                            <div> बैंक अकाउंट नम्बर : <?= $model->participant_model->bank_account_no_of_the_bc . ' ' . $bcdup ?></div>
                                            <div> बैंक अकाउंट का IFSC कोड : <?= $model->participant_model->branch_code_or_ifsc ?></div>
                                        </div>
                                    <?php } ?>
    <?php if (in_array($model->bc_bank, [3])) { ?> 

                                        <div class="col-lg-6">
                                            <h4>बीसी बैंक विवरण सत्यापित वापसी</h4> 
                                            <h4>बीसी बैंक विवरण सत्यापित वापसी का कारण</h4>
                                            <p><?= $model->participant_model->bcbankrjregion ?></p>
                                        </div>
                                        <div class="col-lg-6">
                                            <?= $model->participant_model->passbook_photo != null ? '<span class="profile-picture">
                                        <img style="height:300px;width:300px" src="' . $model->participant_model->passbook_photo_url . '" data-src="' . $model->participant_model->passbook_photo_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?>
                                            <div> बैंक अकाउंट नम्बर : <?= $model->participant_model->bank_account_no_of_the_bc . ' ' . $bcdup ?></div>
                                            <div> बैंक अकाउंट का IFSC कोड : <?= $model->participant_model->branch_code_or_ifsc ?></div>
                                        </div>
                                <?php } ?> 
                                </div>    
<?php } ?>
                        </div>

                        <div class="col-lg-6">    
                            <?php
                            $shgdup = '';
                            if ($model->participant_model->cbo_shg_id) {
                                if (in_array($model->shg_bank, [0, 1, 2, 3])) {
                                    if ($model->participant_model->dupshgacno > 1) {
                                        $shgdup = ' <span class="label label-danger">Duplicate</span>';
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12"><h4>Name of SHG : <?= isset($model->shg_model->name_of_shg) ? $model->shg_model->name_of_shg : '' ?>  </h4></div>
                                        <?php if (in_array($model->shg_bank, [0])) { ?>
                                            <div class="col-lg-12"><h3>बीसी स्वयं सहायता समूह बैंक विवरण अपलोड नहीं किया गया</h3></div>
                                        <?php } ?>
        <?php if (in_array($model->shg_bank, [1])) { ?>    
                                            <div class="col-lg-12"><h3>SHG bank account verification </h3></div>
                                            <div class="col-lg-12"><h4>सभी जानकारी सही है तो कोई विकल्प नहीं चुना गया है अन्यथा विकल्प का चयन करें </h4></div>
                                            <div class="col-lg-6">
                                                <?php echo $form->field($model, 'verify_bc_shg_passbook_photo')->checkbox(['value' => 1]); ?> 
                                                <?php echo $form->field($model, 'verify_bc_shg_name')->checkbox(['value' => 1]) ?> 
                                                <?php echo $form->field($model, 'verify_bc_shg_bank_account_no')->checkbox(['value' => 1]) ?> 
                                                <?php echo $form->field($model, 'verify_bc_shg_passbook_not')->checkbox(['value' => 1]) ?> 
                                                <?php echo $form->field($model, 'verify_bc_shg_branch_code_or_ifsc')->checkbox(['value' => 1]) ?> 
                                                <?php echo $form->field($model, 'verify_bc_shg_ifsc_code_entered')->checkbox(['value' => 1]); ?>
                                                <?php echo $form->field($model, 'verify_bc_shg_other')->checkbox(['value' => 1]); ?> 
                                                <?php
                                                echo $form->field($model, 'verify_bc_shg_other_reason', [
                                                    'template' => '{input}{error}',
                                                ])->textInput()->label('');
                                                ?>
                                            </div>
                                            <div class="col-lg-6">
                                                <?= $model->participant_model->passbook_photo_shg != null ? '<span class="profile-picture">
                                        <img style="height:300px;width:300px" src="' . $model->participant_model->passbook_photo_shg_url . '" data-src="' . $model->participant_model->passbook_photo_shg_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?> 
                                                <div> बैंक अकाउंट नम्बर : <?= $model->participant_model->bank_account_no_of_the_shg . ' ' . $shgdup ?></div>
                                                <div> बैंक अकाउंट का IFSC कोड : <?= $model->participant_model->branch_code_or_ifsc_shg ?></div>
                                            </div>
                                        <?php } ?>
        <?php if (in_array($model->shg_bank, [2])) { ?>  
                                            <div class="col-lg-6">
                                                <h4>बीसी स्वयं सहायता समूह बैंक विवरण सत्यापित </h4>  
                                            </div>
                                            <div class="col-lg-6">    
                                                <?= $model->participant_model->passbook_photo_shg != null ? '<span class="profile-picture">
                                        <img style="height:300px;width:300px" src="' . $model->participant_model->passbook_photo_shg_url . '" data-src="' . $model->participant_model->passbook_photo_shg_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?> 
                                                <div> बैंक अकाउंट नम्बर : <?= $model->participant_model->bank_account_no_of_the_shg . ' ' . $shgdup ?></div>
                                                <div> बैंक अकाउंट का IFSC कोड : <?= $model->participant_model->branch_code_or_ifsc_shg ?></div>
                                            </div>
                                        <?php } ?>
        <?php if (in_array($model->shg_bank, [3])) { ?> 

                                            <div class="col-lg-6">
                                                <h4>बीसी स्वयं सहायता समूह बैंक विवरण सत्यापित वापसी</h4> 
                                                <h4>बीसी स्वयं सहायता समूह बैंक विवरण सत्यापित वापसी का कारण</h4>
                                                <p><?= $model->participant_model->bcshgbankrjregion ?></p>
                                            </div>
                                            <div class="col-lg-6">
                                                <?= $model->participant_model->passbook_photo_shg != null ? '<span class="profile-picture">
                                        <img style="height:300px;width:300px" src="' . $model->participant_model->passbook_photo_shg_url . '" data-src="' . $model->participant_model->passbook_photo_shg_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?> 
                                                <div> बैंक अकाउंट नम्बर : <?= $model->participant_model->bank_account_no_of_the_shg . ' ' . $shgdup ?></div>
                                                <div> बैंक अकाउंट का IFSC कोड : <?= $model->participant_model->branch_code_or_ifsc_shg ?></div>
                                            </div>
                                    <?php } ?> 
                                    </div>  
                                <?php
                                }
                            } else {
                                ?>
                                <div class="col-lg-6">
                                    <h4>बीसी स्वयं सहायता समूह मैपिंग नहीं है </h4> 

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
        </div>
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
zoomWindowOffetx: -300
});
}
}); 
observer.observe();     
        
JS;
$this->registerJs($js);
?> 
<?php
$js = <<<JS
     var bc_bank = $('#verificationbankdetailform-bc_bank').val();
    var shg_bank = $('#verificationbankdetailform-shg_bank').val(); 
        
$('#buttonsave').click(function () {
    var bc_bank = $('#verificationbankdetailform-bc_bank').val();
    var shg_bank = $('#verificationbankdetailform-shg_bank').val();
     var chbc=[];
     var chshg=[];    
    if(bc_bank=='1'){
      
      if ($('#verificationbankdetailform-verify_bc_passbook_photo').is(':checked')){
         chbc.push('verificationbankdetailform-verify_bc_passbook_photo');
       }
      if ($('#verificationbankdetailform-verify_bc_passbook_not').is(':checked')){
         chbc.push('verificationbankdetailform-verify_bc_passbook_not');
       }
      if ($('#verificationbankdetailform-verify_bc_bank_account_no').is(':checked')){
         chbc.push('verificationbankdetailform-verify_bc_bank_account_no');
       }
       if ($('#verificationbankdetailform-verify_bc_branch_code_or_ifsc').is(':checked')){
         chbc.push('verificationbankdetailform-verify_bc_branch_code_or_ifsc');
       }
       if ($('#verificationbankdetailform-verify_bc_ifsc_code_entered').is(':checked')){
         chbc.push('verificationbankdetailform-verify_bc_ifsc_code_entered');
       }
      if ($('#verificationbankdetailform-verify_bc_other').is(':checked')){
         chbc.push('verificationbankdetailform-verify_bc_other');
       } 
//       if(chbc.length==0){
//        var r = confirm('Are you confirm verify all information bc sakhi bank detail is correct');
//            if (r == true) {
//                return true;
//            } else {
//                return false;
//            }
//        }   
    } 
    if(shg_bank=='1'){
       
      if ($('#verificationbankdetailform-verify_bc_shg_passbook_photo').is(':checked')){
         chshg.push('verificationbankdetailform-verify_bc_shg_passbook_photo');
       }
      if ($('#verificationbankdetailform-verify_bc_shg_name').is(':checked')){
         chshg.push('verificationbankdetailform-verify_bc_shg_name');
       }
      
       if ($('#verificationbankdetailform-verify_bc_shg_bank_account_no').is(':checked')){
         chshg.push('verificationbankdetailform-verify_bc_shg_bank_account_no');
       }
       if ($('#verificationbankdetailform-verify_bc_shg_passbook_not').is(':checked')){
         chshg.push('verificationbankdetailform-verify_bc_shg_passbook_not');
       }
      if ($('#verificationbankdetailform-verify_bc_shg_branch_code_or_ifsc').is(':checked')){
         chshg.push('verificationbankdetailform-verify_bc_shg_branch_code_or_ifsc');
       }  
      if ($('#verificationbankdetailform-verify_bc_shg_ifsc_code_entered').is(':checked')){
         chshg.push('verificationbankdetailform-verify_bc_shg_ifsc_code_entered');
       }
      if ($('#verificationbankdetailform-verify_bc_shg_other').is(':checked')){
         chshg.push('verificationbankdetailform-verify_bc_shg_other');
       }     
//       if(chshg.length==0){
//        var rs = confirm('Are you confirm verify all information bc sakhi SHG bank detail is correct');
//            if (rs == true) {
//                return true;
//            } else {
//                return false;
//            }
//        }   
    }       
});       
JS;
$this->registerJs($js);
?>


















