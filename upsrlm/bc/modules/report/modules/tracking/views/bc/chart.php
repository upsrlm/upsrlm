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

$this->title = 'Transaction performance report';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
$transaction = Yii::$app->params['txn'];
$txn_amn = '0';
$com_amn = Yii::$app->params['txn_com'];
$ext_txn_amn = Yii::$app->params['txn_amn'];
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <div class="clearfix pt-3"></div>

                    <?php
                    $form = ActiveForm::begin([
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'Searchform'
                                ],
                                'id' => 'Searchform',
                                'layout' => 'inline',
                                'method' => 'get',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_searchchart', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <div class="col-xl-12 mt-3">
                        <div class="row">
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-warning-700 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Total BC operational</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle(($transaction + $dataProvider->query->sum('no_of_transaction')));
                                            ?>
                                            <small class="m-0 l-h-n">Total no. of transaction</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa fa-volume-up position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo '<i class="fal fa-rupee-sign"></i> ' . common\helpers\Utility::numberIndiaStyle(($txn_amn + $ext_txn_amn + $dataProvider->query->sum('transaction_amount')));
                                            ?>
                                            <small class="m-0 l-h-n">Total transaction amount</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-rupee-sign fa-spin position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo '<i class="fal fa-rupee-sign"></i> ' . common\helpers\Utility::numberIndiaStyle(($com_amn + $dataProvider->query->sum('commission_amount')));
                                            ?>
                                            <small class="m-0 l-h-n">Total BC commission earned</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-rupee-sign fa-spin position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-danger-900 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            echo '<i class="fal fa-rupee-sign"></i> ' . common\helpers\Utility::numberIndiaStyle($dataProvider->query->select(['commission_amount'])->max('commission_amount'));
                                            ?>
                                            <small class="m-0 l-h-n">Highest commission earned by BC</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-dark', 'name' => 'button_type', 'value' => '4'])  ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-rupee-sign fa-spin position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                        </div>

                    </div>



                    <?php
//                    echo $this->render('_month', [
//                        'model' => $searchModel, 'form' => $form
//                    ]);
                    ?>
                    <!--                    <div class="col-xl-12 mb-3"></div>-->
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-lg-7">
                                <?php
                                $category1 = ArrayHelper::getColumn($report, 'month');
                                $bcData = ['name' => 'No. of BC operational', 'type' => 'column', 'yAxis' => 1, 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'no_of_bc'))))];
                                $comData = ['name' => 'Commistion Earned', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ' Rs'], 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'commission_amount'))))];
                                echo Highcharts::widget([
                                    'scripts' => [
                                        'highcharts-more',
                                        'modules/exporting',
                                        'modules/export-data',
                                        'themes/grid',
                                    ],
                                    'options' => [
                                        'chart' => [
                                            'zoomType' => 'xy',
                                        ],
                                        'exporting' => [
                                            'buttons' => [
                                                'contextButton' => [
                                                    'menuItems' => ['downloadPNG', 'downloadPDF', 'downloadCSV']
                                                ]
                                            ]
                                        ],
                                        'credits' => [
                                            'enabled' => false,
                                        ],
                                        'title' => [
                                            'text' => 'Monthly : No. BC operational V/S commission earned',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => $category1,
                                            'title' => [
                                                'text' => 'Month',
                                            ],
                                            'crosshair' => true,
                                        ],
                                        'yAxis' => [
                                            [
                                                'labels' => ['format' => '{value} Rs'],
                                                'title' => [
                                                    'text' => 'Commisstion Earned',
                                                ],
                                                'opposite' => true,
                                            ],
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => 'No. of BC operational',
                                                ]
                                            ],
                                        ],
                                        'tooltip' => [
                                            'shared' => true
                                        ],
                                        'legend' => [
                                            'layout' => 'vertical',
                                            'align' => 'left',
                                            'x' => 120,
                                            'verticalAlign' => 'top',
                                            'y' => 100,
                                            'floating' => true,
                                        ],
//                        'plotOptions' => [
//                            'column' => [
//                                'pointPadding' => 0.2,
//                                'borderWidth' => 0
//                            ],
//                        ],
                                        'series' => [$bcData, $comData]
                                    ],
                                ]);
                                ?>
                                <div class="clearfix mt-2"></div>
                                <?php
                                $category2 = ArrayHelper::getColumn($report, 'month');
                                $txnData = ['name' => 'No. of transaction', 'type' => 'column', 'yAxis' => 1, 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'no_of_transaction'))))];
                                $txnvData = ['name' => 'Transaction amount', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ' Rs'], 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'transaction_amount'))))];
                                echo Highcharts::widget([
                                    'scripts' => [
                                        'highcharts-more',
                                        'modules/exporting',
                                        'modules/export-data',
                                        'themes/grid',
                                    ],
                                    'options' => [
                                        'chart' => [
                                            'zoomType' => 'xy',
                                        ],
                                        'exporting' => [
                                            'buttons' => [
                                                'contextButton' => [
                                                    'menuItems' => ['downloadPNG', 'downloadPDF', 'downloadCSV']
                                                ]
                                            ]
                                        ],
                                        'credits' => [
                                            'enabled' => false,
                                        ],
                                        'title' => [
                                            'text' => 'Monthly : No. of transaction V/S transaction amount',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => ArrayHelper::getColumn($report, 'month'),
                                            'crosshair' => true,
                                            'title' => [
                                                'text' => 'Month',
                                            ],
                                        ],
                                        'yAxis' => [
                                            ['labels' => ['format' => '{value} Rs'],
                                                'title' => [
                                                    'text' => 'Transaction amount',
                                                ],
                                                'opposite' => true,
                                            ],
                                            ['labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => 'No. of transaction',
                                                ]],
                                        ],
                                        'tooltip' => [
                                            'shared' => true
                                        ],
                                        'legend' => [
                                            'layout' => 'vertical',
                                            'align' => 'left',
                                            'x' => 120,
                                            'verticalAlign' => 'top',
                                            'y' => 100,
                                            'floating' => true,
                                        ],
                                        'plotOptions' => [
                                            'column' => [
                                                'pointPadding' => 0.2,
                                                'borderWidth' => 0
                                            ],
                                        ],
                                        'series' => [$txnData, $txnvData]
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="col-lg-5">
                                <?php
                                echo Highcharts::widget([
                                    'scripts' => [
                                        'highcharts-more',
                                        'modules/exporting',
                                        'modules/export-data',
                                        'themes/grid',
                                    ],
                                    'options' => [
                                        'chart' => [
                                            'zoomType' => 'xy',
                                            'height' => 200
                                        ],
                                        'exporting' => [
                                            'buttons' => [
                                                'contextButton' => [
                                                    'menuItems' => ['downloadPNG', 'downloadPDF', 'downloadCSV']
                                                ]
                                            ]
                                        ],
                                        'credits' => [
                                            'enabled' => false,
                                        ],
                                        'title' => [
                                            'text' => 'BC operational',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => ArrayHelper::getColumn($report, 'month'),
                                            'crosshair' => true,
                                            'title' => [
                                                'text' => 'Month',
                                            ],
                                        ],
                                        'yAxis' => [
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => 'BC operational',
                                                ],
                                            ],
                                        ],
                                        'series' => [['name' => 'BC operational', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_map('floatval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'no_of_bc'))))]]
                                    ],
                                ]);
                                ?>
                                <?php
                                echo Highcharts::widget([
                                    'scripts' => [
                                        'highcharts-more',
                                        'modules/exporting',
                                        'modules/export-data',
                                        'themes/grid',
                                    ],
                                    'options' => [
                                        'chart' => [
                                            'zoomType' => 'xy',
                                            'height' => 200
                                        ],
                                        'exporting' => [
                                            'buttons' => [
                                                'contextButton' => [
                                                    'menuItems' => ['downloadPNG', 'downloadPDF', 'downloadCSV']
                                                ]
                                            ]
                                        ],
                                        'credits' => [
                                            'enabled' => false,
                                        ],
                                        'title' => [
                                            'text' => 'Avg No. of transaction per BC',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => ArrayHelper::getColumn($report, 'month'),
                                            'crosshair' => true,
                                            'title' => [
                                                'text' => 'Month',
                                            ],
                                        ],
                                        'yAxis' => [
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => 'Avg No. of transaction per BC',
                                                ],
                                            ],
                                        ],
                                        'series' => [['name' => 'Avg No. of transaction per BC', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_map('floatval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'avg_transaction_no'))))]]
                                    ],
                                ]);
                                ?>
                                <?php
                                echo Highcharts::widget([
                                    'scripts' => [
                                        'highcharts-more',
                                        'modules/exporting',
                                        'modules/export-data',
                                        'themes/grid',
                                    ],
                                    'options' => [
                                        'chart' => [
                                            'zoomType' => 'xy',
                                            'height' => 200
                                        ],
                                        'exporting' => [
                                            'buttons' => [
                                                'contextButton' => [
                                                    'menuItems' => ['downloadPNG', 'downloadPDF', 'downloadCSV']
                                                ]
                                            ]
                                        ],
                                        'credits' => [
                                            'enabled' => false,
                                        ],
                                        'title' => [
                                            'text' => 'Avg Transaction amount per BC',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => ArrayHelper::getColumn($report, 'month'),
                                            'crosshair' => true,
                                            'title' => [
                                                'text' => 'Month',
                                            ],
                                        ],
                                        'yAxis' => [
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => 'Avg Transaction amount per BC',
                                                ],
                                            ],
                                        ],
                                        'series' => [['name' => 'Avg Transaction amount per BC', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_map('floatval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'avg_txn_amount'))))]]
                                    ],
                                ]);
                                ?>
                                <?php
                                echo Highcharts::widget([
                                    'scripts' => [
                                        'highcharts-more',
                                        'modules/exporting',
                                        'modules/export-data',
                                        'themes/grid',
                                    ],
                                    'options' => [
                                        'chart' => [
                                            'zoomType' => 'xy',
                                            'height' => 200
                                        ],
                                        'exporting' => [
                                            'buttons' => [
                                                'contextButton' => [
                                                    'menuItems' => ['downloadPNG', 'downloadPDF', 'downloadCSV']
                                                ]
                                            ]
                                        ],
                                        'credits' => [
                                            'enabled' => false,
                                        ],
                                        'title' => [
                                            'text' => 'Avg commission earned per BC',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => ArrayHelper::getColumn($report, 'month'),
                                            'crosshair' => true,
                                            'title' => [
                                                'text' => 'Month',
                                            ],
                                        ],
                                        'yAxis' => [
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => 'Avg commission earned per BC',
                                                ],
                                            ],
                                        ],
                                        'series' => [['name' => 'Avg commission earned per BC', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_map('floatval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'avg_com_amount'))))]]
                                    ],
                                ]);
                                ?>
                            </div>

                        </div>
                    </div>  

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>    
    </div>


</div>
<?php
$script = <<< JS
    $('form select').on('change', function(){
    
    $("#Searchform").attr("data-pjax", "True");                
    $(this).closest('form').submit();
});            
    
JS;
$this->registerJs($script);
?>
<?php Pjax::end(); ?>