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

$this->title = 'Bank of Baroda';
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
        Bank of Baroda (BOB or BoB) is an Indian Multinational public sector bank headquartered in Vadodara, Gujarat. It is the second largest public sector bank in India after State Bank of India, with 153 million customers, a total business of US$218 billion, and a global presence of 100 overseas offices. Based on 2023 data, it is ranked 586 on the Forbes Global 2000 list. The Maharaja of Baroda, Sayajirao Gaekwad III, founded the bank on 20 July 1908 in the princely state of Baroda, in Gujarat. The Government of India nationalized the Bank of Baroda, along with 13 other major commercial banks of India, on 19 July 1969 and the bank was designated as a profit-making public sector undertaking (PSU).
    </div>
</div>