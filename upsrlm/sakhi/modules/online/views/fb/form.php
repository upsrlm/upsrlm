<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select3\Select3;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = 'हाई स्पीड इंटरनेट परियोजना';
$app = new \sakhi\components\App();
?>
<?php
$section_1_class = 'btn-lg';
$section_2_class = 'btn-lg disabled';
$section_3_class = 'btn-lg disabled';
$section_4_class = 'btn-lg disabled';
$section_5_class = 'btn-lg disabled';
$section_6_class = 'btn-lg disabled';
$section_7_class = 'btn-lg disabled';
$section_1_url = '/online/fb/section-view?section=1';
$section_2_url = '/online/fb/section-view?section=2';
$section_3_url = '/online/fb/section-view?section=3';
$section_4_url = '/online/fb/section-view?section=4';
$section_5_url = '/online/fb/section-view?section=5';
$section_6_url = '/online/fb/section-view?section=6';
$section_7_url = '/online/fb/section-view?section=7';
$section_confirm_url = '/online/fb/view';
if (!isset($model->fb_demand_side_model->id)) {
    $section_2_class = 'btn-lg disabled';
    $section_3_class = 'btn-lg disabled';
    $section_4_class = 'btn-lg disabled';
    $section_5_class = 'btn-lg disabled';
    $section_6_class = 'btn-lg disabled';
    $section_7_class = 'btn-lg disabled';
} else {
    if ($model->fb_demand_side_model->fd_section1 == '10c5') {
        $section_2_class = 'btn-lg';
    }
    if ($model->fb_demand_side_model->fd_section2 == '204') {
        $section_3_class = 'btn-lg';
    }
    if ($model->fb_demand_side_model->fd_section3 == '306') {
        $section_4_class = 'btn-lg';
    }
    if ($model->fb_demand_side_model->fd_section4 == '404') {
        $section_5_class = 'btn-lg';
    }
    if ($model->fb_demand_side_model->fd_section5 == '505') {
        $section_6_class = 'btn-lg';
    }
    if ($model->fb_demand_side_model->fd_section6 == '605') {
        $section_7_class = 'btn-lg';
    }
}
?>

<div class="subheader" style="text-align: center">
    <h2 class="subheader-title">
        हाई स्पीड इंटरनेट परियोजना

    </h2>

</div>

<div class="subheader" style="text-align: center">

    <h2 class="subheader-title">
        प्रूफ ऑफ़ कॉन्सेप्ट (राउंड 2) की प्रगति तथा सभी पायलट ग्राम पंचायतों में मॉडल सिस्टम का बेंचमार्क स्थिति का निर्धारण
    </h2>

</div>

<div class="card">

    <div class="col-lg-12" style="padding: 5px;">
        <a href="<?= $section_1_url ?>" class="btn btn-warning btn-block <?= $section_1_class ?>"><span>यूजर का विवरण</span>  </a>
        <a href="<?= $section_2_url ?>" class="btn btn-info btn-block <?= $section_2_class ?>"><span>ई-शिक्षा</span>  </a>
        <a href="<?= $section_3_url ?>" class="btn btn-primary btn-block <?= $section_3_class ?>"><span>ई-स्वास्थ्य</span>  </a>
        <a href="<?= $section_4_url ?>" class="btn btn-secondary btn-block <?= $section_4_class ?>"><span>ई-कृषि</span>  </a>
        <a href="<?= $section_5_url ?>" class="btn btn-success btn-block <?= $section_5_class ?>"><span>ई वित्त</span>  </a>
        <a href="<?= $section_6_url ?>" class="btn btn-dark btn-block <?= $section_6_class ?>"><span>ई-सरकारी सेवाएं</span>  </a>
        <a href="<?= $section_7_url ?>" class="btn btn-danger btn-block <?= $section_7_class ?>"><span>ओटीटी और मनोरंजन</span> </a>
    </div>
</div>