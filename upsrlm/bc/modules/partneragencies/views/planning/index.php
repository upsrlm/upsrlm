<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Planning for field operationalising";
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
                        'beforeHeader' => [
                            [
                                'columns' => [
                                    ['content' => '', 'options' => ['colspan' => 10, 'class' => 'text-center warning']],
                                    ['content' => 'Planning for '.date('M'), 'options' => ['colspan' => 4, 'class' => 'text-center bg-white']],
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center warning']],
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center warning']],
                                ],
                            ]
                        ],
                        'afterHeader' => [
                            [
                                'columns' => [
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center bg-warning-100']],
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center bg-warning-100']],
                                    ['content' => 'Total', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => bc\models\PartnerBankDistrictPlanning::getTotal($dataProvider->models, 'preselected'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => bc\models\PartnerBankDistrictPlanning::getTotal($dataProvider->models, 'certified'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => bc\models\PartnerBankDistrictPlanning::getTotal($dataProvider->models, 'pvr'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => bc\models\PartnerBankDistrictPlanning::getTotal($dataProvider->models, 'supportfund'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => bc\models\PartnerBankDistrictPlanning::getTotal($dataProvider->models, 'onboard'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => bc\models\PartnerBankDistrictPlanning::getTotal($dataProvider->models, 'pan_ava'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => bc\models\PartnerBankDistrictPlanning::getTotal($dataProvider->models, 'handheld_machine'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => bc\models\PartnerBankDistrictPlanning::getTotal($dataProvider->models, 'onboarding'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => bc\models\PartnerBankDistrictPlanning::getTotal($dataProvider->models, 'acopening'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => bc\models\PartnerBankDistrictPlanning::getTotal($dataProvider->models, 'supplyequipment'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => bc\models\PartnerBankDistrictPlanning::getTotal($dataProvider->models, 'operational'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center bg-warning-100']],
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center bg-warning-100']],
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
                                    return isset($model->district) ? $model->district->district_name : '';
                                }
                            ],
                            [
                                'attribute' => 'Partner Bank/FI',
                                'label' => 'Partner Bank/FI',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->partnerbank) ? $model->partnerbank->bank_name : '';
                                },
                                'pageSummary' => 'Total',
                            ],        
                            [
                                'attribute' => 'BCs preselected',
                                'label' => 'BCs preselected ',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getSbc()->count();
                                },
                                'pageSummary' => true,        
                            ],
                            [
                                'attribute' => 'BCs certified',
                                'label' => 'BCs certified ',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getRbc()->andWhere(['rsetis_batch_participants.training_status' => [3, 7]])->count();
                                },
                               'pageSummary' => true,           
                            ],
                            [
                                'attribute' => 'BCs with PVR',
                                'label' => 'BCs with PVR',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getRbc()->andWhere(['srlm_bc_application.pvr_status' => 1])->count();
                                },
                               'pageSummary' => true,           
                            ],
                            [
                                'attribute' => 'BC-support fund provided',
                                'label' => 'BC-support fund provided',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getRbc()->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1])->count();
                                },
                               'pageSummary' => true,           
                            ],
                            [
                                'attribute' => 'BCs onboard',
                                'label' => 'BCs onboard',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getRbc()->andWhere(['srlm_bc_application.onboarding' => 1])->count();
                                },
                               'pageSummary' => true,           
                            ],
                            [
                                'attribute' => 'PAN card available',
                                'header' => 'PAN card available',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getRbc()->andWhere(['srlm_bc_application.pan_card_status' => 1])->count();
                                },
                               'pageSummary' => true,           
                            ],
                            [
                                'attribute' => 'Handheld Machine provided',
                                'label' => 'Handheld Machine provided',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getRbc()->andWhere(['srlm_bc_application.handheld_machine_status' => 1])->count();
                                },
                               'pageSummary' => true,           
                            ],
                            [
                                'attribute' => 'Onboarding',
                                'label' => 'Onboarding',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->onboarding) ? $model->onboarding : '';
                                },
                                'pageSummary' => true,          
                            ],
                            [
                                'attribute' => 'A/c opening',
                                'label' => 'A/c opening',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->acopening) ? $model->acopening : '';
                                },
                               'pageSummary' => true,           
                            ],
                            [
                                'attribute' => 'Supply equipment',
                                'label' => 'Supply equipment',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->supplyequipment) ? $model->supplyequipment : '';
                                },
                               'pageSummary' => true,           
                            ],
                            [
                                'attribute' => 'Operational',
                                'label' => 'Operational',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->operational) ? $model->operational : '';
                                    //return $model->operational;
                                },
                               'pageSummary' => true,           
                            ],
                            [
                                'class' => 'kartik\grid\ExpandRowColumn',
                                'width' => '50px',
                                
                                'value' => function ($model, $key, $index, $column) {
                                    return GridView::ROW_COLLAPSED;
                                },
                                'detail' => function ($model, $key, $index, $column) {
                                    return Yii::$app->controller->renderPartial('weekly_planning', ['model' => $model]);
                                },
                                //'headerOptions' => ['class' => 'kartik-sheet-style'],
                                'expandOneOnly' => true,
                                'contentOptions' => ['style' => 'width: 8%'],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS]),
                                'template' => '{verification}',
                                'buttons' => [
                                    'verification' => function ($url, $model) {

                                        $html = '';

                                        $html .= Html::button('<span class="">Plan</span>', [
                                                    'data-pjax' => "0",
                                                    'class' => 'btn  btn-info popb',
                                                    'value' => '/partneragencies/planning/weekly?id=' . $model->id,
                                                    'title' => 'Plan for ' . $model->district->district_name.' '.date('M').' Month'
                                        ]);

                                        return $html;
                                    },
                                ]
                            ],
                        ],
                    ]);
                    ?>

                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
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