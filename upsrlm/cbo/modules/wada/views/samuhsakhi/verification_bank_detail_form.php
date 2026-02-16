<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use kartik\checkbox\CheckboxX;

$this->title = 'बैंक विवरण सत्यापित करें';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div  class="panel">

            <div class="panel-container show">
                <div class="panel-content">


                    <?php
                    $form = ActiveForm::begin([
                    'enableClientValidation' => false,
                    'enableAjaxValidation' => true,
                                'options' => ['id' => 'verify-form', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>
                    <div class="row">

                        <div class="col-lg-12">    
                            <?php
                            $bcdup = '';
                            if (in_array($model->wada_bank, [0, 1, 2, 3])) {
                                if ($model->wada_model->dupacno > 1) {
                                    $bcdup = '<span class="label label-danger">Duplicate</span>';
                                }
                                ?>
                                <div class="row">

                                    <div class="col-lg-12"><h4>समुह सखी नाम : <?= $model->wada_model->name ?>  </h4></div>
                                    <?php if (in_array($model->wada_bank, [0])) { ?>
                                        <div class="col-lg-12"><h3> समूह सखी विवरण अपलोड नहीं किया गया</h3></div>
                                    <?php } ?>
                                    <?php if (in_array($model->wada_bank, [1])) { ?>
                                        <div class="col-lg-12"><h3>समूह सखी बैंक खाता सत्यापन</h3></div>
                                        <div class="col-lg-12"><h4>सभी जानकारी सही है तो कोई विकल्प नहीं चुना गया है अन्यथा विकल्प का चयन करें </h4></div>
                                        <div class="col-lg-6">
                                            <?php echo $form->field($model, 'verify_wada_passbook_photo')->checkbox(['value' => 2]) ?> 
                                            <?php echo $form->field($model, 'verify_wada_passbook_not')->checkbox(['value' => 2]) ?> 
                                            <?php echo $form->field($model, 'verify_wada_bank_account_no')->checkbox(['value' => 2]) ?> 
                                            <?php echo $form->field($model, 'verify_wada_branch_code_or_ifsc')->checkbox(['value' => 2]); ?> 
                                            <?php echo $form->field($model, 'verify_wada_ifsc_code_entered')->checkbox(['value' => 2]) ?>
                                            <?php echo $form->field($model, 'verify_wada_other')->checkbox(['value' => 2]) ?> 
                                            <?php
                                            echo $form->field($model, 'verify_wada_other_reason', [
                                                'template' => '{input}{error}',
                                            ])->textInput()->label('');
                                            ?>
                                        </div> 
                                        <div class="col-lg-6">
                                            <?= $model->wada_model->passbook_photo != null ? '<span class="profile-picture">
                                        <img style="height:300px;width:300px" src="' . $model->wada_model->passbook_photo_url . '" data-src="' . $model->wada_model->passbook_photo_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?>
                                            <div> बैंक अकाउंट नम्बर : <?= $model->wada_model->bank_account_no . ' ' . $bcdup ?></div>
                                            <div> बैंक अकाउंट का IFSC कोड : <?= $model->wada_model->branch_code_or_ifsc ?></div>
                                        </div>
                                    <?php } ?>
                                    <?php if (in_array($model->wada_bank, [2])) { ?>  
                                        <div class="col-lg-6">
                                            <div class="col-lg-6">
                                                <h4>समूह सखी विवरण सत्यापित </h4>  
                                            </div>
                                            <?= $model->wada_model->passbook_photo != null ? '<span class="profile-picture">
                                        <img style="height:300px" src="' . $model->wada_model->passbook_photo_url . '" data-src="' . $model->wada_model->passbook_photo_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?>
                                            <div> बैंक अकाउंट नम्बर : <?= $model->wada_model->bank_account_no . ' ' . $bcdup ?></div>
                                            <div> बैंक अकाउंट का IFSC कोड : <?= $model->wada_model->branch_code_or_ifsc ?></div>
                                        </div>
                                    <?php } ?>
                                    <?php if (in_array($model->wada_bank, [3])) { ?> 

                                        <div class="col-lg-6">
                                            <h4>समूह सखी विवरण सत्यापित वापसी</h4> 
                                            <h4>समूह सखी विवरण सत्यापित वापसी का कारण</h4>
                                            <p><?= $model->wada_model->wadabankrjregion ?></p>
                                        </div>
                                        <div class="col-lg-6">
                                            <?= $model->wada_model->passbook_photo != null ? '<span class="profile-picture">
                                        <img style="height:300px;width:300px" src="' . $model->wada_model->passbook_photo_url . '" data-src="' . $model->wada_model->passbook_photo_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?>
                                            <div> बैंक अकाउंट नम्बर : <?= $model->wada_model->bank_account_no . ' ' . $bcdup ?></div>
                                            <div> बैंक अकाउंट का IFSC कोड : <?= $model->wada_model->branch_code_or_ifsc ?></div>
                                        </div>
                                    <?php } ?> 
                                </div>    
                            <?php } ?>
                        </div>
                    </div>    
                    <div class="row" style="display: none">
                        <?php echo $form->field($model, 'wada_bank')->hiddenInput()->label(''); ?>

                    </div>    
                    <?php if ($model->wada_bank == 1) { ?>    
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
$jss = <<<JS
  
//    $(document).ready(function() {    
//         alert('rahman');
//     var wada_bank = $('#verificationbankdetailform-wada_bank').val();  
//        alert(wada_bank);
//     
//    });       
JS;
$this->registerJs($jss);
?>


















