<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\Highstock;
use kartik\widgets\StarRating;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MasterCounsellorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bank Of Baroda Performance';
$this->params['icon'] = 'fa fa-dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-default-index">
    <div class="card-box">
       
        <div class="row-fluid">
            <div class="col-md-12">
               
                <div class="box box-danger">
                    <div class="box-body">

                        <div class="row-fluid padding-bottom-10">
                            <div style="overflow: auto;overflow-y: hidden;width:100%">
                                <?=
                                Highstock::widget([
                                    'scripts' => [
                                        'highcharts-more',
                                        'modules/exporting',
                                        'themes/grid',
                                    ],
                                    'options' => [
                                        'rangeSelector' => ['enabled' => true],
                                        'credits' => ['enabled' => false],
                                        'legend' => [
                                            'enabled' => true,
                                            //'layout' =>'vertical',
                                            'align' => 'center',
//                                        'verticalAlign'=> 'top',
                                        //'floating'=> true,
                                        //'backgroundColor'=> '#FFFFFF'
                                        ],
                                        'exporting' => [
                                            'buttons' => [
                                                'contextButton' => [
                                                    'menuItems' => ['downloadPNG', 'downloadPDF']
                                                ]
                                            ]
                                        ],
//                                    'rangeSelector' => [
//                                        'selected' => 1,
//                                    ],
                                        'title' => [
                                            'text' => 'Bank Of Baroda',
                                        ],
                                        'series' => [
                                            [
                                                'name' => 'Certified BC',
                                                'data' => $bc_certified,
                                                'tootltip' => [
                                                    'valueDecimals' => 0
                                                ],
                                            ],
                                            [
                                                'name' => 'Support Fund Transafer',
                                                'data' => $bc_fund,
                                                'tootltip' => [
                                                    'valueDecimals' => 0
                                                ],
                                            ],
                                            [
                                                'name' => 'Handheld Machine',
                                                'data' => $bc_handheldmachine,
                                                'tootltip' => [
                                                    'valueDecimals' => 0
                                                ],
                                            ],
                                            
                                            [
                                                'name' => 'BC operational',
                                                'data' => $bc_op,
                                                'tootltip' => [
                                                    'valueDecimals' => 0
                                                ],
                                            ],
                                             
                                        ],
                                    ]
                                ]);
                                ?>
                            </div>  
                        </div>

                    </div>
                </div>
                 
            </div>
        </div>
       
       
    </div>         
</div> 