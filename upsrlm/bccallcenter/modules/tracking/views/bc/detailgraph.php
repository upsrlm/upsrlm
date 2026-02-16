<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

miloschuman\highcharts\HighchartsAsset::register($this);
kartik\detail\DetailViewAsset::register($this);
$bundle = \common\assets\AjaxAppAsset::register($this);
$models->date_from = $graph->date_from;
//echo "<pre>";
//print_r($bc_graph);
//echo "</pre>";
?>
<div class="row">

    <div class="col-lg-7">

        <?=
        miloschuman\highcharts\Highcharts::widget([
            'scripts' => [
                'highcharts-more',
                'modules/exporting',
                'themes/grid',
            ],
            'htmlOptions' => ['id' => $models->id, 'style' => 'width:900px'],
            'options' => [
                'chart' => [
                    'type' => 'spline',
                    'height' => 300
                ],
                //'rangeSelector' => ['enabled' => false],
                'credits' => ['enabled' => false],
                'legend' => [
                    'enabled' => true,
                    //'layout' =>'vertical',
                    'align' => 'center',
                ],
                'exporting' => [
                    'buttons' => [
                        'contextButton' => [
                            'menuItems' => ['downloadPNG', 'downloadPDF']
                        ]
                    ]
                ],
                'title' => [
                    'text' => $models->date_from . ' To ' . $models->date_to . ' Performance of BCs',
                ],
                'xAxis' => [
                    'categories' => array_values($bc_graph['category']),
                    'labels' => ['rotation' => -45]
                ],
                'series' => [
                    [
                        'type' => 'spline',
                        'name' => 'BC Transction',
                        'data' => $bc_graph['transaction'],
                        'dashStyle' => 'ShortDot',
                        'tootltip' => [
                            'valueDecimals' => 0
                        ],
                    ],
                ],
                'legend' => [
                    'layout' => 'horizontal',
                    'verticalAlign' => 'bottom',
                    'align' => 'center'
                ],
                'tooltip' => ['headerFormat' => '<b>Date : {point.key}</b><br/>',
                    'crosshairs' => true,
                    'shared' => true,
                    'stickOnContact' => true,
                ],
                'plotOptions' => [
                    'series' => [
                        'cursor' => 'pointer',
                        'lineWidth' => 2
                    ],
                ],
            ]
        ]);
        ?>
        <?=
        miloschuman\highcharts\Highcharts::widget([
            'scripts' => [
                'highcharts-more',
                'modules/exporting',
                'themes/grid',
            ],
            'htmlOptions' => ['id' => 'aa' . $models->id, 'style' => 'width:900px'],
            'options' => [
                'chart' => [
                    'type' => 'spline',
                    'height' => 300
                ],
                //'rangeSelector' => ['enabled' => false],
                'credits' => ['enabled' => false],
                'legend' => [
                    'enabled' => true,
                    //'layout' =>'vertical',
                    'align' => 'center',
                ],
                'exporting' => [
                    'buttons' => [
                        'contextButton' => [
                            'menuItems' => ['downloadPNG', 'downloadPDF']
                        ]
                    ]
                ],
                'title' => [
                    'text' => ' Last 6 Month Performance of BCs',
                ],
                'xAxis' => [
                    'categories' => array_values($bc_month_graph['category']),
                    'labels' => ['rotation' => -45]
                ],
                'series' => [
                    [
                        'type' => 'spline',
                        'name' => 'BC Transction',
                        'data' => $bc_month_graph['transaction'],
                        'dashStyle' => 'ShortDot',
                        'tootltip' => [
                            'valueDecimals' => 0
                        ],
                    ],
                ],
                'legend' => [
                    'layout' => 'horizontal',
                    'verticalAlign' => 'bottom',
                    'align' => 'center'
                ],
                'tooltip' => ['headerFormat' => '<b>Month : {point.key}</b><br/>',
                    'crosshairs' => true,
                    'shared' => true,
                    'stickOnContact' => true,
                ],
                'plotOptions' => [
                    'series' => [
                        'cursor' => 'pointer',
                        'lineWidth' => 2
                    ],
                ],
            ]
        ]);
        ?>
        <?php
