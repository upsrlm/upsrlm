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
        Section 3 : टेक्नॉलजी पारंगतता
    </h3>
</div>

<div class="card">

    <div class="col-lg-12">

        <div class='card-body'>
            <div class='card'>
                <div class="col-lg-12">  
                    <label for="applicationform-dob">आपके के पास कौन सा मोबाइल है</label>
                    <div class="form-group"><?= isset($model->mobiletype->name_hi) ? $model->mobiletype->name_hi : '' ?></div>

                </div>
            </div>
            <?php if ($model->phone_type == '1') { ?> 
                <div class='card'>
                    <div class="col-lg-12">  
                        <label for="applicationform-dob">अगर टच वाला मोबाइल है तो वो किसका है</label>
                        <div class="form-group"><?= isset($model->mobilewhose->name_hi) ? $model->mobilewhose->name_hi : '' ?></div>

                    </div>
                </div>

                <div class='card'>
                    <div class="col-lg-12">  
                        <label for="applicationform-dob">अगर टचवाला मोबाइल है तो आप मोबाइल का क्या क्या उपयोग कर लेती हैं?</label>
                        <div class="form-group"><?= isset($model->mobileusedhtml) ? $model->mobileusedhtml : '' ?></div>

                    </div>
                </div>
            <?php } ?> 
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