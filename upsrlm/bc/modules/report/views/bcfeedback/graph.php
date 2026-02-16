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
$this->title = "प्रशिक्षण व संवेदिकरण";
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
                    echo $this->render('_searchg', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <div class="row mb-6"></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="panel-2" class="panel">
                                <div class="panel-hdr">
                                    <h1>
                                        <?= '1. फ़्रॉड कॉल के माध्यम से ऑनलाइन आपके बैंक खाते से पैसे निकाल लेने के ख़तरे' ?>
                                    </h1>

                                </div>
                                <div class="panel-container show">
                                    <div class="panel-content">  
                                        <div id="container1" style="height:500px"></div>     

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div id="panel-3" class="panel">
                                <div class="panel-hdr">
                                    <h1>
                                        <?= '1. फ़्रॉड कॉल के माध्यम से ऑनलाइन आपके बैंक खाते से पैसे निकाल लेने के ख़तरे' ?>
                                    </h1>

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
                                    <h1>
                                        <?= '2. ऐंटी मनी लॉंडरिंग (AML)/ ग़लत तरीक़े से ऑनलाइन पैसे के लेनदेन से जुड़े विषय ' ?>
                                    </h1>

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
                                    <h1>
                                        <?= '2. ऐंटी मनी लॉंडरिंग (AML)/ ग़लत तरीक़े से ऑनलाइन पैसे के लेनदेन से जुड़े विषय ' ?>
                                    </h1>

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
                                    <h1>
                                        <?= '3. नक़ली मुद्रा/ नोट के ख़तरे - उनके व्यवहार एवं पहचान करने के तरीक़े ताकि उनसे बचा जा सके ।' ?>
                                    </h1>

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
                                    <h1>
                                        <?= '3. नक़ली मुद्रा/ नोट के ख़तरे - उनके व्यवहार एवं पहचान करने के तरीक़े ताकि उनसे बचा जा सके ।' ?>
                                    </h1>

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
                                    <h1>
                                        <?= '4.क्या आपको सभी विषय एवं उनसे सम्बंधित सावधानियों के बारे समझ मिली?' ?>
                                    </h1>

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
                                   <h1>
                                        <?= '4.क्या आपको सभी विषय एवं उनसे सम्बंधित सावधानियों के बारे समझ मिली?।' ?>
                                    </h1>
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
                        var que1a3 = <?php echo $graph['que1a3'] ?: 0; ?>;
                        var total_cf = <?php echo $graph['total'] ?: 0; ?>;
                        var que2a1 = <?php echo $graph['que2a1'] ?: 0; ?>;
                        var que2a2 = <?php echo $graph['que2a2'] ?: 0; ?>;
                        var que2a3 = <?php echo $graph['que2a3'] ?: 0; ?>;
                        var que3a1 = <?php echo $graph['que3a1'] ?: 0; ?>;
                        var que3a2 = <?php echo $graph['que3a2'] ?: 0; ?>;
                        var que3a3 = <?php echo $graph['que3a3'] ?: 0; ?>;
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
        text: '1. फ़्रॉड कॉल के माध्यम से ऑनलाइन आपके बैंक खाते से पैसे निकाल लेने के ख़तरे'
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
            text: 'No. of feedback '
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
        pointFormat: '1. फ़्रॉड कॉल के माध्यम से ऑनलाइन आपके बैंक खाते से पैसे निकाल लेने के ख़तरे: <b>{point.y}</b>'
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
        name: '1. फ़्रॉड कॉल के माध्यम से ऑनलाइन आपके बैंक खाते से पैसे निकाल लेने के ख़तरे',
        data: [
            ['हाँ', que1a1],
            ['नहीं', que1a2],
            ['थोड़ी बहुत', que1a3],
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
        text: '2. ऐंटी मनी लॉंडरिंग (AML)/ ग़लत तरीक़े से ऑनलाइन पैसे के लेनदेन से जुड़े विषय'
    },
    subtitle: {
        useHTML: true,
       
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
            text: 'No. of feedback'
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
        pointFormat: '2. ऐंटी मनी लॉंडरिंग (AML)/ ग़लत तरीक़े से ऑनलाइन पैसे के लेनदेन से जुड़े विषय : <b>{point.y}</b>'
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
        name: '2. ऐंटी मनी लॉंडरिंग (AML)/ ग़लत तरीक़े से ऑनलाइन पैसे के लेनदेन से जुड़े विषय',
        data: [
            ['हाँ', que2a1],
            ['नहीं', que2a2],
            ['थोड़ी बहुत', que2a3],      
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
        text: '3. नक़ली मुद्रा/ नोट के ख़तरे - उनके व्यवहार एवं पहचान करने के तरीक़े ताकि उनसे बचा जा सके ।'
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
            text: 'No. of feedback'
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
        pointFormat: '3. नक़ली मुद्रा/ नोट के ख़तरे - उनके व्यवहार एवं पहचान करने के तरीक़े ताकि उनसे बचा जा सके । : <b>{point.y}</b>'
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
            ['हाँ', que3a1],
            ['नहीं', que3a2],
            ['थोड़ी बहुत', que3a3],
            
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
        text: '4.क्या आपको सभी विषय एवं उनसे सम्बंधित सावधानियों के बारे समझ मिली?।'
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
            text: 'No. of feedback'
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
        pointFormat: '4.क्या आपको सभी विषय एवं उनसे सम्बंधित सावधानियों के बारे समझ मिली?।  : <b>{point.y}</b>'
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
        name: '4.क्या आपको सभी विषय एवं उनसे सम्बंधित सावधानियों के बारे समझ मिली?।',
        data: [
            ['बिलकुल जानकारी नहीं मिली है', que4a1],
            ['और जानकारी और स्पष्टता की ज़रूरत है', que4a2],
            ['अच्छी समझ बनी है - ख़तरों से स्वयं निपट सकेंगे', que4a3],      
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
        text: '1. फ़्रॉड कॉल के माध्यम से ऑनलाइन आपके बैंक खाते से पैसे निकाल लेने के ख़तरे'
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
        name: '1. फ़्रॉड कॉल के माध्यम से ऑनलाइन आपके बैंक खाते से पैसे निकाल लेने के ख़तरे',
        colorByPoint: true,
        data: [{
            
            name: 'हाँ',
            y: que1a1
        }, {
            name: 'नहीं',
            y: que1a2
        }, 
        {
            name: 'थोड़ी बहुत',
            y: que1a3
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
        text: '2. ऐंटी मनी लॉंडरिंग (AML)/ ग़लत तरीक़े से ऑनलाइन पैसे के लेनदेन से जुड़े विषय '
    },
    subtitle: {
        useHTML: true,
        
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
        name: '2. ऐंटी मनी लॉंडरिंग (AML)/ ग़लत तरीक़े से ऑनलाइन पैसे के लेनदेन से जुड़े विषय ',
        colorByPoint: true,
        data: [{
            
            name: 'हाँ',
            y: que2a1
        }, {
            name: 'नहीं',
            y: que2a2
        },{
            name: 'थोड़ी बहुत',
            y: que2a3
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
        text: '3. नक़ली मुद्रा/ नोट के ख़तरे - उनके व्यवहार एवं पहचान करने के तरीक़े ताकि उनसे बचा जा सके । '
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
        name: '3. नक़ली मुद्रा/ नोट के ख़तरे - उनके व्यवहार एवं पहचान करने के तरीक़े ताकि उनसे बचा जा सके । ',
        colorByPoint: true,
        data: [{
            
            name: 'हाँ',
            y: que3a1
        }, {
            name: 'नहीं',
            y: que3a2
        },{
            name: 'थोड़ी बहुत',
            y: que3a3
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
        text: '4.क्या आपको सभी विषय एवं उनसे सम्बंधित सावधानियों के बारे समझ मिली?।'
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
        name: '4.क्या आपको सभी विषय एवं उनसे सम्बंधित सावधानियों के बारे समझ मिली?।',
        colorByPoint: true,
        data: [{
            
            name: 'बिलकुल जानकारी नहीं मिली है',
            y: que4a1
        }, {
            name: 'और जानकारी और स्पष्टता की ज़रूरत है',
            y: que4a2
        },{
            name: 'अच्छी समझ बनी है - ख़तरों से स्वयं निपट सकेंगे',
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
