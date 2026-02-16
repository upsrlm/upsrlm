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

$this->title = 'Pay Nearby';
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
     Nearby endeavours to empower local retail stores through our Distribution-as-a-Service (DaaS) network, enabling them to provide digital and financial services to the citizens of Bharat. It’s mission is to make financial & digital services available to everyone, everywhere. Through tech-led DaaS network, Nearby is serving 75% of India; it facilitates various services including cash withdrawal, bank account opening, money transfer, recharge, assurance (insurance + assets), credit, and e-commerce. With over 12 lakh micro-entrepreneurs across 22,000 PIN codes serving 50+ crore customers across the country to the tune of more than ~ INR 8000/- crores Gross Transaction Value (GTV) per month.   
    </div>
</div>