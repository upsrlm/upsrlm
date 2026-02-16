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

$this->title = 'Infographics';
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
<div class="row px-5 mb-5">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="clearfix pt-3"></div>
                    <div class="col-xl-12 mt-3">
                        <div class="row">
                            <div class="col-sm-6 col-xl-12">
                                <div class="section-heading titel-highest mb-4">
                                    <h2 ><em>  <?php
                                            echo '<i class="fal fa-rupee-sign"></i> ' . common\helpers\Utility::numberIndiaStyle(\common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummary::find()->select(['commission_amount'])->max('commission_amount'));
                                            ?></em>
                                        <small class="m-0 l-h-n">Highest commission earned by BC</small>
                                        <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-dark', 'name' => 'button_type', 'value' => '4'])  
                                        ?>
                                    </h2>
                                </div>
                            
                            </div>
                        </div>

                    </div>
                    <div class="row">
                            <div class="col-lg-12">
                                <?php
                                $category1 = ArrayHelper::getColumn($report, 'month');
                                //$bcData = ['name' => 'No. of BC operational', 'type' => 'column', 'yAxis' => 1, 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'no_of_bc'))))];
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
                                            'text' => 'Monthly :  commission earned',
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
                                        'series' => [$comData]
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
                                            //                                            'height' => 200
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