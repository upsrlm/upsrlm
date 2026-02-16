<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use cbo\models\CboVo;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "VO's Urban";
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
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed '],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
//                        'pjax' => TRUE,
//                        'floatHeader' => true,
//                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'rowOptions' => function ($model) {

                            if ($model->verification_status == '1') {
                                return ['class' => 'color-success-800'];
                            } elseif ($model->verification_status == '2') {
                                return ['class' => 'color-warning-700'];
                            } else {
                                return ['class' => ''];
                            }
                        },
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'id',
                                'contentOptions' => ['style' => 'width: 5%'],
                                'enableSorting' => false,
                                'contentOptions' => ['class' => 'info'],
                            ],
                            [
                                'attribute' => 'name_of_vo',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'nrlm_vo_code',
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
                                'attribute' => 'gram_panchayat_name',
                                'label' => 'Gram Panchayat ',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'date_of_formation',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'no_of_shg_connected',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'no_of_members',
                                'label' => 'No of members',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getMembers()->count();
                                }
                            ],
                            [
                                'attribute' => 'no_of_shg_assigned',
                                'label' => 'No of SHG Assigned',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getShg()->count();
                                }
                            ],
                            [
                                'attribute' => 'total_amount_received',
                                'label' => 'total amount received',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getFunds()->sum('total_amount_received') != null ? $model->getFunds()->sum('total_amount_received') : '';
                                }
                            ],
                            [
                                'attribute' => 'total_amount_received',
                                'label' => 'VOs updated balance in Bank',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getFunds()->sum('balance_as_on_date') != null ? $model->getFunds()->sum('balance_as_on_date') : '';
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'contentOptions' => ['style' => 'width: 5%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->vostatus;
                                }
                            ],
                            [
                                'attribute' => 'created_by',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'format' => 'html',
                                'visible' => isset(Yii::$app->user->identity->role) and !in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL]),
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->entryby) ? $model->entryby->name . " (" . $model->entryby->mobile_no . ")" : '';
                                }
                            ],
//                                                       [
//                                'class' => 'yii\grid\ActionColumn',
//                                'header' => 'Samuh Sakhi',
//                                'visible' => 0,//,isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_YOUNG_PROFESSIONAL]),
//                                'template' => '{verifysamuhsakhi}',
//                                'buttons' => [
//                                    'verifysamuhsakhi' => function ($url, $model) {
//                                        $html = '';
//                                        if ($model->samuh_sakhi_name != null) {
//                                            $html .= $model->samuh_sakhi_name . "<br/>" . $model->samuh_sakhi_mobile_no . "<br/>";
//                                            $html .=$model->mobiletype != null ? $model->mobiletype->name_hi. "<br/>" : '';
//                                            if ($model->samuh_sakhi_cbo_shg_id and $model->verification_status_samuh_sakhi == 0 and $model->getSamuhsakirole() == 0 and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
//                                                $html .= yii\helpers\Html::button('<i class="fa fa-task"></i>Verify Samuh Sakhi', ['id' => 'verify-samuh-sakhi-action-' . $model->id, 'class' => 'btn  btn-info popb', 'value' => '/vo/default/verifysamuhsakhi?void=' . $model->id, 'name' => 'takeaction', 'data-pjax' => "0", 'title' => 'Verify Samuh Sakhi']);
//                                            }
//                                        }
//                                        return $html;
//                                    },
//                                ]
//                            ],         
//                            [
//                                'attribute' => 'Action',
//                                'format' => 'raw',
//                                'visible' => isset(Yii::$app->user->identity->role) and (MasterRole::ROLE_DMMU == Yii::$app->user->identity->role),
//                                'contentOptions' => ['style' => 'width: 5%'],
//                                'value' => function ($model) {
//
//                                    $html = '<span id="' . $model->id . '">';
//                                    if ($model->verification_status != 1) {
////                                    $html.=Html::a('<i class="fal fa-thumb-up"></i> Verify', ['/vo/default/verify?void=' . $model->id], [
////                                            'data-pjax' => "0",
////                                            'class' => 'btn btn-sm btn-warning',
////                                        ]);
//                                        $html .= yii\helpers\Html::button(' Verify', ['id' => 'take-verify-' . $model->id, 'class' => 'btn btn-sm btn-warning btn-block popb', 'value' => '/vo/default/verify?void=' . $model->id, 'name' => 'takeaction', 'title' => 'Verify']);
//                                    }
//                                    $html .= "</span>";
//                                    return $html;
//                                }
//                            ],
        [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM]),
                                'template' => '{view}',
                                'buttons' => [
//                                    'update' => function ($url, $model) {
//                                        return ($model->status == CboVo::STATUS_SAVE and $model->created_by == Yii::$app->user->identity->id) ? Html::a('<span class="fal fa-pencil"></span>', ['update?void=' . $model->id], [
//                                            'class' => '',
//                                            'data-pjax' => "0",
//                                            'class' => 'btn btn-sm btn-primary',
//                                        ]) : '';
//                                    },
//                                    'addsamuhsakhi' => function ($url, $model) {
//                                        return ($model->samuh_sakhi_name == null and $model->created_by == Yii::$app->user->identity->id) ? Html::a('<span class="fal fa-plus">Add Samuh Sakhi detail</span>', ['samuhsakhi?void=' . $model->id], [
//                                            'class' => '',
//                                            'data-pjax' => "0",
//                                            'class' => 'btn btn-sm btn-success',
//                                        ]) : '';
//                                    },
                                    'view' => function ($url, $model) {
                                        return ' ' . Html::a('<span class="fal fa-eye"></span>', ['/vo/view?void=' . $model->id], [
                                            'class' => '',
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-sm btn-primary',
                                        ]);
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