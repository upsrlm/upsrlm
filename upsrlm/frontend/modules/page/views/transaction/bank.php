<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\Utility;
use common\models\master\MasterRole;
use bc\models\transaction\BcTransactionOverallPartnerBank;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Transaction performance report";
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                  <?php if(isset(Yii::$app->user->identity->role) and Yii::$app->user->identity->role==MasterRole::ROLE_ADMIN){ ?>
                    <button id="exportBtn1" class="btn  btn-info float-right"> <i class="fal fa-file-excel" style="color: red"> </i> Export To Excel</button><br><br>
                  <?php } ?>
                    <div class="clearfix"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed', 'id' => 'report'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
//                        'beforeHeader' => [
//                            [
//                                'columns' => [
//                                    ['content' => '', 'options' => ['colspan' => 10, 'class' => 'text-center warning']],
//                                    ['content' => 'Planning for ' . date('M'), 'options' => ['colspan' => 4, 'class' => 'text-center bg-white']],
//                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center warning']],
//                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center warning']],
//                                ],
//                            ]
//                        ],
                        'afterHeader' => [
                            [
                                'columns' => [
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center bg-warning-100']],
                                    ['content' => 'Total', 'options' => ['colspan' => 1, 'class' => 'text-center bg-warning-100']],
                                    ['content' => Utility::numberIndiaStyle(BcTransactionOverallPartnerBank::getTotal($dataProvider->models, 'no_of_district')), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => Utility::numberIndiaStyle(BcTransactionOverallPartnerBank::getTotal($dataProvider->models, 'no_of_gp')), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => Utility::numberIndiaStyle(BcTransactionOverallPartnerBank::getTotal($dataProvider->models, 'bc_operational')), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => '<span class="text-danger">' . round(BcTransactionOverallPartnerBank::getTotal($dataProvider->models, 'bc_operational') * 100 / BcTransactionOverallPartnerBank::getTotal($dataProvider->models, 'no_of_gp'), 1) . ' %' . '</span>', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => Utility::numberIndiaStyle(BcTransactionOverallPartnerBank::getTotal($dataProvider->models, 'no_of_transaction_map')), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => Utility::numberIndiaStyle(BcTransactionOverallPartnerBank::getTotal($dataProvider->models, 'transaction_amount_map')), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => Utility::numberIndiaStyle(BcTransactionOverallPartnerBank::getTotal($dataProvider->models, 'commission_amount_map')), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => Utility::numberIndiaStyle(BcTransactionOverallPartnerBank::getTotal($dataProvider->models, 'avg_bc_commission_amount') / 6), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => Utility::numberIndiaStyle((BcTransactionOverallPartnerBank::getTotal($dataProvider->models, 'avg_bc_commission_amount') / 6) / BcTransactionOverallPartnerBank::getNomonth($dataProvider->models, 'avg_bc_commission_amount')), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                ],
                            ]
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%', 'class' => 'text-center']],
                            [
                                'attribute' => 'entity',
                                'label' => 'Entity',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bank_short_name;
                                }
                            ],
                            [
                                'attribute' => 'no_of_district',
                                'label' => 'Total district',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->no_of_district) ? Utility::numberIndiaStyle($model->no_of_district) : '';
                                },
                            ],
                            [
                                'attribute' => 'no_of_gp',
                                'label' => "Total GP’s",
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->no_of_gp) ? Utility::numberIndiaStyle($model->no_of_gp) : '';
                                },
                            ],
                            [
                                'attribute' => 'BCs Operational',
                                'label' => 'BCs Operational ',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return Utility::numberIndiaStyle($model->bc_operational);
                                },
                            ],
                            [
                                'attribute' => 'Percentage',
                                'label' => 'Percentage',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'contentOptions' => ['class' => 'text-danger'],
                                'value' => function ($model) {
                                    return round(($model->bc_operational * 100) / $model->no_of_gp, 1) . ' %';
                                },
                            ],
                            [
                                'attribute' => 'Txn, Volumn',
                                'label' => 'Txn, Volumn',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return Utility::numberIndiaStyle($model->no_of_transaction_map);
                                },
                            ],
                            [
                                'attribute' => 'Txn value',
                                'label' => 'Txn value',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return Utility::numberIndiaStyle(floor($model->transaction_amount_map));
                                },
                            ],
                            [
                                'attribute' => 'BC commission',
                                'label' => 'BC commission',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return Utility::numberIndiaStyle(floor($model->commission_amount_map));
                                },
                            ],
                            [
                                'attribute' => 'Avg. commission  BC ',
                                'label' => 'Avg. commission  BC ',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return Utility::numberIndiaStyle(floor($model->avg_bc_commission_amount));
                                },
                            ],
                            [
                                'attribute' => 'Avg. commission/BC /Month',
                                'label' => 'Avg. commission/BC /Month',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return Utility::numberIndiaStyle(floor($model->avg_bc_commission_amount / $model->month));
                                },
                            ],
                        ],
                    ]);
                    ?>
                    <?php
                    $script = <<< JS
          $(document).ready(function () {
      $("#exportBtn1").click(function(){
        TableToExcel.convert(document.getElementById("report"), {
            name: "transaction_performance_report.xlsx",
            sheet: {
            name: "Sheet1"
            }})
          });
        });                     
JS;
                    $this->registerJs($script);
                    ?>

                </div>
            </div>
        </div> 
    </div>
</div>
