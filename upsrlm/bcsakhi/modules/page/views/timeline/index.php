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

$this->title = 'Thematic milestone : 1.0';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- <div class="brand_color">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2><?= $this->title ?></h2>
                </div>
            </div>
        </div>
    </div>

</div> -->
<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?= $this->title ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="row py-3">
    <div class="col-lg-12">
        <?= bcsakhi\components\widget\timeline\TimelineWidget::widget() ?>
    </div>
</div>