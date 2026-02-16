<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use miloschuman\highcharts\Highcharts;
use common\assets\HighChartsAssets;

HighChartsAssets::register($this);
$this->title = "Weekly report";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-0" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    Pjax::begin([
                        'id' => 'grid-data',
                        'enablePushState' => FALSE,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                        'clientOptions' => ['method' => 'GET'],
                    ]);
                    ?>
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
                    echo $this->render('_searchweekgraph', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <div class="row mb-6"></div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div id="panel-2" class="panel">
                                <div class="panel-container show">
                                    <div class="panel-content">  
                                        <div id="change_day" style="height:500px"></div>     

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div id="panel-3" class="panel">
  
                                <div class="panel-container show">
                                    <div class="panel-content">   
                                        <div id="change_transaction" style="height:500px"></div> 

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div id="panel-4" class="panel">

                                <div class="panel-container show">
                                    <div class="panel-content">   
                                        <div id="change_transaction_amount" style="height:500px"></div> 

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div id="panel-5" class="panel">

                                <div class="panel-container show">
                                    <div class="panel-content">   
                                        <div id="change_commission_amount" style="height:500px"></div> 

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $(this).closest('form').submit();
});            
   
JS;
                    $this->registerJs($script);
                    ?>
                    <script>
                        var total_cf = <?php echo $graph['total'] ?: 0; ?>;
                        var change_day1 = <?php echo $graph['change_day1'] ?: 0; ?>;
                        var change_day2 = <?php echo $graph['change_day2'] ?: 0; ?>;
                        var change_day3 = <?php echo $graph['change_day3'] ?: 0; ?>;

                        var change_transaction1 = <?php echo $graph['change_transaction1'] ?: 0; ?>;
                        var change_transaction2 = <?php echo $graph['change_transaction2'] ?: 0; ?>;
                        var change_transaction3 = <?php echo $graph['change_transaction3'] ?: 0; ?>;
                        var change_transaction_amount1 = <?php echo $graph['change_transaction_amount1'] ?: 0; ?>;
                        var change_transaction_amount2 = <?php echo $graph['change_transaction_amount2'] ?: 0; ?>;
                        var change_transaction_amount3 = <?php echo $graph['change_transaction_amount3'] ?: 0; ?>;
                        var change_commission_amount1 = <?php echo $graph['change_commission_amount1'] ?: 0; ?>;
                        var change_commission_amount2 = <?php echo $graph['change_commission_amount2'] ?: 0; ?>;
                        var change_commission_amount3 = <?php echo $graph['change_commission_amount3'] ?: 0; ?>;

                       


                    </script>

                    <?php
                    $script = <<< JS
Highcharts.setOptions({
     //  colors: ['#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
       // colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A']//star rating 
        //colors: ['#3CB371', '#FF9933', '#00BFFF', '#FF0000', '#505050', '#1DC9B7', '#2196F3'],
    });                             
