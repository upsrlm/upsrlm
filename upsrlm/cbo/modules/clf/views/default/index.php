<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use cbo\models\CboClf;

$this->title = "CLF's";
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
                    <?php if (MasterRole::ROLE_BMMU == Yii::$app->user->identity->role) { ?>
                        <?= Html::a('Add CLF', ['create'], ['class' => 'btn btn-success']) ?>
                    <?php } ?>
                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
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
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'floatHeader' => true,
                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'id',
                                'contentOptions' => ['style' => 'width: 5%'],
                                'enableSorting' => false,
                                'contentOptions' => ['class' => 'info'],
                            ],
                            [
                                'attribute' => 'name_of_clf',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'nrlm_clf_code',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'block_name',
                                'label' => 'Block ',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'no_of_vo_connected',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'no_of_shg_connected',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'no_of_gps_covered',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'date_of_formation',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                            ],
//                    [
//                        'attribute' => 'funds_received_so_far',
//                        'contentOptions' => ['style' => 'width: 8%'],
//                        'enableSorting' => false,
//                    ],
                            [
                                'attribute' => 'total_amount_received',
                                'label' => 'Total amount received',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getFunds()->sum('total_amount_received') != null ? common\helpers\Utility::numberIndiaStyle($model->getFunds()->sum('total_amount_received')) : '';
                                }
                            ],
                            [
                                'attribute' => 'total_amount_received',
                                'label' => "CLFs' updated balance in Bank",
                                'contentOptions' => ['style' => 'width: 8%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->updated_balance_in_bank != null ? common\helpers\Utility::numberIndiaStyle($model->updated_balance_in_bank + $model->updated_balance_in_bank2) : '';
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'contentOptions' => ['style' => 'width: 5%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->clfstatus;
                                }
                            ],
                            [
                                'attribute' => 'created_by',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->entryby) ? $model->entryby->name . " (" . $model->entryby->mobile_no . ")" : '';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM]),
                                'template' => '{update}{view}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return (($model->status == CboClf::STATUS_SAVE and $model->created_by == Yii::$app->user->identity->id) || in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) ? Html::a('<span class="fal fa-pencil"></span>', ['update?clfid=' . $model->id], [
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-sm btn-primary ',
                                        ]) : '';
                                    },
                                    'view' => function ($url, $model) {
                                        return ' ' . Html::a('<span class="fal fa-eye "></span>', ['/clf/view?clfid=' . $model->id], [
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-sm btn-primary mt-2',
                                        ]);
                                    },
                                ]
                            ],
                            [
                                'attribute' => 'Action',
                                'format' => 'raw',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                'contentOptions' => ['style' => 'width: 5%'],
                                'value' => function ($model) {

                                    $html = '<span id="' . $model->id . '">';
                                    if ($model->verify_bank_passbook == 0 && $model->status == 2) {
                                        $html .= yii\helpers\Html::button('<i class="fal fa-thumb-up"></i> Return', ['id' => 'take-verify-' . $model->id, 'class' => 'btn btn-sm btn-warning btn-block popb', 'value' => '/clf/default/verify?clfid=' . $model->id, 'name' => 'takeaction', 'title' => 'Return']);
                                    }
                                    $html .= "</span>";
                                    $html .= Html::a('<span class="fal fa-trash"></span>', ['/clf/default/remove?clfid=' . $model->id], [
                                                'class' => '',
                                                'data-pjax' => "0",
                                                'class' => 'btn btn-sm btn-danger',
                                                'data' => [
                                                    'confirm' => 'Are you absolutely sure remove this CLF? this action not undon',
                                                    'method' => 'post',
                                                ],
                                    ]);
                                    return $html;
                                }
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