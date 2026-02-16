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

$this->title = 'State Bank of India';
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
        State Bank of India (SBI) a Fortune 500 company, is an Indian Multinational, Public Sector Banking and Financial services statutory body headquartered in Mumbai. The rich heritage and legacy of over 200 years, accredits SBI as the most trusted Bank by Indians through generations. SBI, the largest Indian Bank with 1/4th market share, serves over 48 crore customers through its vast network of over 22,405 branches, 65,627 ATMs/ ADWMs, 76,089 BC outlets, with an undeterred focus on innovation, and customer centricity, which stems from the core values of the Bank - Service, Transparency, Ethics, Politeness and Sustainability. The Bank has successfully diversified businesses through its various subsidiaries i.e. SBI General Insurance, SBI Life Insurance, SBI Mutual Fund, SBI Card, etc. It has spread its presence globally and operates across time zones through 235 offices in 29 foreign countries. Growing with times, SBI continues to redefine
    </div>
</div>