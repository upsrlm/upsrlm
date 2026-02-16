<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use common\models\master\MasterRole;

$this->title = 'ग्रामीण विकास विभाग';
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

                    <p>
                        <img class="d-block w-100" src="<?= '/images/rd.png' ?>" alt="">

                    </p>   
                    <div>

                        <a href="<?= $section_form_url . '/rd-mgnrega' ?>" class="btn btn-info btn-block "><span>महात्मा गाँधी राष्ट्रीय ग्रामीण रोजगार गारंटी योजना</span> </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>