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
        Section 5 : मल्टी-सेक्टर सेवाओं के बारे में जानकारी
    </h3>
</div>

<div class="card">

    <div class="col-lg-12">

        <div class='card-body'>
            <div class='card'>
                <div class="col-lg-12">  
                    <label for="applicationform-dob">क्या आप को सरकार के अलग अलग योजनाओं एवं उनके प्रावधानों के बारे में मालूम है?</label>
                    <div class="form-group"><?= isset($model->knowgovschemes->name_hi) ? $model->knowgovschemes->name_hi : '' ?></div>

                </div>
            </div> 
            <div class='card'>
                <label style="padding-left:10px" for="applicationform-existing_member_role">क्या आवेदक निम्न योजनाओं के बारे में जानती हैं?</label>
                <div class='card'>
                    <div class="col-lg-12">
                        <label for="applicationform-dob">विधवा पेन्शन योज़ना</label>
                        <div class="form-group">  
                            <?= isset($model->schemes1->name_hi) ? $model->schemes1->name_hi : '' ?>
                        </div>
                        <?php if ($model->applicants_know_about_following_schemes1 == '1') { ?>
                            <label for="applicationform-dob">अगर हाँ, तो इनसे मिलने वाला लाभ क्या है</label>
                            <div class="form-group">  
                                <?= isset($model->schemes1gain->name_hi) ? $model->schemes1gain->name_hi : '' ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <hr/>

                <div class='card'>
                    <label for="applicationform-dob">वृद्धावस्था पेन्शन योज़ना</label>
                    <div class="form-group">  
                        <?= isset($model->schemes2->name_hi) ? $model->schemes2->name_hi : '' ?>
                    </div>
                    <?php if ($model->applicants_know_about_following_schemes2 == '1') { ?>
                        <label for="applicationform-dob">अगर हाँ, तो इनसे मिलने वाला लाभ क्या है</label>
                        <div class="form-group">  
                            <?= isset($model->schemes2gain->name_hi) ? $model->schemes2gain->name_hi : '' ?>
                        </div>
                    <?php } ?>
                </div>

                <hr/>

                <div class='card'>
                    <div class="col-lg-12">
                        <label for="applicationform-dob">प्रधानमंत्री मातृ वंदना योज़ना</label>
                        <div class="form-group">  
                            <?= isset($model->schemes3->name_hi) ? $model->schemes3->name_hi : '' ?>
                        </div>
                        <?php if ($model->applicants_know_about_following_schemes3 == '1') { ?>
                            <label for="applicationform-dob">अगर हाँ, तो इनसे मिलने वाला लाभ क्या है</label>
                            <div class="form-group">  
                                <?= isset($model->schemes3gain->name_hi) ? $model->schemes3gain->name_hi : '' ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <hr/>

                <div class='card'>
                    <div class="col-lg-12">
                        <label for="applicationform-dob">प्रधानमंत्री सुरक्षा बीमा योजना</label>
                        <div class="form-group">  
                            <?= isset($model->schemes4->name_hi) ? $model->schemes4->name_hi : '' ?>
                        </div>
                        <?php if ($model->applicants_know_about_following_schemes4 == '1') { ?>
                            <label for="applicationform-dob">अगर हाँ, तो इनसे मिलने वाला लाभ क्या है</label>
                            <div class="form-group">  
                                <?= isset($model->schemes4gain->name_hi) ? $model->schemes4gain->name_hi : '' ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <hr/>

                <div class='card'>
                    <div class="col-lg-12">
                        <label for="applicationform-dob">प्रधानमंत्री श्रमयोगी मानधन योजना</label>
                        <div class="form-group">  
                            <?= isset($model->schemes5->name_hi) ? $model->schemes5->name_hi : '' ?>
                        </div>
                        <?php if ($model->applicants_know_about_following_schemes5 == '1') { ?>
                            <label for="applicationform-dob"> अगर हाँ, तो इनसे मिलने वाला लाभ क्या है</label>
                            <div class="form-group">  
                                <?= isset($model->schemes5gain->name_hi) ? $model->schemes5gain->name_hi : '' ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>




            </div>
            <div class='card'>
                <div class="col-lg-12">  
                    <label for="applicationform-dob">क्या आप के समूह की सदस्य इन योजनाओं के लाभार्थी हैं</label>
                    <div class="form-group"><?= isset($model->beneficiary->name_hi) ? $model->beneficiary->name_hi : '' ?></div>

                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">  
                    <label for="applicationform-dob">आपके के समूह में ऐसे योजनाओं के पात्रता का स्तर क्या है</label>
                    <div class="form-group"><?= isset($model->eligibility->name_hi) ? $model->eligibility->name_hi : '' ?></div>

                </div>
            </div> 
            <div class='card'>
                <div class="col-lg-12">  
                    <label for="applicationform-dob">आपके के समूह के सदस्यों को वादा सखी की ज़रूरत के बारे में क्या राय रखते हैं ?</label>
                    <div class="form-group"><?= isset($model->think->name_hi) ? $model->think->name_hi : '' ?></div>

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