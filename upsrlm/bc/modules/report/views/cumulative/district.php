<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\models\BcCumulativeReportDistrict;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Cumulative district report";
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
                    ]);
                    ?>


                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    <div class="clearfix"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed '],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'showPageSummary' => true,
//                        'beforeHeader' => [
//                            [
//                                'columns' => [
//                                    ['content' => '', 'options' => ['colspan' => 10, 'class' => 'text-center warning']],
//                                    ['content' => 'Planning', 'options' => ['colspan' => 4, 'class' => 'text-center bg-white']],
//                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center warning']],
//                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center warning']],
//                                ],
//                            ]
//                        ],
                        'afterHeader' => [
                            [
                                'columns' => [
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center bg-warning-100']],
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center bg-warning-100']],
                                    ['content' => 'Total', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'no_of_bc_shortlisted'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'no_of_gp'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'no_of_unwilling'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'certified_bc'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'onboard_bc'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'pvr'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'shg_assigned'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_shg_bank_verified'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'pfms_mapping'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_support_fund_shg_transfer'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_support_fund_shg_acknowledge'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'handheld_machine_provided'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'handheld_machine_acknowledge'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_bank_transaction_count'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                ],
                            ]
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%', 'class' => 'text-center']],
                            [
                                'attribute' => 'district_code',
                                'label' => 'District',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district_name;
                                }
                            ],
                            [
                                'attribute' => 'Partner Bank/FI',
                                'label' => 'Partner Bank/FI',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->partner_bank_name) ? $model->partner_bank_name : '';
                                },
                                'pageSummary' => 'Total',
                            ],
                            [
                                'attribute' => 'no_of_bc_shortlisted',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->no_of_bc_shortlisted;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'no_of_gp',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->no_of_gp;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'no_of_unwilling',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->no_of_unwilling;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'certified_bc',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->certified_bc;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'onboard_bc',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->onboard_bc;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'pvr',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->pvr;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'shg_assigned',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg_assigned;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'bc_shg_bank_verified',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bc_shg_bank_verified;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'pfms_mapping',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->pfms_mapping;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'bc_support_fund_shg_transfer',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bc_support_fund_shg_transfer;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'bc_support_fund_shg_acknowledge',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bc_support_fund_shg_acknowledge;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'handheld_machine_provided',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->handheld_machine_provided;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'handheld_machine_acknowledge',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->handheld_machine_acknowledge;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'bc_bank_transaction',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bc_bank_transaction;
                                },
                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'bc_bank_transaction_count',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bc_bank_transaction_count;
                                },
                                'pageSummary' => true,
                            ],
                        ],
                    ]);
                    ?>
                    <?php
            $js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/report/cumulative/ddownload"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });      
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/report/cumulative/district"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

            $this->registerJs($js);
            ?>     
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
     $("#Searchform").attr({ "action":"/report/cumulative/district"});
    $("#Searchform").attr("data-pjax", "True");                               
    $(this).closest('form').submit();
});            
    var loader = $(".ajax");
    $(document).on({
        ajaxStart: function () {
            loader.addClass("loader");
        },
        ajaxStop: function () {
            loader.removeClass("loader");
        }
    });
JS;
                    $this->registerJs($script);
                    ?>
                    <?php
                    $js = <<<JS
$(function () {
         
    $('.popb').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right ml-auto float-right" data-dismiss="modal" style="cursor : pointer;color:red;float:right"></i>';         
        });
});  
        
JS;
                    $this->registerJs($js);
                    ?> 
                    <?php
                    Modal::begin([
                        'headerOptions' => ['id' => 'modalHeader'],
                        'id' => 'modal',
                        'size' => 'modal-xl',
//    'options' => ['data-backdrop' => 'true',],
                        'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
                        ],
                    ]);
                    echo "<div id='imagecontent'></div>";
                    Modal::end();
                    ?>           
                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div> 
    </div>
</div>
<?php
$this->registerJs(
        '
function init_click_handlers(){

  $(".popb").click(function(e) {
            var fID = $(this).closest("tr").data("key");
            $("#modal").modal("show")
         .find("#imagecontent")
         .load($(this).attr("value"));
        });
       

}

init_click_handlers(); //first run
$("#grid-data").on("pjax:success", function() {
  init_click_handlers(); //reactivate links in grid after pjax update
});

');
?>