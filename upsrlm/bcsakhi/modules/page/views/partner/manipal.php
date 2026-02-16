<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use common\models\User;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

$this->title = 'Manipal Technology Ltd.';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?= $this->title ?></h1>
            </div>
        </div>
    </div>
</div>
<div style="min-height: 500px">
    <div class="col-lg-12">  
      Manipal Technology Ltd is an organization with 80 Years of rich experience. Manipal provides leading technology, digital print and solution provider to all leading Public and Private Banks with turnover of 2 Billion USD. We provides services to the banks trough India largest Card Manufacturing Unit, India largest Commercial Print division and secure printing division for cheque book statement and hologram printing. We Also provide services for online examination for various government and universities. We work with all leading banks for financial inclusion in PAN India with 9000+ BC 24,000 villages.  
    </div>
</div>