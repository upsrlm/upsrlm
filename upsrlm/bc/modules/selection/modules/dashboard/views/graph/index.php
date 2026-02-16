<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use common\models\User;
use common\models\master\MasterRole;
use common\assets\HighChartsAssets;

HighChartsAssets::register($this);
$this->title = 'SRLM BC Selection : application received';
$this->params['icon'] = 'fa fa-pie-chart';
$this->params['breadcrumbs'][] = $this->title;
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
        <div class="panel">
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
                    $form = ActiveForm::begin([
                                'layout' => 'inline',
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'Searchform'
                                ],
                                'method' => 'POST',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_search', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <?php ActiveForm::end(); ?>
                    <div class="clearfix pt-3"></div>
                    <div class="col-xs-12 applicant" id="printcontaineer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading text-center py-2">Total application received : <?php echo $graph1['total'] ?: 0; ?></div> 
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div id="container10" style="height:600px"></div> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div id="container13" style="height:600px"></div> 
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div id="container12"  style="height:600px" ></div> 
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div id="container14"  style="height:600px"></div> 
                                </div>
                            </div>
                        </div>

                        <!--    <div class="row">
                                <div class="col-md-4">
                                    <div class="panel panel-info">
                                        <div id="container7"></div> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-info">
                                        <div id="container8"></div> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-info">
                                        <div id="container9"></div> 
                                    </div>
                                </div>
                            </div>-->

                        <!--    <div class="row">
                                <div class="col-md-4">
                                    <div class="box">
                                        <div id="container2" style="height:600px"></div> 
                                    </div>
                                </div>
                        
                                <div class="col-md-4">
                                    <div class="panel panel-info">
                                        <div id="container5" style="height:600px"></div> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-info">
                                        <div id="container6" style="height:600px"></div> 
                                    </div>
                                </div>
                            </div>-->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div id="container11"  style="height:600px"></div> 
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div id="container15"  style="height:600px"></div> 
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>
<script>
    var married = <?php echo $graph1['married'] ?: 0; ?>;
    var unmarried = <?php echo $graph1['unmarried'] ?: 0; ?>;
    var total_ms = <?php echo $graph1['total'] ?: 0; ?>;
    var reds1 = <?php echo $graph2['reds1'] ?: 0; ?>;
    var reds2 = <?php echo $graph2['reds2'] ?: 0; ?>;
    var reds3 = <?php echo $graph2['reds3'] ?: 0; ?>;
    var reds4 = <?php echo $graph2['reds4'] ?: 0; ?>;
    var reds5 = <?php echo $graph2['reds5'] ?: 0; ?>;
    var total_reds = <?php echo $graph2['total'] ?: 0; ?>;
    var cast1 = <?php echo $graph3['cast1'] ?: 0; ?>;
    var cast2 = <?php echo $graph3['cast2'] ?: 0; ?>;
    var cast3 = <?php echo $graph3['cast3'] ?: 0; ?>;
    var total_cast = <?php echo $graph3['total'] ?: 0; ?>;
    var age1 = <?php echo $graph4['age1'] ?: 0; ?>;
    var age2 = <?php echo $graph4['age2'] ?: 0; ?>;
    var age3 = <?php echo $graph4['age3'] ?: 0; ?>;
    var age4 = <?php echo $graph4['age4'] ?: 0; ?>;
    var age5 = <?php echo $graph4['age5'] ?: 0; ?>;
    var total_age = <?php echo $graph4['total'] ?: 0; ?>;
    var pt1 = <?php echo $graph5['pt1'] ?: 0; ?>;
    var pt2 = <?php echo $graph5['pt2'] ?: 0; ?>;
    var total_pt = <?php echo $graph5['total'] ?: 0; ?>;
    var wyes = <?php echo $graph6['yes'] ?: 0; ?>;
    var wno = <?php echo $graph6['no'] ?: 0; ?>;
    var total_w = <?php echo $graph6['total'] ?: 0; ?>;
    var agm1 = <?php echo $graph7['agm1'] ?: 0; ?>;
    var agm2 = <?php echo $graph7['agm2'] ?: 0; ?>;
    var agm3 = <?php echo $graph7['agm3'] ?: 0; ?>;
    var agm4 = <?php echo $graph7['agm4'] ?: 0; ?>;
    var agm5 = <?php echo $graph7['agm5'] ?: 0; ?>;
    var agm6 = <?php echo $graph7['agm6'] ?: 0; ?>;
    var agm7 = <?php echo $graph7['agm7'] ?: 0; ?>;
    var agm8 = <?php echo $graph7['agm8'] ?: 0; ?>;
    var agm9 = <?php echo $graph7['agm9'] ?: 0; ?>;
    var agm10 = <?php echo $graph7['agm10'] ?: 0; ?>;
    var agm11 = <?php echo $graph7['agm11'] ?: 0; ?>;
    var agm12 = <?php echo $graph7['agm12'] ?: 0; ?>;
    var agm13 = <?php echo $graph7['agm13'] ?: 0; ?>;
    var total_agm = <?php echo $graph7['total'] ?: 0; ?>;

</script>
<?php
$script = <<< JS
Highcharts.setOptions({
     //  colors: ['#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
       // colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A']//star rating 
        colors: ['#3CB371', '#FF9933', '#00BFFF', '#FF0000', '#505050', '#1DC9B7', '#2196F3'],
    });        
//Highcharts.chart('container1', {
//    chart: {
//        type: 'column'
//    },
//    title: {
//        text: 'SRLM BC Selection Application : Marital Status'
//    },
//    
//    xAxis: {
//        type: 'category',
//        labels: {
//            rotation: -45,
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    },
//    yAxis: {
//        min: 0,
//        allowDecimals: false,
//        title: {
//            text: 'No. of SRLM BC Selection Application'
//        }
//    },
//    legend: {
//        enabled: false
//    },
//     credits:{
//       enabled:false,
//     },    
//    tooltip: {
//        pointFormat: 'Marital Status: <b>{point.y}</b>'
//    },
//      plotOptions: {
//        colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A'],
//        column: {
//            colorByPoint: true
//        }
//    },
//     exporting: {
//        buttons: {
//          contextButton: {
//            menuItems: ['downloadPNG',  'downloadPDF'],
//          },
//        },
//     },       
//    series: [{
//        name: 'Marital Status',
//        data: [
//            ['Married', married],
//            ['Unmarried', unmarried],
//           
//        ],
//        dataLabels: {
//            enabled: true,
//           // color: '#FFFFFF',
//            align: 'center',
//            format: '{point.y}', // one decimal
//            //y: 10, // 10 pixels down from the top
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    }]
//});
//Highcharts.chart('container2', {
//    chart: {
//        type: 'column'
//    },
//    title: {
//        text: 'SRLM BC Selection Application : Education / Functional skills'
//    },
//    subtitle: {
//        text: '(reading English, reading & writing Hindi & basic calculations)'
//    },
//    xAxis: {
//        type: 'category',
//        labels: {
//            rotation: -45,
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    },
//    yAxis: {
//        min: 0,
//        allowDecimals: false,
//        title: {
//            text: 'No. of SRLM BC Selection Application'
//        }
//    },
//    legend: {
//        enabled: false
//    },
//     credits:{
//       enabled:false,
//     },    
//    tooltip: {
//        pointFormat: 'Education / Reading Skills: <b>{point.y}</b>'
//    },
//      plotOptions: {
//        colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A'],
//        column: {
//            colorByPoint: true
//        }
//    },
//     exporting: {
//        buttons: {
//          contextButton: {
//            menuItems: ['downloadPNG',  'downloadPDF'],
//          },
//        },
//     },       
//    series: [{
//        name: 'Education / Reading Skills',
//        data: [
//            ['Class 10 pass', reds1],
//            ['Class 10 pass and proficient in group functions', reds2],
//            ['Proficient in group functions', reds3],
//            ['Class 10 does not pass; But there is no problem in reading and writing', reds4],
//            ['There are problems with reading and writing; Reads needing help from another;', reds5],
//        ],
//        dataLabels: {
//            enabled: true,
//            //color: '#FFFFFF',
//            align: 'center',
//            format: '{point.y}', // one decimal
//           // y: 10, // 10 pixels down from the top
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    }]
//});
//Highcharts.chart('container3', {
//    chart: {
//        type: 'column'
//    },
//    title: {
//        text: 'SRLM BC Selection Application: Social Category'
//    },
//    
//    xAxis: {
//        type: 'category',
//        labels: {
//            rotation: -45,
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    },
//    yAxis: {
//        min: 0,
//        allowDecimals: false,
//        title: {
//            text: 'No. of SRLM BC Selection Application'
//        }
//    },
//    legend: {
//        enabled: false
//    },
//     credits:{
//       enabled:false,
//     },    
//    tooltip: {
//        pointFormat: 'Social Category: <b>{point.y}</b>'
//    },
//      plotOptions: {
//        colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A'],
//        column: {
//            colorByPoint: true
//        }
//    },
//     exporting: {
//        buttons: {
//          contextButton: {
//            menuItems: ['downloadPNG',  'downloadPDF'],
//          },
//        },
//     },       
//    series: [{
//        name: 'Social Category',
//        data: [
//            ['SC / ST', cast1],
//            ['OBC', cast2],
//            ['General', cast3],
//        ],
//        dataLabels: {
//            enabled: true,
//           // color: '#FFFFFF',
//            align: 'center',
//            format: '{point.y}', // one decimal
//            //y: 10, // 10 pixels down from the top
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    }]
//});
//Highcharts.chart('container4', {
//    chart: {
//        type: 'column'
//    },
//    title: {
//        text: 'SRLM BC Selection Application : Age Group'
//    },
//    
//    xAxis: {
//        type: 'category',
//        labels: {
//            rotation: -45,
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    },
//    yAxis: {
//        min: 0,
//        allowDecimals: false,
//        title: {
//            text: 'No. of SRLM BC Selection Application'
//        }
//    },
//    legend: {
//        enabled: false
//    },
//     credits:{
//       enabled:false,
//     },    
//    tooltip: {
//        pointFormat: 'Age Group: <b>{point.y}</b>'
//    },
//      plotOptions: {
//        colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A'],
//        column: {
//            colorByPoint: true
//        }
//    },
//     exporting: {
//        buttons: {
//          contextButton: {
//            menuItems: ['downloadPNG',  'downloadPDF'],
//          },
//        },
//     },       
//    series: [{
//        name: 'Age Group',
//        data: [
//            ['18-25 Years', age1],
//            ['26-32 Years', age2],
//            ['33-40 Years', age3],
//            ['41-50 Years', age4],
//            ['50 Above', age5],
//        ],
//        dataLabels: {
//            enabled: true,
//          //  color: '#FFFFFF',
//            align: 'center',
//            format: '{point.y}', // one decimal
//           // y: 10, // 10 pixels down from the top
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    }]
//}); 
//Highcharts.chart('container5', {
//    chart: {
//        type: 'column'
//    },
//    title: {
//        text: 'SRLM BC Selection Application : Phone Type'
//    },
//    
//    xAxis: {
//        type: 'category',
//        labels: {
//            rotation: -45,
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    },
//    yAxis: {
//        min: 0,
//        allowDecimals: false,
//        title: {
//            text: 'No. of SRLM BC Selection Application'
//        }
//    },
//    legend: {
//        enabled: false
//    },
//     credits:{
//       enabled:false,
//     },    
//    tooltip: {
//        pointFormat: 'Phone Type: <b>{point.y}</b>'
//    },
//      plotOptions: {
//        colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A'],
//        column: {
//            colorByPoint: true
//        }
//    },
//     exporting: {
//        buttons: {
//          contextButton: {
//            menuItems: ['downloadPNG',  'downloadPDF'],
//          },
//        },
//     },       
//    series: [{
//        name: 'Phone Type',
//        data: [
//            ['Smartphone', pt1],
//            ['Basic Feature Phone', pt2],
//           
//        ],
//        dataLabels: {
//            enabled: true,
//          //  color: '#FFFFFF',
//            align: 'center',
//            format: '{point.y}', // one decimal
//          //  y: 10, // 10 pixels down from the top
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    }]
//}); 
        
