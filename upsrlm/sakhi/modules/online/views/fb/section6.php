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
            'id' => 'fd5-section',
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
            <?php if ($model->fd_section_qno == '601') { ?>   
                <div class='card'>
                    <div class="col-lg-12"> 
                        <?php
                        echo Html::activeLabel($model, "sec5_lable", ['class' => 'bold_lable'])." <button asrc='/images/audio/assessment/pre/e_sarkari_6/e-sarkari sewayen 5.1.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>";
                        ?>

                        <?=
                        $form->field($model, 'sec5_birth_death_marriage_certificate', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_building_permits', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_business_license', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_driving_license_application', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_environmental_permit', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_application_vacant_posts_government_jobs', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_land_title_records_registration', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_personal_id_card', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_social_security_schemes_applications', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_passport_visa_application', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_payment_of_fee_and_penalty', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_registering_an_fir_with_police', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>

                        <?= $form->field($model, 'sec5_payment_of_utilities')->radioList($model->yes_no_option) ?>
                        <?=
                        $form->field($model, 'sec5_business_registration', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_vehicle_registration', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_application_for_change_residence_address', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                        <?=
                        $form->field($model, 'sec5_pay_tax', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->yes_no_option)
                        ?>
                    </div>
                </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '602') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec5_do_you_get_all_these_services_easily', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->sec5_do_you_get_all_these_services_easily_option, $option)->label("5.2 क्या ये सभी सेवाएँ आपको सुगम रूप से मिल जाता है <button asrc='/images/audio/assessment/pre/e_sarkari_6/e-sarkari sewayen 5.2.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>  
                    </div>
                </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '603') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec5_go_government_office_for_these_government_services', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->sec5_go_government_office_for_these_government_services_option, $option)->label("5.3 क्या इन सरकारी सेवाओं के लिए आपको सरकारी ऑफिस में जाना पढ़ता है <button asrc='/images/audio/assessment/pre/e_sarkari_6/e-sarkari sewayen 5.3.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>  
                    </div>
                </div>
                 <?php } ?>
                <?php if ($model->fd_section_qno == '604') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec5_how_it_cost_to_get_such_government_service', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->sec5_how_it_cost_to_get_such_government_option, $option)->label("5.4 ऐसी किसी एक सरकारी सेवा को प्राप्त करने के लिए कितना खर्च हो जाता है <button asrc='/images/audio/assessment/pre/e_sarkari_6/e-sarkari sewayen 5.4.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                        ?>  
                    </div>
                </div>
                 <?php } ?>
                <?php if ($model->fd_section_qno == '605') { ?>  
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'sec5_high_speed_internet_panchayat_sahayak', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->sec5_high_speed_internet_panchayat_sahayakcost_option, $option)->label("5.5 हाई स्पीड इंटरनेट होने से, क्या ये सुविधाएँ आसानी से ग्राम पंचायत स्तर पर ही पंचायत सहायक के माध्यम से उपलब्ध हो पायेंगी <button asrc='/images/audio/assessment/pre/e_sarkari_6/e-sarkari sewayen 5.5.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
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