//        miloschuman\highcharts\Highcharts::widget([
//            'scripts' => [
//                'highcharts-more',
//                'modules/exporting',
//                'themes/grid',
//            ],
//            'htmlOptions' => ['id' => 'a' . $models->id, 'style' => 'width:500px'],
//            'options' => [
//                'chart' => [
//                    'type' => 'spline',
//                    'height' => 220
//                ],
//                //'rangeSelector' => ['enabled' => false],
//                'credits' => ['enabled' => false],
//                'legend' => [
//                    'enabled' => true,
//                    //'layout' =>'vertical',
//                    'align' => 'center',
//                ],
//                'exporting' => [
//                    'buttons' => [
//                        'contextButton' => [
//                            'menuItems' => ['downloadPNG', 'downloadPDF']
//                        ]
//                    ]
//                ],
//                'title' => [
//                    'text' => $models->date_from . ' To ' . $models->date_to . ' Performance of BCs',
//                ],
//                'xAxis' => [
//                    'categories' => array_values($bc_graph['category']),
//                    'labels' => ['rotation' => -45]
//                ],
//                'series' => [
//                    [
//                        'type' => 'spline',
//                        'name' => 'BC Commission',
//                        'data' => $bc_graph['commission'],
//                        'dashStyle' => 'ShortDot',
//                        'tootltip' => [
//                            'valueDecimals' => 0
//                        ],
//                    ],
//                ],
//                'legend' => [
//                    'layout' => 'horizontal',
//                    'verticalAlign' => 'bottom',
//                    'align' => 'center'
//                ],
//                'tooltip' => ['headerFormat' => '<b>Date : {point.key}</b><br/>',
//                    'crosshairs' => true,
//                    'shared' => true,
//                    'stickOnContact' => true,
//                ],
//                'plotOptions' => [
//                    'series' => [
//                        'cursor' => 'pointer',
//                        'lineWidth' => 2
//                    ],
//                ],
//            ]
//        ]);
        ?>
        <?php
//        miloschuman\highcharts\Highcharts::widget([
//            'scripts' => [
//                'highcharts-more',
//                'modules/exporting',
//                'themes/grid',
//            ],
//            'htmlOptions' => ['id' => 'b' . $models->id, 'style' => 'width:500px'],
//            'options' => [
//                'chart' => [
//                    'type' => 'spline',
//                    'height' => 220
//                ],
//                //'rangeSelector' => ['enabled' => false],
//                'credits' => ['enabled' => false],
//                'legend' => [
//                    'enabled' => true,
//                    //'layout' =>'vertical',
//                    'align' => 'center',
//                ],
//                'exporting' => [
//                    'buttons' => [
//                        'contextButton' => [
//                            'menuItems' => ['downloadPNG', 'downloadPDF']
//                        ]
//                    ]
//                ],
//                'title' => [
//                    'text' => $models->date_from . ' To ' . $models->date_to . ' Performance of BCs',
//                ],
//                'xAxis' => [
//                    'categories' => array_values($bc_graph['category']),
//                    'labels' => ['rotation' => -45]
//                ],
//                'series' => [
//                    [
//                        'type' => 'spline',
//                        'name' => 'BC Txn Amount',
//                        'data' => $bc_graph['txn'],
//                        'dashStyle' => 'ShortDot',
//                        'tootltip' => [
//                            'valueDecimals' => 0
//                        ],
//                    ],
//                ],
//                'legend' => [
//                    'layout' => 'horizontal',
//                    'verticalAlign' => 'bottom',
//                    'align' => 'center'
//                ],
//                'tooltip' => ['headerFormat' => '<b>Date : {point.key}</b><br/>',
//                    'crosshairs' => true,
//                    'shared' => true,
//                    'stickOnContact' => true,
//                ],
//                'plotOptions' => [
//                    'series' => [
//                        'cursor' => 'pointer',
//                        'lineWidth' => 2
//                    ],
//                ],
//            ]
//        ]);
        ?>
    </div>
    <!--    <div class="col-lg-4">-->


    <?php
//        miloschuman\highcharts\Highcharts::widget([
//            'scripts' => [
//                'highcharts-more',
//                'modules/exporting',
//                'themes/grid',
//            ],
//            'htmlOptions' => ['id' => 'bb' . $models->id, 'style' => 'width:500px'],
//            'options' => [
//                'chart' => [
//                    'type' => 'spline',
//                    'height' => 220
//                ],
//                //'rangeSelector' => ['enabled' => false],
//                'credits' => ['enabled' => false],
//                'legend' => [
//                    'enabled' => true,
//                    //'layout' =>'vertical',
//                    'align' => 'center',
//                ],
//                'exporting' => [
//                    'buttons' => [
//                        'contextButton' => [
//                            'menuItems' => ['downloadPNG', 'downloadPDF']
//                        ]
//                    ]
//                ],
//                'title' => [
//                    'text' => ' Last three Month Performance of BCs',
//                ],
//                'xAxis' => [
//                    'categories' => array_values($bc_month_graph['category']),
//                    'labels' => ['rotation' => -45]
//                ],
//                'series' => [
//                    [
//                        'type' => 'spline',
//                        'name' => 'BC Commission',
//                        'data' => $bc_month_graph['commission'],
//                        'dashStyle' => 'ShortDot',
//                        'tootltip' => [
//                            'valueDecimals' => 0
//                        ],
//                    ],
//                ],
//                'legend' => [
//                    'layout' => 'horizontal',
//                    'verticalAlign' => 'bottom',
//                    'align' => 'center'
//                ],
//                'tooltip' => ['headerFormat' => '<b>Month : {point.key}</b><br/>',
//                    'crosshairs' => true,
//                    'shared' => true,
//                    'stickOnContact' => true,
//                ],
//                'plotOptions' => [
//                    'series' => [
//                        'cursor' => 'pointer',
//                        'lineWidth' => 2
//                    ],
//                ],
//            ]
//        ]);
    ?>
    <?php
