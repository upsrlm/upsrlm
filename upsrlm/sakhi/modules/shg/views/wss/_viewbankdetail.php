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
   

