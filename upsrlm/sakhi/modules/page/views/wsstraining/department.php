<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

//ग्रामीण विकास विभाग
$this->title = 'विभाग योजना का प्रशिक्षण';
$app = new \sakhi\components\App();
?>
<?php
$section_form_url = '/page/wsstraining';
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div>
                        <a href="<?= $section_form_url . '/bocw-labour' ?>" class="btn btn-warning btn-block "><span>BOCW भवन और अन्य निर्माण श्रमिक</span> </a>

                        <a href="<?= $section_form_url . '/rd' ?>" class="btn btn-success btn-block "><span>ग्रामीण विकास विभाग</span> </a>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>