//        miloschuman\highcharts\Highcharts::widget([
//            'scripts' => [
//                'highcharts-more',
//                'modules/exporting',
//                'themes/grid',
//            ],
//            'htmlOptions' => ['id' => 'cc' . $models->id, 'style' => 'width:500px'],
//            'options' => [
//                'chart' => [
//                    'type' => 'spline',
//                    'height' => 220
//                ],
//                //'rangeSelector' => ['enabled' => false],
//                'credits' => ['enabled' => false],
//                'legend' => [
//                    'enabled' => true,
//                    //'layout' =>'vertical',
//                    'align' => 'center',
//                ],
//                'exporting' => [
//                    'buttons' => [
//                        'contextButton' => [
//                            'menuItems' => ['downloadPNG', 'downloadPDF']
//                        ]
//                    ]
//                ],
//                'title' => [
//                    'text' => ' Last three Month Performance of BCs',
//                ],
//                'xAxis' => [
//                    'categories' => array_values($bc_month_graph['category']),
//                    'labels' => ['rotation' => -45]
//                ],
//                'series' => [
//                    [
//                        'type' => 'spline',
//                        'name' => 'BC Txn Amount',
//                        'data' => $bc_month_graph['txn'],
//                        'dashStyle' => 'ShortDot',
//                        'tootltip' => [
//                            'valueDecimals' => 0
//                        ],
//                    ],
//                ],
//                'legend' => [
//                    'layout' => 'horizontal',
//                    'verticalAlign' => 'bottom',
//                    'align' => 'center'
//                ],
//                'tooltip' => ['headerFormat' => '<b>Month : {point.key}</b><br/>',
//                    'crosshairs' => true,
//                    'shared' => true,
//                    'stickOnContact' => true,
//                ],
//                'plotOptions' => [
//                    'series' => [
//                        'cursor' => 'pointer',
//                        'lineWidth' => 2
//                    ],
//                ],
//            ]
//        ]);
    ?>
    <!--    </div>-->
    <div class="col-lg-5">
        <h3>Over All Performance of BCs</h3>
        <?=
        DetailView::widget([
            'model' => $models,
            'options' => ['id' => 'detail' . $models->id, 'style' => 'width:100%'],
            'template' => '<tr><th style="width:50%">{label}</th><td style="width:50%">{value}</td></tr>',
            'attributes' => [
                [
                    'attribute' => 'transaction_start_date',
                    'format' => 'raw',
                    'value' => $models->transaction_start_date,
                ],
                [
                    'attribute' => 'total_day',
                    'format' => 'raw',
                    'value' => $models->total_day,
                ],
                [
                    'attribute' => 'total_working_day',
                    'format' => 'raw',
                    'value' => $models->total_working_day,
                ],
                [
                    'attribute' => 'total_no_of_transaction',
                    'format' => 'html',
                    'value' => $models->total_no_of_transaction
                ],
                [
                    'attribute' => 'total_transaction_amount',
                    'format' => 'html',
                    'value' => $models->total_transaction_amount,
                ],
                [
                    'attribute' => 'total_commission_amount',
                    'format' => 'html',
                    'value' => $models->total_commission_amount,
                ],
                [
                    'attribute' => 'start_month_name',
                    'format' => 'html',
                    'value' => $models->start_month_name,
                ],
                [
                    'attribute' => 'last_month_name',
                    'format' => 'html',
                    'value' => $models->last_month_name,
                ],
            ],
        ])
        ?>
        <h3 style="margin-top: 10px">कार्य करने में प्रमुख रुकावट</h3>
        <?php if(isset($models->fb)){ ?>
        <table class="table" style="width:100%">
            <tr>

                <td><?= isset($models->fb->ques1html) ? $models->fb->ques1html : '' ?></td>
            </tr>  
            <tr>

                <td><?= isset($models->fb->ques2html) ? $models->fb->ques2html : '' ?></td>
            </tr>  
            <tr>

               <td><?= isset($models->fb->ques3html) ? $models->fb->ques3html : '' ?></td>
            </tr>  
            <tr>
               <td><?= isset($models->fb->ques4html) ? $models->fb->ques4html : '' ?></td>
            </tr> 
            <tr>
               <td><?= isset($models->fb->ques5html) ? $models->fb->ques5html : '' ?></td>
            </tr> 
        </table>
        <?php } ?>
    </div>   
</div> 
