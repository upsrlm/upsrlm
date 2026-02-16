<?php

use bcsakhi\components\widget\home\GoWidget;
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
//common\assets\FioriSrlmAsset::register($this);
$this->title = 'Government Orders';
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
<div style="min-height: 730px">
    <div class="container-fluid px-lg-5 px-3">
        <div class="row">
            <div class="col-12">
                <div class="section-heading mb-5 pt-4">
                    <h2>Government Orders Issued in support of BC Sakhi Program in <em>Uttar Pradesh</em></h2>
                </div>
            </div>
        </div>
        <?= GoWidget::widget([]) ?>

    </div>

</div>