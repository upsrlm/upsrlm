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

            <div class='card'>
                <div class="col-lg-12"> 
                    <label class="bold_lable" lable="5.1. क्या आपको इन सभी सरकारी सेवाओं की जानकारी है" for="upwififbdemandside-sec5_lable">5.1. क्या आपको इन सभी सरकारी सेवाओं की जानकारी है</label>
                    <?php
                    echo '<br/>' . Html::activeLabel($model, "sec5_birth_death_marriage_certificate", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->sec5birthdeathmarriagecertificatef ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_building_permits", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->sec5buildingpermitsf ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_business_license", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->sec5businesslicensf ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_driving_license_application", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->sec5drivinglicenseapplicationf ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_environmental_permit", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->sec5environmentalpermitf ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_application_vacant_posts_government_jobs", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec5_application_vacant_posts_government_jobs') ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_land_title_records_registration", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec5_land_title_records_registration') ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_personal_id_card", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec5_personal_id_card') ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_social_security_schemes_applications", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec5_social_security_schemes_applications') ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_passport_visa_application", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec5_passport_visa_application') ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_payment_of_fee_and_penalty", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec5_payment_of_fee_and_penalty') ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_registering_an_fir_with_police", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec5_registering_an_fir_with_police') ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_payment_of_utilities", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec5_payment_of_utilities') ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_business_registration", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec5_business_registration') ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_vehicle_registration", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec5_vehicle_registration') ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_application_for_change_residence_address", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec5_application_for_change_residence_address') ?>
                    <?php
                    echo Html::activeLabel($model, "sec5_pay_tax", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec5_pay_tax') ?>
                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec5_do_you_get_all_these_services_easily", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->sec5doyougetalltheseserviceseasilyf ?>
                </div>
            </div>

            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec5_go_government_office_for_these_government_services", ['class' => 'bold_lable'])
                    ?>  
                    <?= $model->sec5gogovernmentofficeforthesegovernmentservicesf ?>
                </div>
            </div>

            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec5_how_it_cost_to_get_such_government_service", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->sec5howitcosttogetsuchgovernmentservicef ?>
                </div>
            </div>

            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec5_high_speed_internet_panchayat_sahayak", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->sec5highspeedinternetpanchayatsahayakf ?>
                </div>
            </div>

            <div class="form-group text-center">

                <a href="<?= '/online/fb/form' ?>" class="btn btn-dark"><i class="fal fa fa-arrow-left" aria-hidden="true"></i><span> वापस</span> </a>  
            </div>     
        </div>
    </div>    
</div>  

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