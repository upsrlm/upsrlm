<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

\common\assets\HighChartsAssets::register($this);

?>
<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'Month Wise BC Report' ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?php
                    $form = ActiveForm::begin([
                        'options' => [
                            'class' => 'form-inline',
                            'data-pjax' => true,
                            'id' => 'search-form'
                        ],
                        'id' => 'search-form',
                        'layout' => 'inline',
                        'method' => 'get',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_searchreportmonth', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <?php ActiveForm::end(); ?>
                    <div class="clearfix pt-3"></div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div id="chartcontainer"></div>
                        </div>
                    </div>
                    <?php
                    print_r($searchModel->combochart());
                    $script = <<< JS
                        $(function(){
                            function reportchart() {
                                const container= Highcharts.chart('chartcontainer', {
                                        chart: {
                                            zoomType: 'xy'
                                        },
                                        colors:["#4CAF50","#FF9800","#2196F3","#37e2d0"],
                                        title: {
                                            text: ''
                                        },

                                        subtitle: {
                                            text: ''
                                        },

                                        yAxis: {
                                            title: {
                                                text: 'Number'
                                            }
                                        },

                                        xAxis: {
                                            title: {
                                                text: 'Number of Working Days'
                                            },
                                            categories: days_category,
                                            // reversed:true,
                                        },

                                        legend: {
                                            layout: 'horizontal',
                                            align: 'center',
                                            verticalAlign: 'bottom'
                                        },
                                        series: series_combination,
                                        responsive: {
                                            rules: [{
                                                condition: {
                                                    maxWidth: 500
                                                },
                                                chartOptions: {
                                                    legend: {
                                                        layout: 'horizontal',
                                                        align: 'center',
                                                        verticalAlign: 'bottom'
                                                    }
                                                }
                                            }]
                                        },
                                        // exporting: false,
                                        exporting: {buttons: {contextButton: {menuItems: ['downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadCSV', 'downloadXLS'], }, }, },
                                        credits: false

                                    });	
                                }

                            reportchart();

                        });
JS;
                    $this->registerJs($script);
                    ?>




                </div>
            </div>
        </div>
    </div>
</div>


<?php Pjax::end();
?>