//Highcharts.chart('container6', {
//    chart: {
//        type: 'column'
//    },
//    title: {
//        text: 'SRLM BC Selection Application : Whatsapp number'
//    },
//    
//    xAxis: {
//        type: 'category',
//        labels: {
//            rotation: -45,
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    },
//    yAxis: {
//        min: 0,
//        allowDecimals: false,
//        title: {
//            text: 'No. of SRLM BC Selection Application'
//        }
//    },
//    legend: {
//        enabled: false
//    },
//     credits:{
//       enabled:false,
//     },    
//    tooltip: {
//        pointFormat: 'Whatsapp number: <b>{point.y}</b>'
//    },
//      plotOptions: {
//        colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A'],
//        column: {
//            colorByPoint: true
//        }
//    },
//     exporting: {
//        buttons: {
//          contextButton: {
//            menuItems: ['downloadPNG',  'downloadPDF'],
//          },
//        },
//     },       
//    series: [{
//        name: 'Whatsapp number',
//        data: [
//            ['Yes', wyes],
//            ['No', wno],
//           
//        ],
//        dataLabels: {
//            enabled: true,
//            color: '#FFFFFF',
//            align: 'center',
//            format: '{point.y}', // one decimal
//            y: 10, // 10 pixels down from the top
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    }]
//});
    
