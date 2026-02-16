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
                    <?= 'Monthly BC Report' ?>
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
                    echo $this->render('_searchreport', [
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
                    print_r($searchModel->linechart("1"));
                    $script = <<< JS
                        $(function(){
                            function reportchart() {
                                const container= Highcharts.chart('chartcontainer', {
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: chart_type
                                        },
                                        colors:["#584475","#e70606"],
                                        title: {
                                            text: 'New BC Vs Droped BC'
                                        },

                                        subtitle: {
                                            text: ''
                                        },

                                        yAxis: {
                                            title: {
                                                text: 'Number of BCs'
                                            },
                                             labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            },
                                        },

                                        xAxis: {
                                            categories: month_category,
                                            reversed:true,
                                             labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            },
                                        },

                                        legend: {
                                            layout: 'horizontal',
                                            align: 'center',
                                            verticalAlign: 'bottom'
                                        },
                                        series: series_new_vs_droped,
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

                            function totalvsworkedchart() {
                                const container2= Highcharts.chart('totalvsworkedchartcontainer', {
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: chart_type
                                        },
                                        colors:["#4CAF50","#FF9800"],
                                        title: {
                                            text: 'Total BC Vs Total BC Worked',
                                        },

                                        subtitle: {
                                            text: ''
                                        },

                                        yAxis: {
                                            title: {
                                                text: 'Number of BCs'
                                            },
                                             labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            },
                                        },

                                        xAxis: {
                                            categories: month_category,
                                            reversed:true,
                                             labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            },
                                        },

                                        legend: {
                                           layout: 'horizontal',
                                            align: 'center',
                                            verticalAlign: 'bottom'
                                        },
                                        series: series_total_vs_worked,
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
                                        exporting: {buttons: {contextButton: {menuItems: ['downloadPNG', 'downloadPDF', 'downloadCSV'], }, }, },
                                        credits: false

                                    });	
                                }
                            function commissionchart() {
                                const containercommission= Highcharts.chart('commissionchartcontainer', {
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: chart_type
                                        },
                                        colors:["#e70606","#4CAF50","#FF9800","#2196F3","#37e2d0"],
                                        title: {
                                            text: 'Commission Earned',
                                        },

                                        subtitle: {
                                            text: ''
                                        },

                                        yAxis: {
                                            title: {
                                                text: 'Number of BCs'
                                            },
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            },
                                        },

                                        xAxis: {
                                            categories: month_category,
                                            reversed:true,   
                                            labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            },                                          
                                        },

                                        legend: {
                                           layout: 'horizontal',
                                            align: 'center',
                                            verticalAlign: 'bottom'
                                        },
                                        series: series_commission,
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

                            function dayschart() {
                                const containerdays= Highcharts.chart('dayschartcontainer', {
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: chart_type
                                        },
                                        colors:["#4CAF50","#FF9800","#2196F3","#37e2d0"], //"#e70606",
                                        title: {
                                            text: 'No of Days Worked',
                                        },

                                        subtitle: {
                                            text: ''
                                        },

                                        yAxis: {
                                            title: {
                                                text: '% of BCs '
                                            },
                                             labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            },
                                        },

                                        xAxis: {
                                            categories: month_category,
                                            reversed:true,
                                             labels: {
                                                style: {
                                                    fontSize: '15px'
                                                }
                                            },
                                        },

                                        legend: {
                                           layout: 'horizontal',
                                            align: 'center',
                                            verticalAlign: 'bottom'
                                        },
                                        series: series_days,
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
                            //totalvsworkedchart();
                            //commissionchart();
                            //dayschart();

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