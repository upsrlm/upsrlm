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
$this->title = "Report Corona";
$this->params['breadcrumbs'][] = $this->title;
?>
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
                    echo $this->render('_search', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <div class="row mb-3"></div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div id="panel-2" class="panel">
                                <div class="panel-hdr">
                                    <h2>
                                        <?= 'क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है ?' ?>
                                    </h2>

                                </div>
                                <div class="panel-container show">
                                    <div class="panel-content">   
                                        <div id="container1" style="height:500px"></div>     

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div id="panel-3" class="panel">
                                <div class="panel-hdr">
                                    <h2>
                                        <?= 'क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है ?' ?>
                                    </h2>

                                </div>
                                <div class="panel-container show">
                                    <div class="panel-content">   
                                        <div id="container2" style="height:500px"></div> 

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3"></div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div id="panel-4" class="panel">
                                <div class="panel-hdr">
                                    <h2>
                                        <?= 'क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है ?' ?>
                                    </h2>

                                </div>
                                <div class="panel-container show">
                                    <div class="panel-content">   
                                        <div id="container3" style="height:500px"></div>     

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div id="panel-5" class="panel">
                                <div class="panel-hdr">
                                    <h2>
                                        <?= 'क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है ?' ?>
                                    </h2>

                                </div>
                                <div class="panel-container show">
                                    <div class="panel-content">   
                                        <div id="container4" style="height:500px"></div> 

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3"></div>                  
                    <div class="row">
                        <div class="col-xl-6">
                            <div id="panel-6" class="panel">
                                <div class="panel-hdr">
                                    <h2>
                                        <?= 'पिछले एक दो महीने में गाँव/ ग्रा०प० में कितने लोगों की मृत्यु हुई है ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>
                                    </h2>

                                </div>
                                <div class="panel-container show">
                                    <div class="panel-content">   
                                        <div id="container5" style="height:500px"></div>     

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div id="panel-7" class="panel">
                                <div class="panel-hdr">
                                    <h2>
                                        <?= 'पिछले एक दो महीने में गाँव/ ग्रा०प० में कितने लोगों की मृत्यु हुई है ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>
                                    </h2>

                                </div>
                                <div class="panel-container show">
                                    <div class="panel-content">   
                                        <div id="container6" style="height:500px"></div> 

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3"></div>                  
                    <div class="row">
                        <div class="col-xl-6">
                            <div id="panel-6" class="panel">
                                <div class="panel-hdr">
                                    <h2>
                                        <?= 'पिछले कुछ दिनों में गाँव में इस तरह के बीमारियों की गम्भीरता कैसी है ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>
                                    </h2>

                                </div>
                                <div class="panel-container show">
                                    <div class="panel-content">   
                                        <div id="container7" style="height:500px"></div>     

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div id="panel-7" class="panel">
                                <div class="panel-hdr">
                                    <h2>
                                        <?= 'पिछले कुछ दिनों में गाँव में इस तरह के बीमारियों की गम्भीरता कैसी है ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>
                                    </h2>
                                </div>
                                <div class="panel-container show">
                                    <div class="panel-content">   
                                        <div id="container8" style="height:500px"></div> 

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
                        var que1a1 = <?php echo $graph['que1a1'] ?: 0; ?>;
                        var que1a2 = <?php echo $graph['que1a2'] ?: 0; ?>;
                        var total_cf = <?php echo $graph['total'] ?: 0; ?>;
                        var que2a1 = <?php echo $graph['que2a1'] ?: 0; ?>;
                        var que2a2 = <?php echo $graph['que2a2'] ?: 0; ?>;
                        var que2a3 = <?php echo $graph['que2a3'] ?: 0; ?>;
                        var que2a4 = <?php echo $graph['que2a4'] ?: 0; ?>;
                        var que3a1 = <?php echo $graph['que3a1'] ?: 0; ?>;
                        var que3a2 = <?php echo $graph['que3a2'] ?: 0; ?>;
                        var que3a3 = <?php echo $graph['que3a3'] ?: 0; ?>;
                        var que3a4 = <?php echo $graph['que3a4'] ?: 0; ?>;
                        var que3a5 = <?php echo $graph['que3a5'] ?: 0; ?>;

                        var que4a1 = <?php echo $graph['que4a1'] ?: 0; ?>;
                        var que4a2 = <?php echo $graph['que4a2'] ?: 0; ?>;
                        var que4a3 = <?php echo $graph['que4a3'] ?: 0; ?>;


                    </script>
                    <?php
                    $script = <<< JS
Highcharts.setOptions({
     //  colors: ['#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
       // colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A']//star rating 
        colors: ['#3CB371', '#FF9933', '#00BFFF', '#FF0000', '#505050', '#1DC9B7', '#2196F3'],
    });        
Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        useHTML: true,
        text: 'क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है ?'
    },
    
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        allowDecimals: false,
        title: {
            useHTML: true,
            text: 'No. of Corona feedback '
        }
    },
    legend: {
        enabled: false
    },
     credits:{
       enabled:false,
     },    
    tooltip: {
        useHTML: true,                    
        pointFormat: 'तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न: <b>{point.y}</b>'
    },
      plotOptions: {
        colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A'],
        column: {
            colorByPoint: true
        }
    },
     exporting: {
        buttons: {
          contextButton: {
            menuItems: ['downloadPNG',  'downloadPDF'],
          },
        },
     },       
    series: [{
        name: 'तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न',
        data: [
            ['हाँ', que1a1],
            ['नहीं', que1a2],
           
        ],
        dataLabels: {
            enabled: true,
           useHTML: true,
            align: 'center',
            format: '{point.y}', // one decimal
            //y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
Highcharts.chart('container4', {
    chart: {
        type: 'column'
    },
    title: {
        useHTML: true,
        text: 'तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न'
    },
    subtitle: {
        useHTML: true,
        text: '(अगर हाँ )'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        allowDecimals: false,
        title: {
            text: 'No. of Corona feedback'
        }
    },
    legend: {
        enabled: false
    },
     credits:{
       enabled:false,
     },    
    tooltip: {
        useHTML: true,                    
        pointFormat: 'तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न : <b>{point.y}</b>'
    },
      plotOptions: {
        colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A'],
        column: {
            colorByPoint: true
        }
    },
     exporting: {
        buttons: {
          contextButton: {
            menuItems: ['downloadPNG',  'downloadPDF'],
          },
        },
     },       
    series: [{
        name: 'तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न',
        data: [
            ['लगभग 10%', que2a1],
            ['लगभग 25%', que2a2],
            ['लगभग 50%', que2a3],
            ['लगभग 90%', que2a4],
            
        ],
        dataLabels: {
            enabled: true,
            //color: '#FFFFFF',
            align: 'center',
            format: '{point.y}', // one decimal
           // y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
Highcharts.chart('container6', {
    chart: {
        type: 'column'
    },
    title: {
        useHTML: true,
        text: 'पिछले एक दो महीने में गाँव/ ग्रा०प० में कितने लोगों की मृत्यु हुई है ?'
    },
    
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        allowDecimals: false,
        title: {
            text: 'No. of Corona feedback'
        }
    },
    legend: {
        enabled: false
    },
     credits:{
       enabled:false,
     },    
    tooltip: {
        useHTML: true,                    
        pointFormat: 'मृत्यु हुई : <b>{point.y}</b>'
    },
      plotOptions: {
        colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A'],
        column: {
            colorByPoint: true
        }
    },
     exporting: {
        buttons: {
          contextButton: {
            menuItems: ['downloadPNG',  'downloadPDF'],
          },
        },
     },       
    series: [{
        name: 'Social Category',
        data: [
            ['कोई नहीं', que3a1],
            ['5 से कम', que3a2],
            ['5 से 10', que3a3],
            ['10 से 25', que3a4],
            ['25 से ज़्यादा', que3a5],
        ],
        dataLabels: {
            enabled: true,
           useHTML: true,
            align: 'center',
            format: '{point.y}', // one decimal
            //y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
Highcharts.chart('container8', {
    chart: {
        type: 'column'
    },
    title: {
        useHTML: true,
        text: 'पिछले कुछ दिनों में गाँव में इस तरह के बीमारियों की गम्भीरता कैसी है ?'
    },
    
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        allowDecimals: false,
        title: {
            text: 'No. of Corona feedback'
        }
    },
    legend: {
        enabled: false
    },
     credits:{
       enabled:false,
     },    
    tooltip: {
       useHTML: true,                 
        pointFormat: 'पिछले कुछ दिनों में गाँव में इस तरह के बीमारियों की गम्भीरता कैसी है  : <b>{point.y}</b>'
    },
      plotOptions: {
        colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A'],
        column: {
            colorByPoint: true
        }
    },
     exporting: {
        buttons: {
          contextButton: {
            menuItems: ['downloadPNG',  'downloadPDF'],
          },
        },
     },       
    series: [{
        name: 'पिछले कुछ दिनों में गाँव में इस तरह के बीमारियों की गम्भीरता कैसी है',
        data: [
            ['कम हो रहा है', que4a1],
            ['स्थिति यथापूर्व है', que4a2],
            ['बढ़ रहा है', que4a3],      
        ],
        dataLabels: {
            enabled: true,
            useHTML: true,
            align: 'center',
            format: '{point.y}', // one decimal
           // y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
JS;
                    $this->registerJs($script);
                    ?>
                    <?php
                    $script = <<< JS
Highcharts.chart('container1', {
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
        text: 'क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है'
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
            dataLabels: {
                enabled: true,
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
        enabled: true,
        useHTML: true,
      },                    
        name: 'तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न',
        colorByPoint: true,
        data: [{
            
            name: 'हाँ',
            y: que1a1
        }, {
            name: 'नहीं',
            y: que1a2
        }, 
        
        
            ]
    }]
});
Highcharts.chart('container3', {
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
        text: 'तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न'
    },
    subtitle: {
        useHTML: true,
        text: '(अगर हाँ )'
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
            dataLabels: {
                enabled: true,
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
        enabled: true,
        useHTML: true,
      },                     
        name: 'तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न ',
        colorByPoint: true,
        data: [{
            
            name: 'लगभग 10%',
            y: que2a1
        }, {
            name: 'लगभग 25%',
            y: que2a2
        },{
            name: 'लगभग 50%',
            y: que2a3
        },{
            name: 'लगभग 90%',
            y: que2a4
        }, 
            ]
    }]
});
Highcharts.chart('container5', {
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
        text: 'पिछले एक दो महीने में गाँव/ ग्रा०प० में कितने लोगों की मृत्यु हुई है ?'
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
            dataLabels: {
                enabled: true,
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
        enabled: true,
        useHTML: true,
      },                    
        name: 'मृत्यु हुई',
        colorByPoint: true,
        data: [{
            
            name: 'कोई नहीं',
            y: que3a1
        }, {
            name: '5 से कम',
            y: que3a2
        },{
            name: '5 से 10',
            y: que3a3
        }, {
            name: '10 से 25',
            y: que3a4
        }, {
            name: '25 से ज़्यादा',
            y: que3a5
        },  
        
        
            ]
    }]
});
Highcharts.chart('container7', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie',
    },
        credits:{
 enabled:false,
},
    title: {
        useHTML: true,
        text: 'पिछले कुछ दिनों में गाँव में इस तरह के बीमारियों की गम्भीरता कैसी है ?'
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
            dataLabels: {
                enabled: true,
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
        enabled: true,
        useHTML: true,
      },
        name: 'बीमारियों की गम्भीरता कैसी है',
        colorByPoint: true,
        data: [{
            
            name: 'कम हो रहा है',
            y: que4a1
        }, {
            name: 'स्थिति यथापूर्व है',
            y: que4a2
        },{
            name: 'बढ़ रहा है',
            y: que4a3
        } 
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