//Highcharts.chart('container6', {
//    chart: {
//        type: 'column'
//    },
//    title: {
//        text: 'SRLM BC Selection Application : Group Member'
//    },
//    
//    xAxis: {
//        type: 'category',
//        labels: {
//            rotation: -45,
//            style: {
//                fontSize: '13px',
//                fontFamily: 'Verdana, sans-serif'
//            }
//        }
//    },
//    yAxis: {
//        min: 0,
//        allowDecimals: false,
//        title: {
//            text: 'No. of SRLM BC Selection Application'
//        }
//    },
//    legend: {
//        enabled: false
//    },
//     credits:{
//       enabled:false,
//     },    
//    tooltip: {
//        pointFormat: 'Group Member : <b>{point.y}</b>'
//    },
//      plotOptions: {
//        colors: ['#6B2BA5', '#347EC0', '#44CCA5', '#FFB056', '#E1004A'],
//        column: {
//            colorByPoint: true
//        }
//    },
//     exporting: {
//        buttons: {
//          contextButton: {
//            menuItems: ['downloadPNG',  'downloadPDF'],
//          },
//        },
//     },       
//    series: [{
//        name: 'Group Member',
//        data: [
//            ['No', agm1],
//            ['Chairman', agm2],
//            ['Vice Chairman / Secretary', agm3],
//            ['Cashier', agm4],
//            ['Samuh Sakhi', agm5],
//            ['Krishi Sakhi', agm6],
//            ['Pashu Sakhi', agm7],
//            ['Bank Sakhi', agm8],
//            ['BC Sakhi', agm9],
//            ['VO Ledger', agm10],
//            ['CLF Ledger', agm11],
//            ['Internal community resource person', agm12],
//            ['Any other', agm13],   
//        ],
////        dataLabels: {
////            enabled: true,
////            //color: '#FFFFFF',
////            align: 'center',
////            format: '{point.y}', // one decimal
////            //y: 10, // 10 pixels down from the top
////            style: {
////                fontSize: '13px',
////                fontFamily: 'Verdana, sans-serif'
////            }
////        }
//    }]
//});    
JS;
$this->registerJs($script);
?>
<?php
$script = <<< JS
Highcharts.chart('container10', {
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
        text: 'SRLM BC Selection Application : Marital Status'
    },
    tooltip: {
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
        name: 'Marital Status',
        colorByPoint: true,
        data: [{
            
            name: 'Married',
            y: married
        }, {
            name: 'Unmarried',
            y: unmarried
        }, 
        
        
            ]
    }]
});
Highcharts.chart('container12', {
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
        text: 'SRLM BC Selection Application : Social Category'
    },
    tooltip: {
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
        name: 'Social Category',
        colorByPoint: true,
        data: [{
            
            name: 'SC / ST',
            y: cast1
        }, {
            name: 'OBC',
            y: cast2
        },{
            name: 'General',
            y: cast3
        }, 
            ]
    }]
});
Highcharts.chart('container11', {
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
        text: 'SRLM BC Selection Application : Education / Functional skills '
    },
    subtitle: {
        text: '(reading English, reading & writing Hindi & basic calculations)'
    },
    tooltip: {
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
        name: 'Education / Reading Skills',
        colorByPoint: true,
        data: [{
            
            name: 'Class 10th pass',
            y: reds1
        }, {
            name: 'Class 10th pass and proficient in group functions',
            y: reds2
        },{
            name: 'Proficient in group functions',
            y: reds3
        }, {
            name: 'Class 10th not passed; no problem in reading-writing skills',
            y: reds4
        }, {
            name: 'Problem in reading-writing; need others help',
            y: reds5
        },  
        
        
            ]
    }]
});
Highcharts.chart('container13', {
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
        text: 'SRLM BC Selection Application : Age Group'
    },
    tooltip: {
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
        name: 'Age Group',
        colorByPoint: true,
        data: [{
            
            name: '18-25 Years',
            y: age1
        }, {
            name: '26-32 Years',
            y: age2
        },{
            name: '33-40 Years',
            y: age3
        }, {
            name: '41-50 Years',
            y: age4
        }, {
            name: 'Above 50',
            y: age5
        },  
        
        
            ]
    }]
});
Highcharts.chart('container14', {
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
        text: 'SRLM BC Selection Application : Phone Type'
    },
    tooltip: {
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
        name: 'Phone Type',
        colorByPoint: true,
        data: [{
            
            name: 'Smartphone',
            y: pt1
        }, {
            name: 'Basic Feature Phone',
            y: pt2
        },
            ]
    }]
});
Highcharts.chart('container15', {
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
        text: 'SRLM BC Selection Application : Group Member'
    },
    tooltip: {
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
        name: 'Group Member',
        colorByPoint: true,
        data: [{
            
            name: 'No',
            y: agm1
        }, {
            name: 'Chair person',
            y: agm2
        },{
            name: 'Vice Chair person/ Secretary',
            y: agm3
        },{
            name: 'Treasurer',
            y: agm4
        },{
            name: 'Samuh Sakhi',
            y: agm5
        },{
            name: 'Krishi Sakhi',
            y: agm6
        },{
            name: 'Pashu Sakhi',
            y: agm7
        },{
            name: 'Bank Sakhi',
            y: agm8
        },{
            name: 'BC Sakhi',
            y: agm9
        },{
            name: 'VO lekhakar',
            y: agm10
        },{
            name: 'CLF lekhakar',
            y: agm11
        },{
            name: 'FLCRP',
            y: agm12
        },{
            name: 'Any other',
            y: agm13
        },
            ]
    }]
});    
JS;
$this->registerJs($script);
?>  
<?php
$script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/selection/dashboard/graph"});
     $("#Searchform").attr("data-pjax", "True");    
    $(this).closest('form').submit();
});            
         
JS;
$this->registerJs($script);
?>      


<?php Pjax::end(); ?>    


