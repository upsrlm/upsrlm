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

$this->title = 'FINO Payment Bank';
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
    With 16.95 Lakhs distribution points offering quality banking services across 97% of India’s PIN CODE, FINO Payments Bank is truly India’s local national bank. The preferred banking option for over a crores hard working Indian’s, FINO now digitizes 24 Lakh of cash every minute, thus giving a boost to India’s digital payment push. At 1.23% of India’s ever expanding UPI ecosystem FINO is ringing in adoption of digital banking with its #FikarNot brand of #HardinFino banking services FINO Payments Bank is India’s only listed Payments Bank and invested into the consumer’s life by offering access to quality banking service, seamlessly- physically and digitally.    
    </div>
</div>