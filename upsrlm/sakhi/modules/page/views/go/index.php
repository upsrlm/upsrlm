<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = 'शासनादेश';
$this->params['icon'] = 'fa fa-book';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
<!--                <button type="button" class="btn btn-info btn-sm p-2" onClick="downloadPdf('https://mop-up.upsrlm.org/images/go/ultra_poor_GO-25-05-2025.pdf')"><i class="fal fa fa-download"></i> डाउनलोड </button>    -->
              
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div>
                        <img src="/images/go/go_1.jpg" style="width:100%" alt="शासनादेश"/>
<!--                        <a href="/images/go/ultra_poor_GO-25-05-2025.pdf" class="btn btn-success btn-block">प्रदेश के प्रत्येक ग्राम पंचायत से 10-25 निर्धनतम परिवारों के त्वरित गरीबी उन्मूलन हेतु कार्यक्रम विषयक</a>-->
                    <!--    <iframe src="/images/go/ultra_poor_GO-25-05-2025.pdf"  style="border: none;width:100%;height:800px">-->

                        <!--</iframe>-->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



