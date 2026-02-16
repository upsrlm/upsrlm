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
<script type="text/javascript">
    var date = <?= isset($model->dob) ? strtotime($model->dob) . '000' : 0 ?>;
    var mindate = <?= strtotime('1960-01-01') . '000' ?>;
    var maxdate = <?= strtotime('2004-01-01') . '000' ?>;
</script>
<?php
$section_1_class = '';
$section_2_class = '';
$section_3_class = '';
$section_4_class = '';
$section_5_class = '';
$section_6_class = '';
$section_1_url = '/test/application/form-section?shgid=' . $model->shg_model->id . '&section=1';
$section_2_url = '/test/application/form-section?shgid=' . $model->shg_model->id . '&section=2';
$section_3_url = '/test/application/form-section?shgid=' . $model->shg_model->id . '&section=3';
$section_4_url = '/test/application/form-section?shgid=' . $model->shg_model->id . '&section=4';
$section_5_url = '/test/application/form-section?shgid=' . $model->shg_model->id . '&section=5';
$section_6_url = '/test/application/form-section?shgid=' . $model->shg_model->id . '&section=6';

$section_confirm_url = '/test/application/view?shgid=' . $model->shg_model->id;
if ($model->application_model == null) {
    $section_2_class = 'disabled';
    $section_3_class = 'disabled';
    $section_4_class = 'disabled';
    $section_5_class = 'disabled';
    $section_6_class = 'disabled';
} else {
    if ($model->application_model->form_number == null) {
        $section_2_class = 'disabled';
        $section_3_class = 'disabled';
        $section_4_class = 'disabled';
        $section_5_class = 'disabled';
        $section_6_class = 'disabled';
    } elseif ($model->application_model->form_number == 1) {
        $section_1_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_3_class = 'disabled';
        $section_4_class = 'disabled';
        $section_5_class = 'disabled';
        $section_6_class = 'disabled';
    } elseif ($model->application_model->form_number == 2) {
        $section_1_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_2_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_4_class = 'disabled';
        $section_5_class = 'disabled';
        $section_6_class = 'disabled';
    } elseif ($model->application_model->form_number == 3) {
        $section_1_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_2_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_3_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_5_class = 'disabled';
        $section_6_class = 'disabled';
    } elseif ($model->application_model->form_number == 4) {
        $section_1_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_2_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_3_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_4_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_6_class = 'disabled';
    } elseif ($model->application_model->form_number == 5) {
        $section_1_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_2_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_3_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_4_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_5_url = '/test/application/view?shgid=' . $model->shg_model->id;
    } elseif ($model->application_model->form_number == 6) {
        $section_1_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_2_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_3_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_4_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_5_url = '/test/application/view?shgid=' . $model->shg_model->id;
        $section_6_url = '/test/application/view?shgid=' . $model->shg_model->id;
    }
}
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
        डाइरेक्ट बेनेफ़िट ट्रान्स्फ़र (DBT) एवं टेक्नॉलजी के प्रोत्साहन के लिए
    </h1>
</div>

<div class="card">

    <div class="col-lg-12" style="padding: 20px;">

        <a href="<?= $section_1_url ?>" class="btn btn-warning btn-block <?= $section_1_class ?>"><span>Section 1<br />बेसिक सूचना</span> </a>
        <a href="<?= $section_2_url ?>" class="btn btn-warning btn-block <?= $section_2_class ?>"><span>Section 2<br />Mobility</span> </a>
        <a href="<?= $section_3_url ?>" class="btn btn-warning btn-block <?= $section_3_class ?>"><span>Section 3<br />टेक्नॉलजी पारंगतता</span> </a>
        <a href="<?= $section_4_url ?>" class="btn btn-warning btn-block <?= $section_4_class ?>"><span>Section 4<br />नेतृत्व</span> </a>
        <a href="<?= $section_5_url ?>" class="btn btn-warning btn-block <?= $section_5_class ?>"><span>Section 5<br />मल्टी-सेक्टर सेवाओं के बारे में जानकारी</span> </a>
        <a href="<?= $section_6_url ?>" class="btn btn-warning btn-block <?= $section_6_class ?>"><span>Section 6</span> </a>
    </div>
</div>