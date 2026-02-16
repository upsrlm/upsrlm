<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\models\DistrictPerformanceBcsakhiProgram;
use kartik\popover\PopoverX;

//PopoverX::widget([
//    'bsVersion' => '4.x',
//    'header' => '',
//    'placement' => PopoverX::ALIGN_LEFT,
//    'content' => '',
//    'toggleButton' => ['label' => 'Left', 'class' => 'btn btn-default btn-outline-secondary'],
//]);
$this->title = "Performance BC Sakhi Program";
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
                        'clientOptions' => ['method' => 'POST'],
                    ]);
                    ?>
                    <?php
                    $form = ActiveForm::begin([
                        'options' => [
                            'class' => 'form-inline',
                            'data-pjax' => true,
                            'id' => 'Searchform'
                        ],
                        'id' => 'Searchform',
                        'layout' => 'inline',
                        'method' => 'POST',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_searchdistrict', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <div class="mb-3"></div>
                    <div class="col-lg-12" ">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "{items}",
                            'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                            'id' => 'grid-data',
                            'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                            'pjax' => TRUE,
                            'beforeHeader' => true ? [
                                [
                                    'columns' => [
                                        ['content' => '#', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold text-center']],
                                        ['content' => 'District', 'options' => ['colspan' => 3, 'class' => 'font-weight-bold text-center']],
                                        ['content' => 'RSETI' , 'options' => ['colspan' => 4, 'class' => 'font-weight-bold text-center','style'=>'background-color:#8dd873']],
                                        ['content' => 'UPSRLM', 'options' => ['colspan' => 4, 'class' => 'font-weight-bold  text-center','style'=>'background-color:#60caf3']],
                                        ['content' => 'Partner Agency', 'options' => ['colspan' => 4, 'class' => 'font-weight-bold text-center','style'=>'background-color:#747474']],
                                        ['content' => 'Partner Agency', 'options' => ['colspan' => 4, 'class' => 'font-weight-bold text-center','style'=>'background-color:#f1a983']],
                                    ],
                                ]
                                    ] : '',
                            'afterHeader' => true ? [
                                [
                                    'columns' => [
                                        ['content' => '', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold ']],
                                        ['content' => '', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold']],
                                        ['content' => '', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold']],
                                        ['content' => '', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'per_certified_bc', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold','style'=>'background-color:#def9d7']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'certified_bc_rating', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold','style'=>'background-color:#def9d7']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'per_certified_bc_unwilling', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold','style'=>'background-color:#def9d7']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'certified_bc_unwilling_rating', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold','style'=>'background-color:#def9d7']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'upsrlm_payment_of_bc_support_fund_per', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold','style'=>'background-color:#caedfb']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'upsrlm_payment_of_bc_support_fund_rating', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold','style'=>'background-color:#caedfb']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'upsrlm_payment_of_bc_honorarium_per', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold','style'=>'background-color:#caedfb']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'upsrlm_payment_of_bc_honorarium_rating', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold','style'=>'background-color:#caedfb']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'partner_agency_avg_no_of_working_days', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold','style'=>'background-color:#d1d1d1']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'partner_agency_avg_no_of_working_days_rating', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold','style'=>'background-color:#d1d1d1']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'partner_agency_avg_no_of_txn', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold','style'=>'background-color:#d1d1d1']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'partner_agency_avg_no_of_txn_rating', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold','style'=>'background-color:#d1d1d1']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'partner_agency_avg_com_earning', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-50']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'partner_agency_avg_com_earning_rating', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-50']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'repayment_of_support_fund_per', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-50']],
                                        ['content' => DistrictPerformanceBcsakhiProgram::getTotal($dataProvider, 'repayment_of_support_fund_rating', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-50']],
                                    ],
                                ]
                                    ] : '',
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                ],
                                [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'allowBatchToggle' => false,
                                    'width' => '50px',
                                    'value' => function ($model, $key, $index, $column) {
                                        return GridView::ROW_COLLAPSED;
                                    },
                                    'detail' => function ($model, $key, $index, $column) {
                                        // You can return a view, widget, or any custom HTML
                                        return \Yii::$app->controller->renderPartial('detail', ['model' => $model]);
                                    },
                                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                                    'expandOneOnly' => true,
                                    'expandIcon' => '<span class="fal fa fa-caret-right glyphicon glyphicon-triangle-right"></span>',
                                    'collapseIcon' => '<span class="fal fa fa-chevron-down glyphicon glyphicon-triangle-bottom"></span>',
                                    'detailRowCssClass' => 'table'
                                ],
                                [
                                    'attribute' => 'district_name',
                                    'header' => 'District',
                                    'enableSorting' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->district_name;
                                    },
                                ],
                                [
                                    'attribute' => 'composite_rank',
                                    'header' => 'Composite Rank',
                                    'enableSorting' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->composite_rank;
                                    },
                                ],            
                                [
                                    'attribute' => 'per_certified_bc',
                                    'header' => '% of certified BCs',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => '% of certified BCs','style'=>'background-color:#def9d7'],
                                    'headerOptions' => ['style' => 'background-color: #def9d7;'],
                                    'value' => function ($model) {
                                        return $model->per_certified_bc;
                                    }
                                ],
                                [
                                    'attribute' => 'certified_bc_rating',
                                    'header' => 'Rating',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => 'Rating','style'=>'background-color:#def9d7'],
                                    'headerOptions' => ['style' => 'background-color: #def9d7;'],
                                    'value' => function ($model) {
                                        return $model->certified_bc_rating;
                                    }
                                ],
                                [
                                    'attribute' => 'per_certified_bc_unwilling',
                                    'header' => '% of certified BC unwilling',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => '% of certified BC unwilling','style'=>'background-color:#def9d7'],
                                    'headerOptions' => ['style' => 'background-color: #def9d7;'],
                                    'value' => function ($model) {
                                        return $model->per_certified_bc_unwilling;
                                    }
                                ],
                                [
                                    'attribute' => 'certified_bc_unwilling_rating',
                                    'header' => 'Rating',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => 'Rating','style'=>'background-color:#def9d7'],
                                    'headerOptions' => ['style' => 'background-color: #def9d7;'],
                                    'value' => function ($model) {
                                        return $model->certified_bc_unwilling_rating;
                                    }
                                ],
                                [
                                    'attribute' => 'upsrlm_payment_of_bc_support_fund_per',
                                    'header' => '% of Payment of BC support fund',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => '% of Payment of BC support fund','style'=>'background-color:#caedfb'],
                                    'headerOptions' => ['style' => 'background-color: #caedfb;'],
                                    'value' => function ($model) {
                                        return $model->upsrlm_payment_of_bc_support_fund_per;
                                    }
                                ],
                                [
                                    'attribute' => 'upsrlm_payment_of_bc_support_fund_rating',
                                    'header' => 'Rating',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => 'Rating','style'=>'background-color:#caedfb'],
                                    'headerOptions' => ['style' => 'background-color: #caedfb;'],
                                    'value' => function ($model) {
                                        return $model->upsrlm_payment_of_bc_support_fund_rating;
                                    }
                                ],
                                [
                                    'attribute' => 'upsrlm_payment_of_bc_honorarium_per',
                                    'header' => '% of Payment of BC honorarium',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => '% of Payment of BC honorarium','style'=>'background-color:#caedfb'],
                                    'headerOptions' => ['style' => 'background-color: #caedfb;'],
                                    'value' => function ($model) {
                                        return $model->upsrlm_payment_of_bc_honorarium_per;
                                    }
                                ],
                                [
                                    'attribute' => 'upsrlm_payment_of_bc_honorarium_rating',
                                    'header' => 'Rating',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => 'Rating','style'=>'background-color:#caedfb'],
                                    'headerOptions' => ['style' => 'background-color: #caedfb;'],
                                    'value' => function ($model) {
                                        return $model->upsrlm_payment_of_bc_honorarium_rating;
                                    }
                                ],
                                [
                                    'attribute' => 'partner_agency_avg_no_of_working_days',
                                    'header' => 'Ave. no. working days/ month (Last 3 months)',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => 'Ave. no. working days/ month (Last 3 months)','style'=>'background-color:#d1d1d1'],
                                    'headerOptions' => ['style' => 'background-color: #d1d1d1;'],
                                    'value' => function ($model) {
                                        return $model->partner_agency_avg_no_of_working_days;
                                    }
                                ],
                                [
                                    'attribute' => 'partner_agency_avg_no_of_working_days_rating',
                                    'header' => 'Rating',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => 'Rating','style'=>'background-color:#d1d1d1'],
                                    'headerOptions' => ['style' => 'background-color: #d1d1d1;'],
                                    'value' => function ($model) {
                                        $rating = 0;
                                        if ($model->partner_agency_avg_no_of_working_days > 25) {
                                            $rating = 10;
                                        } elseif ($model->partner_agency_avg_no_of_working_days > 15 and $model->partner_agency_avg_no_of_working_days < 26) {
                                            $rating = 5;
                                        } else {
                                            $rating = 0;
                                        }
                                        return $model->partner_agency_avg_no_of_working_days_rating;
                                    }
                                ],
                                [
                                    'attribute' => 'partner_agency_avg_no_of_txn',
                                    'header' => 'Ave. no. of txn./ month (Last 3 months)',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => 'Ave. no. of txn./ month (Last 3 months)','style'=>'background-color:#d1d1d1'],
                                    'headerOptions' => ['style' => 'background-color: #d1d1d1;'],
                                    'value' => function ($model) {
                                        return $model->partner_agency_avg_no_of_txn;
                                    }
                                ],
                                [
                                    'attribute' => 'partner_agency_avg_no_of_txn_rating',
                                    'header' => 'Rating',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => 'Rating','style'=>'background-color:#d1d1d1'],
                                    'headerOptions' => ['style' => 'background-color: #d1d1d1;'],
                                    'value' => function ($model) {
                                        $rating = 0;
                                        if ($model->partner_agency_avg_no_of_txn > 100) {
                                            $rating = 10;
                                        } elseif ($model->partner_agency_avg_no_of_txn > 49 and $model->partner_agency_avg_no_of_txn < 101) {
                                            $rating = 5;
                                        } else {
                                            $rating = 0;
                                        }
                                        return $model->partner_agency_avg_no_of_txn_rating;
                                    }
                                ],
                                [
                                    'attribute' => 'partner_agency_avg_com_earning',
                                    'header' => 'Ave. commission earning/ month (Last 3 months)',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => 'Ave. commission earning/ month (Last 3 months)', 'style' => 'background-color:#fae2d5'],
                                    'headerOptions' => ['style' => 'background-color: #fae2d5;'],
                                    'value' => function ($model) {
                                        return $model->partner_agency_avg_com_earning;
                                    }
                                ],
                                [
                                    'attribute' => 'partner_agency_avg_no_of_txn_amount_rating',
                                    'header' => 'Rating ',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => 'Rating', 'style' => 'background-color:#fae2d5'],
                                    'headerOptions' => ['style' => 'background-color: #fae2d5;'],
                                    'value' => function ($model) {
                                        $rating = 0;
                                        if ($model->partner_agency_avg_com_earning > 25000) {
                                            $rating = 50;
                                        } elseif ($model->partner_agency_avg_com_earning > 9999 and $model->partner_agency_avg_com_earning < 25000) {
                                            $rating = 25;
                                        } else {
                                            $rating = 0;
                                        }
                                        return $model->partner_agency_avg_com_earning_rating;
                                    }
                                ],
                                [
                                    'attribute' => 'repayment_of_support_fund_per',
                                    'header' => 'Repayment of BC Support fund',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => 'Repayment of BC Support fund', 'style' => 'background-color:#fae2d5'],
                                    'headerOptions' => ['style' => 'background-color: #fae2d5;'],
                                    'value' => function ($model) {
                                        return $model->repayment_of_support_fund_per;
                                    }
                                ],
                                [
                                    'attribute' => 'repayment_of_support_fund_rating',
                                    'header' => 'Rating ',
                                    'format' => 'raw',
                                    'contentOptions' => ['data-title' => 'Rating', 'style' => 'background-color:#fae2d5'],
                                    'headerOptions' => ['style' => 'background-color: #fae2d5;'],
                                    'value' => function ($model) {
                                       
                                        return $model->repayment_of_support_fund_rating;
                                    }
                                ],         
                            ],
                        ]);
                        ?>    
                    </div> 
                    <?php ActiveForm::end(); ?>
                    <?php
                    $js = <<< JS
