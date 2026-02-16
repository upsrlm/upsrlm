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

$this->title = 'आवेदन पत्र';
$app = new \sakhi\components\App();
?>

<?php
$section_form_url = '/shg/application/form-next?shgid=' . $model->shg_model->id;
?>

<div class="subheader" style="text-align: center">
    <h1 class="subheader-title">
        समूह सखी आवेदन पत्र
        <small>
            (Women's Agency for Development Amplification)
        </small>
    </h1>

</div>

<div class="subheader" style="text-align: center">

    <h1 class="subheader-title">
        डाइरेक्ट बेनेफ़िट ट्रान्स्फ़र (DBT) एवं टेक्नॉलजी के प्रोत्साहन के लिए मुख्य मानदंड
    </h1>
</div>

<div class="card">

    <div class="col-lg-12" style="padding: 20px;">
        <p>

        </p>
        <a href="<?= $section_form_url ?>" class="btn btn-warning btn-block "><span>Next</span> </a>

    </div>
</div>