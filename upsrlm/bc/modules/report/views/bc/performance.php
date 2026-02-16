<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
//use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\Highstock;

//
//use miloschuman\highcharts\HighchartsAsset;
//
//HighchartsAsset::register($this)->withScripts(['modules/stock', 'modules/exporting', 'modules/drilldown']);

$this->title = 'BC Performance';
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


                    <div class="col-xl-12">

                        <?php
                        echo Highstock::widget([
                            'options' => [
                                'credits' => ['enabled' => false],
                                'rangeSelector' => [
                                    'selected' => 1,
                                ],
                                'exporting' => [
                                    'buttons' => [
                                        'contextButton' => [
                                            'menuItems' => ['downloadPNG', 'downloadPDF']
                                        ]
                                    ]
                                ],
                                'title' => [
                                    'text' => 'BC Bank detail submission by date',
                                ],
                                'series' => [[
                                'name' => 'Submission',
                                'data' => $bc_bank_responce,
                                'tootltip' => [
                                    'valueDecimals' => 2
                                ],
                                    ]],
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-xl-12">

                        <?php
                        echo Highstock::widget([
                            'options' => [
                                'credits' => ['enabled' => false],
                                'rangeSelector' => [
                                    'selected' => 1,
                                ],
                                'exporting' => [
                                    'buttons' => [
                                        'contextButton' => [
                                            'menuItems' => ['downloadPNG', 'downloadPDF']
                                        ]
                                    ]
                                ],
                                'title' => [
                                    'text' => 'BC SHG Bank detail submission by date',
                                ],
                                'series' => [[
                                'name' => 'Submission',
                                'data' => $bc_shg_bank_responce,
                                'tootltip' => [
                                    'valueDecimals' => 2
                                ],
                                    ]],
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var databc = <?php print json_encode($bc_bank_responce) ?>;



</script>
<?php
//$script = <<< JS
//Highcharts.stockChart('containerbc', {
//
//        rangeSelector: {
//            selected: 1
//        },
//         legend: {
//        enabled: false
//    },
//        exporting: {
//        buttons: {
//          contextButton: {
//            menuItems: ['downloadPNG',  'downloadPDF'],
//          },
//        },
//     },  
//        title: {
//            text: 'BC Bank detail submission by date'
//        },
//
//        series: [{
//            name: 'Submission',
//            data: databc,
//            type: 'spline',
//            tooltip: {
//                valueDecimals: 2
//            }
//        }]
//    });
//
//   
//JS;
//$this->registerJs($script);
?>  

