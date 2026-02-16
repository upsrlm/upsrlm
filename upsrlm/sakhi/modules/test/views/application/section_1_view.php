<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use common\models\wada\master\WadaApplicationMasterCast;
use common\models\wada\master\WadaApplicationMasterEducationalLevel;
use common\models\wada\master\WadaApplicationMasterMarriageStatus;
use common\models\wada\master\WadaApplicationMasterVocationalTraining;

$app = new \sakhi\components\App();
?>

<div class="subheader" style="text-align: center">
    <h3 class="subheader-title">
        Section 1 : बेसिक सूचना
    </h3>
</div>
<div class="card">
    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "name") ?>;
            <div class="form-group"><?= isset($model->name) ? $model->name : '' ?></div>

        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "shg_name") ?>;
            <div class="form-group"><?= isset($model->shg->name_of_shg) ? $model->shg->name_of_shg : '' ?></div>

        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "mobile_number") ?>;
            <div class="form-group"><?= isset($model->mobile_number) ? $model->mobile_number : '' ?></div>

        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "alt_mobile_number") ?>;
            <div class="form-group"><?= isset($model->alt_mobile_number) ? $model->alt_mobile_number : '' ?></div>

        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "whatsapp_number") ?>;
            <div class="form-group"><?= isset($model->whatsapp_number) ? $model->whatsapp_number : '' ?></div>

        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "dob") ?>;
            <div class="form-group"><?= isset($model->dob) ? $model->dob : '' ?></div>

        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "guardian_name") ?>;
            <div class="form-group"><?= isset($model->guardian_name) ? $model->guardian_name : '' ?></div>

        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "academic_level") ?>;
            <div class="form-group"><?= isset($model->edu->name_hi) ? $model->edu->name_hi : '' ?></div>

        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "vocational_professional_training") ?>;
            <div class="form-group"><?= isset($model->vpthtml) ? $model->vpthtml : '' ?></div>

        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "social_class") ?>;
            <div class="form-group"><?= isset($model->cast->name_hi) ? $model->cast->name_hi : '' ?></div>

        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "marital_status") ?>;
            <label for="applicationform-training"></label>
            <div class="form-group"><?= isset($model->marriagestatus->name_hi) ? $model->marriagestatus->name_hi : '' ?></div>

        </div>
    </div>

    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "house_member_details") ?>
            <label for="applicationform-training">परिवार में कितने सदस्य हैं, किस उम्र-श्रेणी के?</label>
            <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                <div class="">
                    <label for="applicationform-training">06 वर्ष से कम</label>
                    <div class="form-group"><?= isset($model->house_member_details1) ? $model->house_member_details1 : '' ?></div>
                </div>
                <div class="">
                    <label for="applicationform-training">07-11 वर्ष</label>
                    <div class="form-group"><?= isset($model->house_member_details2) ? $model->house_member_details2 : '' ?></div>
                </div>
                <div class="">
                    <label for="applicationform-training">12-17 वर्ष</label>
                    <div class="form-group"><?= isset($model->house_member_details3) ? $model->house_member_details3 : '' ?></div>
                </div>
                <div class="">
                    <label for="applicationform-training">18 वर्ष से ज़्यादा</label>
                    <div class="form-group"><?= isset($model->house_member_details4) ? $model->house_member_details4 : '' ?></div>
                </div>
            </div>

        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <?php echo Html::activeLabel($form, "aadhar_number") ?>;
            <div class="form-group"><?= isset($model->aadhar_number) ? $model->aadhar_number : '' ?></div>

        </div>
    </div> 
    <div class='card'>
        <div class="col-lg-12">  
            <label for="applicationform-training">आधार फ्रंट फोटो </label>
            <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                <?= $model->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->aadhar_front_photo_url . '" data-src="' . $model->aadhar_front_photo_url . '"  class="lozad" title="आधार फ्रंट फोटो"/>
                                        </span> ' : '-' ?>
            </div>
        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <label for="applicationform-training">आधार बैक फोटो  </label>
            <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                <?= $model->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->aadhar_back_photo_url . '" data-src="' . $model->aadhar_back_photo_url . '"  class="lozad" title="आधार बैक फोटो"/>
                                        </span> ' : '-' ?>  
            </div>
        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">
            <?php echo Html::activeLabel($form, "pan_no") ?>;
            <div class="form-group"><?= isset($model->pan_no) ? $model->pan_no : '' ?></div>
        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <label for="applicationform-training">पैन फोटो  </label>
            <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                <?= $model->pan_photo != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->pan_photo_url . '" data-src="' . $model->pan_photo_url . '"  class="lozad" title="पैन फोटो"/>
                                        </span> ' : '-' ?>  
            </div>
        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">
            <?php echo Html::activeLabel($form, "bank_account_no") ?>;
            <div class="form-group"><?= isset($model->bank_account_no) ? $model->bank_account_no : '' ?></div>
        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">
            <?php echo Html::activeLabel($form, "bank_id") ?>;
            <div class="form-group"><?= isset($model->name_of_bank) ? $model->name_of_bank : '' ?></div>
        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">
            <?php echo Html::activeLabel($form, "branch") ?>;
            <div class="form-group"><?= isset($model->branch) ? $model->branch : '' ?></div>
        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">
            <?php echo Html::activeLabel($form, "branch_code_or_ifsc") ?>;
            <div class="form-group"><?= isset($model->branch_code_or_ifsc) ? $model->branch_code_or_ifsc : '' ?></div>
        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <label for="applicationform-training">पासबुक फोटो</label>
            <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                <?= $model->passbook_photo != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->passbook_photo_url . '" data-src="' . $model->passbook_photo_url . '"  class="lozad" title="पैन फोटो"/>
                                        </span> ' : '-' ?>  
            </div>
        </div>
    </div>
    <div class='card'>
        <div class="col-lg-12">  
            <label for="applicationform-training">प्रोफाइल फोटो</label>
            <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                <?= $model->profile_photo != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->profile_photo_url . '" data-src="' . $model->profile_photo_url . '"  class="lozad" title="प्रोफाइल फोटो "/>
                                        </span> ' : '-' ?>
            </div>
        </div>
    </div>

</div>    

