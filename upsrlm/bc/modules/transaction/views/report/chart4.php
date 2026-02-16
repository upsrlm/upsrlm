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
//echo "<pre>";
//print_r(array_values($report['category']));exit;
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

                    <div class="col-xl-12">
                        <div class="row">

                            <div class="col-lg-12">
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
                                            'height' => 430
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
                                        'tooltip' => [
                                            'shared' => true,
                                            'crosshairs' => true,
                                        ],
                                        'xAxis' => [
                                            'categories' => array_values($report['category']),
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
                                        'series' => [
                                            ['name' => 'Over All BC operational', 'color' => '#058DC7', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['overall_no_of_bc'])],
                                            ['name' => 'BoB BC operational', 'color' => '#50B432', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['1_no_of_bc'])],
                                            ['name' => 'FINO BC operational', 'color' => '#ED561B', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['2_no_of_bc'])],
                                            ['name' => 'Nearby BC operational', 'color' => '#DDDF00', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['3_no_of_bc'])],
                                            ['name' => 'Manipal BC operational', 'color' => '#24CBE5', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['4_no_of_bc'])],
                                            ['name' => 'Airtel BC operational', 'color' => '#64E572', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['5_no_of_bc'])],
                                            ['name' => 'SBI BC operational', 'color' => '#FF9655', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['7_no_of_bc'])],
                                        ]
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
                                            'height' => 430
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
                                        'tooltip' => [
                                            'shared' => true,
                                            'crosshairs' => true,
                                        ],
                                        'xAxis' => [
                                            'categories' => array_values($report['category']),
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
                                        'series' => [
                                            ['name' => 'Over All Avg No. of transaction per BC', 'color' => '#058DC7', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['overall_avg_transaction_no'])],
                                            ['name' => 'BoB Avg No. of transaction per BC', 'color' => '#50B432', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['1_avg_transaction_no'])],
                                            ['name' => 'FINO Avg No. of transaction per BC', 'color' => '#ED561B', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['2_avg_transaction_no'])],
                                            ['name' => 'Nearby Avg No. of transaction per BC', 'color' => '#DDDF00', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['3_avg_transaction_no'])],
                                            ['name' => 'Manipal Avg No. of transaction per BC', 'color' => '#24CBE5', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['4_avg_transaction_no'])],
                                            ['name' => 'Airtel Avg No. of transaction per BC', 'color' => '#64E572', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['5_avg_transaction_no'])],
                                            ['name' => 'SBI Avg No. of transaction per BC', 'color' => '#FF9655', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['7_avg_transaction_no'])],
                                        ]
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
                                            'height' => 430
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
                                        'tooltip' => [
                                            'shared' => true,
                                            'crosshairs' => true,
                                        ],
                                        'xAxis' => [
                                            'categories' => array_values($report['category']),
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
                                        'series' => [
                                            ['name' => 'Over All Avg Transaction amount per BC', 'color' => '#058DC7', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['overall_avg_txn_amount'])],
                                            ['name' => 'BoB Avg Transaction amount per BC', 'color' => '#50B432', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['1_avg_txn_amount'])],
                                            ['name' => 'FINO Avg Transaction amount per BC', 'color' => '#ED561B', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['2_avg_txn_amount'])],
                                            ['name' => 'Nearby Avg Transaction amount per BC', 'color' => '#DDDF00', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['3_avg_txn_amount'])],
                                            ['name' => 'Manipal Avg Transaction amount per BC', 'color' => '#24CBE5', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['4_avg_txn_amount'])],
                                            ['name' => 'Airtel Avg Transaction amount per BC', 'color' => '#64E572', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['5_avg_txn_amount'])],
                                            ['name' => 'SBI Avg Transaction amount per BC', 'color' => '#FF9655', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['7_avg_txn_amount'])],
                                            ]
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
                                            'height' => 430
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
                                        'tooltip' => [
                                            'shared' => true,
                                            'crosshairs' => true,
                                        ],
                                        'xAxis' => [
                                            'categories' => array_values($report['category']),
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
                                        'series' => [
                                            ['name' => 'Over All Avg commission earned per BC', 'color' => '#058DC7', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['overall_avg_com_amount'])],
                                            ['name' => 'BoB Avg commission earned per BC', 'color' => '#50B432', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['1_avg_com_amount'])],
                                            ['name' => 'FINO Avg commission earned per BC', 'color' => '#ED561B', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['2_avg_com_amount'])],
                                            ['name' => 'Nearby Avg commission earned per BC', 'color' => '#DDDF00', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['3_avg_com_amount'])],
                                            ['name' => 'Manipal Avg commission earned per BC', 'color' => '#24CBE5', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['4_avg_com_amount'])],
                                            ['name' => 'Airtel Avg commission earned per BC', 'color' => '#64E572', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['5_avg_com_amount'])],
                                            ['name' => 'SBI Avg commission earned per BC', 'color' => '#FF9655', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ''], 'data' => array_values($report['7_avg_com_amount'])],
                                        ]
                                    ],
                                ]);
                                ?>
                            </div>

                        </div>
                    </div>  

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