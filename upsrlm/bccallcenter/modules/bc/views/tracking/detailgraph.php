<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\Highstock;
use kartik\widgets\StarRating;

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
                                        'rangeSelector' => ['enabled' => false],
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
                                            'text' => 'Date Wise Activites',
                                        ],
                                        'series' => [
                                            [
                                                'name' => 'BC Transction',
                                                'data' => $bc_trans,
                                                'tootltip' => [
                                                    'valueDecimals' => 0
                                                ],
                                            ],
                                            [
                                                'name' => 'BC Commition',
                                                'data' => $bc_com,
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
        <?php
        $js = <<<JS
   $(document).on("click", "#btnPrint", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $("#printcontaineer").printThis({
            debug: false, 
            importCSS: true, 
            importStyle: true, 
            printContainer: true,  
            pageTitle: "", 
            removeInline: false, 
            printDelay: 333, 
            header: null, 
            formValues: true 
        });
     });   
JS;
        $this->registerJs($js);
        ?>
       
    </div>         
</div> 