Highcharts.chart('change_day', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
        credits:{
 enabled:false,
},
    title: {
        useHTML: true,
        text: 'Working day'
    },
    tooltip: {
        useHTML: true,                    
        pointFormat: '{series.name}:<b>{point.name}</b>: {point.y:.0f}',
        style: {
                fontSize: '20px',
                fontFamily: 'Verdana, sans-serif'
            }
    },
         exporting: {
        buttons: {
          contextButton: {
            menuItems: ['downloadPNG',  'downloadPDF'],
          },
        },
   },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            showInLegend: true, 
            colors: [
     '#3CB371', 
     '#FF9933',
     '#00BFFF', 
   ],    
            dataLabels: {
                enabled: false,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
         style: {
                fontSize: '16px',
                fontFamily: 'Verdana, sans-serif'
            }
            }
        }
    },
    series: [{
        dataLabels: {
        enabled: false,
        useHTML: true,
      },                    
        name: 'Working day ',
        colorByPoint: true,
        data: [{
            
            name: 'Up',
            y: change_day1
        }, {
            name: 'Down',
            y: change_day2
        }, 
        {
            name: 'No Change',
            y: change_day3
        }, 
        
            ]
    }]
});
Highcharts.chart('change_transaction', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
        credits:{
 enabled:false,
},
    title: {
        useHTML: true,
        text: 'Transaction'
    },
    tooltip: {
        useHTML: true,                    
        pointFormat: '{series.name}:<b>{point.name}</b>: {point.y:.0f}',
        style: {
                fontSize: '20px',
                fontFamily: 'Verdana, sans-serif'
            }
    },
         exporting: {
        buttons: {
          contextButton: {
            menuItems: ['downloadPNG',  'downloadPDF'],
          },
        },
   },
   plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            showInLegend: true,
            colors: [
     '#3CB371', 
     '#FF9933',
     '#00BFFF', 
   ],    
            dataLabels: {
                enabled: false,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
         style: {
                fontSize: '16px',
                fontFamily: 'Verdana, sans-serif'
            }
            }
        }
    },
    series: [{
        dataLabels: {
        enabled: false,
        useHTML: true,
      },                    
        name: 'Transaction',
        colorByPoint: true,
        data: [{
            
            name: 'Up',
            y: change_transaction1
        }, {
            name: 'Down',
            y: change_transaction2
        }, 
        {
            name: 'No Change',
            y: change_transaction3
        }, 
        
            ]
    }]
});                            
Highcharts.chart('change_transaction_amount', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
        credits:{
 enabled:false,
},
    title: {
        useHTML: true,
        text: 'Txn Amount'
    },
    tooltip: {
        useHTML: true,                    
        pointFormat: '{series.name}:<b>{point.name}</b>: {point.y:.0f}',
        style: {
                fontSize: '20px',
                fontFamily: 'Verdana, sans-serif'
            }
    },
         exporting: {
        buttons: {
          contextButton: {
            menuItems: ['downloadPNG',  'downloadPDF'],
          },
        },
   },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            showInLegend: true, 
           colors: [
     '#3CB371', 
     '#FF9933',
     '#00BFFF', 
   ],         
            dataLabels: {
                enabled: false,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
         style: {
                fontSize: '16px',
                fontFamily: 'Verdana, sans-serif'
            }
            }
        }
    },
    series: [{
        dataLabels: {
        enabled: false,
        useHTML: true,
      },                    
        name: 'Txn Amount',
        colorByPoint: true,
        data: [{
            
            name: 'Up',
            y: change_transaction_amount1
        }, {
            name: 'Down',
            y: change_transaction_amount2
        }, 
        {
            name: 'No Change',
            y: change_transaction_amount3
        }, 
        
            ]
    }]
});  
Highcharts.chart('change_commission_amount', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
        credits:{
 enabled:false,
},
    title: {
        useHTML: true,
        text: 'Commission Amount'
    },
    tooltip: {
        useHTML: true,                    
        pointFormat: '{series.name}:<b>{point.name}</b>: {point.y:.0f}',
        style: {
                fontSize: '20px',
                fontFamily: 'Verdana, sans-serif'
            }
    },
         exporting: {
        buttons: {
          contextButton: {
            menuItems: ['downloadPNG',  'downloadPDF'],
          },
        },
   },
   plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            showInLegend: true, 
             colors: [
     '#3CB371', 
     '#FF9933',
     '#00BFFF', 
   ],       
            dataLabels: {
                enabled: false,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
         style: {
                fontSize: '16px',
                fontFamily: 'Verdana, sans-serif'
            }
            }
        }
    },
    series: [{
        dataLabels: {
        enabled: false,
        useHTML: true,
      },                    
        name: 'Commission Amount',
        colorByPoint: true,
        data: [{
            
            name: 'Up',
            y: change_commission_amount1
        }, {
            name: 'Down',
            y: change_commission_amount2
        }, 
        {
            name: 'No Change',
            y: change_commission_amount3
        }, 
        
            ]
    }]
});                            


JS;
                    $this->registerJs($script);
                    ?>  
                    <?php ActiveForm::end(); ?>
                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div> 
    </div>
</div>


<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
//    'options' => ['data-backdrop' => 'true',],
    'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
    ],
]);
echo "<div id='imagecontent'></div>";
Modal::end();
?>
