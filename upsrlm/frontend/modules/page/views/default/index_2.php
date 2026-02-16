<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use miloschuman\highcharts\Highcharts;

$this->title = 'Dashboard';
$this->params['icon'] = 'fa fa-dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="about_home">
    <div class="container">
        <div class="row">
            <?php
            Pjax::begin([
                'id' => 'grid-data',
                'enablePushState' => FALSE,
                'enableReplaceState' => FALSE,
                'timeout' => false,
            ]);
            ?>

            <?php
            echo Highcharts::widget([
                'scripts' => [
                    'highcharts-more',
                    'modules/exporting',
                    'themes/grid',
                ],
                'options' => [
                    'exporting' => [
                        'buttons' => [
                            'contextButton' => [
                                'menuItems' => ['downloadPNG', 'downloadPDF']
                            ]
                        ]
                    ],
                    'title' => ['text' => "Monthly"],
                    'xAxis' => [
                        'categories' => yii\helpers\ArrayHelper::getColumn($report, 'month'),
                        'labels' => ['rotation' => -45]
                    ],
                    'plotOptions' => [
                        'column' => [
                            'pointPadding' => 0.4,
                            'borderWidth' => 0,
                            'dataLabels' => [
                                'enabled' => true,
                            ]
                        ],
                    ],
                    'legend' => [
                        'enabled' => false
                    ],
                    'yAxis' => [
                        'title' => ['text' => '']
                    ],
                    'series' => [['name' => 'Trained and certified', 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'trained_certified'))))], ['name' => 'Operational', 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'operational'))))]],
                    'legend' => [
                        'layout' => 'horizontal',
                        'verticalAlign' => 'bottom',
                        'align' => 'center'
                    ],
                    'tooltip' => ['headerFormat' => '<b>Date : {point.key}</b><br/>',
                        'crosshairs' => true,
                        'shared' => true,
                    ],
                    'dataLabels' => [
                        'enabled' > true,
                        'rotation' => -90,
                        'align' => 'right',
                        'format' => '{point.y:.1f}', // one decimal
                        'y' => 1000, // 10 pixels down from the top
                    ],
                    'credits' => [
                        'enabled' => false,
                    ],
                ]
            ]);
            ?>
        </div> 



        <?php Pjax::end() ?>
    </div> 
</section>