$(document).on('ready pjax:success', function() {
        function updateURLParameter(url, param, paramVal)
        {
        var TheAnchor = null;
        var newAdditionalURL = "";
        var tempArray = url.split("?");
        var baseURL = tempArray[0];
        var additionalURL = tempArray[1];
        var temp ="";                       
                                                              
        if (additionalURL)                                    
        {                                                     
            var tmpAnchor = additionalURL.split("#");         
            var TheParams = tmpAnchor[0];                     
            TheAnchor = tmpAnchor[1];                         
            if(TheAnchor)                                     
                additionalURL = TheParams;                    
                                                              
            tempArray = additionalURL.split("&");             
                                                              
            for (var i=0; i<tempArray.length; i++)            
            {                                                 
                if(tempArray[i].split('=')[0] != param)       
                {                                             
                    newAdditionalURL += temp + tempArray[i];  
                    temp = "&";                               
                }                                             
            }                                                 
        }                                                     
        else                                                  
        {                                                     
            var tmpAnchor = baseURL.split("#");               
            var TheParams = tmpAnchor[0];                     
            TheAnchor  = tmpAnchor[1];                        
                                                              
            if(TheParams)
                baseURL = TheParams;     
        }                                                                      
                                                                               
        if(TheAnchor)                                                          
            paramVal += "#" + TheAnchor;                                       
                                                                               
        var rows_txt = temp + "" + param + "=" + paramVal;                     
        return baseURL + "?" + newAdditionalURL + rows_txt;                    
    }

    $('.pagination li a').click(function(event){
            event.preventDefault(); 
            var page = $(this).data('page') + 1;
            var href = updateURLParameter(this.href, 'page', page); 
            $('#Searchform').prop('action', href);
            $('#Searchform').submit();
        });  
});
JS;
                    $this->registerJs($js)
                    ?>
    <?php 
    $this->registerCss('.kv-expand-header-icon .kv-state-expanded { display: none !important; }');

    ?>                
                    <?php
                    Modal::begin([
                        'title' => '<h4>Popup Title</h4>',
                        'id' => 'modal',
                        'size' => Modal::SIZE_LARGE,
                    ]);

                    echo "<div id='modalContent'></div>";

                    Modal::end();
                    ?>          
                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div> 
    </div>
</div>



