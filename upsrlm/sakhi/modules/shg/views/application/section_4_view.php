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
        Section 4 : नेतृत्व
    </h3>
</div>

<div class="card">

    <div class="col-lg-12">

        <div class='card-body'>
            <div class='card'>
                <div class="col-lg-12">  
                    <label for="applicationform-dob">आपके स्वयं सहायता समूह का नाम ?</label>
                    <div class="form-group"><?= isset($model->shg->name_of_shg) ? $model->shg->name_of_shg : '' ?></div>

                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">  
                    <label for="applicationform-dob">क्या आप पदाधिकारी भी हैं?</label>
                    <div class="form-group"><?= $model->existing_member == 1 ? 'हाँ' : 'नहीं' ?></div>

                </div>
            </div>
            <?php if ($model->existing_member == 1) { ?>
                <div class='card'>
                    <div class="col-lg-12">  
                        <label for="applicationform-dob">अगर हाँ तो क्या?</label>
                        <div class="form-group"><?= isset($model->officerhtml) ? $model->officerhtml : '' ?></div>

                    </div>
                </div>
            <?php } ?>
            <div class='card'>
                <div class="col-lg-12">  
                    <label for="applicationform-dob">क्या आप और भी किसी संगठन के सदस्य या पदाधिकारी हैं</label>
                    <div class="form-group"><?= isset($model->ismember->name_hi) ? $model->ismember->name_hi : '' ?></div>

                </div>
            </div>
            <?php if ($model->applicant_member_other_organization == '1') { ?>
                <div class='card'>
                    <div class="col-lg-12">  
                        <label for="applicationform-dob">अगर हाँ तो</label>
                        <div class="form-group"><?= isset($model->memberhtml) ? $model->memberhtml : '' ?></div>

                    </div>
                </div>
            <?php } ?>
            <?php if ($model->applicant_member_other_organization == '2') { ?> 
                <div class='card'>
                    <div class="col-lg-12">  
                        <label for="applicationform-dob">अगर नहीं, तो क्या आप भविष्य में कभी पंचायत या कोई और चुनाव लड़ना चाहतीं हैं?</label>
                        <div class="form-group"><?= isset($model->electionf->name_hi) ? $model->electionf->name_hi : '' ?></div>

                    </div>
                </div>
            <?php } ?>
            <?php if ($model->election_in_future == '1') { ?> 
                <div class='card'>
                    <div class="col-lg-12">  
                        <label for="applicationform-dob">अगर हाँ, तो क्यों</label>
                        <div class="form-group"><?= isset($model->electionfhtml) ? $model->electionfhtml : '' ?></div>

                    </div>
                </div>
            <?php } ?>
            <div class='card'>
                <div class="col-lg-12">  
                    <label for="applicationform-dob">सक्षम नेतृत्व करने के लिए आप में प्रमुख तीन कमी क्या हैं</label>
                    <div class="form-group"><?= isset($model->threeshortagehtml) ? $model->threeshortagehtml : '' ?></div>

                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">  
                    <label for="applicationform-dob">क्या आवेदक एक वादा सखी के तौर पर अपनी भूमिका का अंदाज़ा लगा सकती हैं?</label>
                    <div class="form-group"><?= isset($model->guessrole->name_hi) ? $model->guessrole->name_hi : '' ?></div>

                </div>
            </div>
        </div>
    </div>    
</div>    


<style>
    .col-lg-12{
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }
    .card  .card-body {
        padding: 0px
    }
    .card-body .card {
        margin: 5px 0px
    }
    .card-body .card > :last-child, .card-group > :last-child {
        margin-bottom: 10px;
        margin-top:5px;
    }
    .form-group:last-child, .form-group:only-child {
        margin-bottom: 10px;
    }
</style>