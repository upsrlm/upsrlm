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
        Section 6
    </h3>
</div>

<div class="card">

    <div class="col-lg-12">

        <div class='card-body'>
            <div class='card'>

                <div class="col-lg-12">
                    <label for="applicationform-dob">कृपया, मोबाइल से प्राप्त होनेवाले सुविधाओं पर आपकी सहमति जताएँ </label>
                    <div class="form-group"><?= $model->mobilefeaturehtml ?></div>
                </div>

                <div class="card">
                    <div class="col-lg-12">
                        <label for="applicationform-dob">क्या इस तरह के मोबाइल-आधारित सुविधा से आपको फ़ायदा होगा?</label>
                        <div class="form-group"><?= $model->mobilefeaturebenefit ?></div>
                    </div>
                </div>

                <?php if ($model->mobile_feature_benefit == 1) : ?>

                    <div class="card">
                        <div class="col-lg-12">
                            <label for="applicationform-dob">आप ऐसी सुविधाओं के लिए आप कुछ न्यूनतम शुल्क देना स्वीकार करेंगी?</label>
                            <div class="form-group"><?= isset($model->pay) ? 'हाँ' : 'नहीं' ?></div>
                        </div>
                    </div>

                    <?php if ($model->pay == 1) : ?>
                        <div class="card">
                            <div class="col-lg-12">
                                <label for="applicationform-dob">शुल्क के प्रकार</label>
                                <div class="form-group"><?= $model->paytype ?></div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="col-lg-12">
                                <label for="applicationform-dob"> भुगतान शुल्क </label>
                                <div class="form-group"><?= $model->pay_amount ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($model->is_amount_pay == 1) : ?>
                        <div class="card">
                            <div class="col-lg-12">
                                <label for="applicationform-dob"> प्राप्त शुल्क का दिनांक समय </label>
                                <div class="form-group"><?= $model->amount_pay_datetime ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>


                <div class="col-lg-12">
                    <label for="applicationform-dob">इस फ़ॉर्म को भरने में क्या आपको कोई दिक़्क़त हुई ?</label>
                    <div class="form-group"><?= isset($model->problemfill->name_hi) ? $model->problemfill->name_hi : '' ?></div>

                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .col-lg-12 {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }

    .card .card-body {
        padding: 0px
    }

    .card-body .card {
        margin: 5px 0px
    }

    .card-body .card> :last-child,
    .card-group> :last-child {
        margin-bottom: 10px;
        margin-top: 5px;
    }

    .form-group:last-child,
    .form-group:only-child {
        margin-bottom: 10px;
    }
</style>