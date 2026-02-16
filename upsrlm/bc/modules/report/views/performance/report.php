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

$this->title = 'Performance report';
$this->params['breadcrumbs'][] = $this->title;
$class = 'col-lg-12 mt-4';
?>
<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
if ($searchModel->master_partner_bank_id) {
    $class = 'col-lg-6 mt-2';
}
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
                    echo $this->render('_search', [
                        'model' => $searchModel
                    ]);
                    ?>
                    <div class="clearfix pt-3"></div>
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="<?= $class ?>">
                                <?php
                                $category1 = ArrayHelper::getColumn($report, 'district_name');
                                $opData = ['name' => 'Certified', 'type' => 'column', 'yAxis' => 1, 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'certified_percentage'))))];

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
                                            'text' => '% of Certified BC Sakhis against total no. of GPs (RSETI-performance)',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => $category1,
                                            'title' => [
                                                'text' => 'District',
                                            ],
                                            'crosshair' => true,
                                        ],
                                        'yAxis' => [
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => 'Cetified percentage',
                                                ],
                                                'opposite' => false,
                                            ],
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => '',
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
                                        'series' => [$opData]
                                    ],
                                ]);
                                ?>

                            </div>

                            <div class="<?= $class ?>">
                                <?php
                                $category2 = ArrayHelper::getColumn($report, 'district_name');
                                $opData2 = ['name' => 'Operational percentage', 'type' => 'column', 'yAxis' => 1, 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'operational_percentage'))))];

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
                                            'text' => '% of operational BC Sakhis against total no. of GPs/ Certified BC Sakhis (Partner Bank-performance)',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => $category2,
                                            'title' => [
                                                'text' => 'District',
                                            ],
                                            'crosshair' => true,
                                        ],
                                        'yAxis' => [
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => 'Operational percentage',
                                                ],
                                                'opposite' => false,
                                            ],
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => '',
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
                                        'series' => [$opData2]
                                    ],
                                ]);
                                ?>

                            </div> 

                            <div class="<?= $class ?>">
                                <?php
                                $category3 = ArrayHelper::getColumn($report, 'district_name');
                                $opData3 = ['name' => 'Avg working day percentage', 'type' => 'column', 'yAxis' => 1, 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'avg_working_day_percentage'))))];

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
                                            'text' => 'Ave. no. of Working days/ Month/ BC Sakhie',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => $category3,
                                            'title' => [
                                                'text' => 'District',
                                            ],
                                            'crosshair' => true,
                                        ],
                                        'yAxis' => [
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => 'Avg working day percentage',
                                                ],
                                                'opposite' => false,
                                            ],
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => '',
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
                                        'series' => [$opData3]
                                    ],
                                ]);
                                ?>

                            </div>
                            <div class="<?= $class ?>">
                                <?php
                                $category4 = ArrayHelper::getColumn($report, 'district_name');
                                $opData4 = ['name' => 'Avg transcation rating', 'type' => 'column', 'yAxis' => 1, 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'avg_transcation_rating'))))];

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
                                            'text' => 'Ave. no. of Txn./ Month/ BC Sakhi',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => $category4,
                                            'title' => [
                                                'text' => 'District',
                                            ],
                                            'crosshair' => true,
                                        ],
                                        'yAxis' => [
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => 'Avg transcation rating',
                                                ],
                                                'opposite' => false,
                                            ],
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => '',
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
                                        'series' => [$opData4]
                                    ],
                                ]);
                                ?>

                            </div>      
                            <div class="<?= $class ?>">
                                <?php
                                $category5 = ArrayHelper::getColumn($report, 'district_name');
                                $opData5 = ['name' => 'Avg commission amount rateing', 'type' => 'column', 'yAxis' => 1, 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'avg_commission_amount_rateing'))))];

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
                                            'text' => 'Ave. Commission earning per month/ BC Sakhi',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => $category5,
                                            'title' => [
                                                'text' => 'District',
                                            ],
                                            'crosshair' => true,
                                        ],
                                        'yAxis' => [
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => 'Avg commission amount rateing',
                                                ],
                                                'opposite' => false,
                                            ],
                                            [
                                                'labels' => ['format' => '{value}'],
                                                'title' => [
                                                    'text' => '',
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
                                        'series' => [$opData5]
                                    ],
                                ]);
                                ?>

                            </div>  

                            <div class="<?= $class ?>">
                                <?php
                                $category5 = ArrayHelper::getColumn($report, 'district_name');
                                $opData5 = ['name' => 'Avg commission amount rateing', 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'avg_commission_amount_rateing'))))];

                                echo Highcharts::widget([
                                    'scripts' => [
                                        'highcharts-more',
                                        'modules/exporting',
                                        'modules/export-data',
                                        'themes/grid',
                                    ],
                                    'options' => [
                                        'chart' => [
                                            'type'=>'bar',
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
                                            'text' => 'Avg commission amount rateing',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => $category5,
                                            'gridLineWidth' => 1,
                                            'lineWidth' => 0
                                        ],
                                        'yAxis' => [
                                            'opposite' => true,
                                            'tickPixelInterval' => 150,
                                            'title' => [
                                                'text' => '',
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
                                        'series' => [$opData5]
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
  