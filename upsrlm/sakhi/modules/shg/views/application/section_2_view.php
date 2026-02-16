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
        Section 2 : Mobility
    </h3>
</div>

<div class="card">

    <div class="col-lg-12">

        <div class='card-body'>
          <div class='card'>
                <div class="col-lg-12">  
                    <label for="applicationform-dob">साधारणत आवश्यकता होने पर, आप अपने ग्राम पंचायत के अंदर कैसे यातायात करती हैं?</label>
                    <div class="form-group"><?= isset($model->travelgphtml) ? $model->travelgphtml : '' ?></div>

                </div>
            </div> 
             <div class='card'>
                <div class="col-lg-12">  
                    <label for="applicationform-dob">आप किन वाहनों को चलाना जानती है</label>
                    <div class="form-group"><?= isset($model->vechiclehtml) ? $model->vechiclehtml : '' ?></div>

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