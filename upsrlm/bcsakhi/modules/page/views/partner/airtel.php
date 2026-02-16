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

$this->title = 'Airtel Payment Bank Limited';
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
        Airtel Payments Bank, the first payments bank to commence operations in Nov 2016, has enabled easy and simple access to banking services with the vision to touch “Every Mile, Every family, every Business” and contribute to the government of India’s vision of digital India and Financial inclusion. With its nation-wide presence, the bank has built robust banking network of 5 million banking points including over 40,000 in unbanked remote geographies, delivering seamless digital as well as feature phone banking. with a strong distribution network and easy, paper less services today the bank is serving more than 3 million people across the country to receive DBT in their bank account. The bank’s on-ground BC Sakhi network has also enabled doorstep services for women, elderly and specially-abled, to facilitate safe banking from home at this time across, in Indian States of Uttar Pradesh, Madhya Pradesh, Chhattisgarh, Bihar, Rajasthan, North East States, Telengana and Gujarat.
    </div>
</div>