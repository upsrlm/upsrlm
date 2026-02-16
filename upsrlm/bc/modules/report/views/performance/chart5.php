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

$this->title = 'Performance Matrix';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = 'Ave. Commission per Month';
$class = 'col-lg-12 mt-2';
$max = 1800;
?>
<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
if ($searchModel->master_partner_bank_id) {
    $class = 'col-lg-12 mt-2';
    $max = 1000;
}
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ." : ".'Ave. Commission per Month' ?>
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
                                // $category5 = ArrayHelper::getColumn($report, 'district_name');
                                $opData5 = ['showInLegend'=>false,'name' => 'Ave. Commission per Month', 'data' => $report1['avg_commission_amount_rateing']];
                                echo Highcharts::widget([
                                    'scripts' => [
                                        'highcharts-more',
                                        'modules/exporting',
                                        'modules/export-data',
                                        'themes/grid',
                                    ],
                                    'options' => [
                                        'chart' => [
                                            'type' => 'bar',
                                            'height' => $max,
                                            'marginRight' => 30
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
                                            'text' => 'Ave. Commission per Month<br/><small style="font-size:20px">Based on the Last 3 Months</small>',
                                            'style'=>[
                                              'fontWeight'=>'bold',  
                                              'font'=>'30px Arial, sans-serif',  
                                            ],
                                            'y'=> 30,
                                        ],
                                        'subtitle' => [
                                            'text' => "0: Rs 0 Earn<br/>
                                    1: Rs 1-500<br/>
                                    2: Rs 501-2000<br/>
                                    3: Rs 2001-5000<br/>
                                    4: Rs 5000 Above ",
                                            'align' => 'left',
                                            'x'=>60,
                                            'style'=>[
                                              'fontWeight'=>'bold',  
                                              'font'=>'12px Arial, sans-serif',  
                                            ],
                                        ],
                                        'xAxis' => [
                                            'categories' => $report1['category'],
                                            'gridLineWidth' => 1,
                                            'lineWidth' => 0
                                        ],
                                        'yAxis' => [
                                            'opposite' => true,
                                            'tickInterval' => 1,
                                           'title' => [
                                                'text' => '',
                                            ],
                                            'min' => 0,
                                                'max' => 4,
                                        ],
                                        'tooltip' => [
                                            'shared' => true
                                        ],
//                                        'legend' => [
//                                            'layout' => 'vertical',
//                                            'align' => 'top',
//                                            'x' => 120,
//                                            'verticalAlign' => 'top',
//                                            'y' => 100,
//                                            'floating' => true,
//                                        ],
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
  
