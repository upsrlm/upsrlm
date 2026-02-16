<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "SHG's";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    SHG's Urban
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

                    <?php if (MasterRole::ROLE_BMMU == Yii::$app->user->identity->role) { ?>
                        <div class="panel-tag">

                            <span style="color:#478fca !important">Notice: <b>ये सभी सूचनाएं मेरे स्वयं के द्वारा सत्यापित की हुई है I सूचनाओं के प्रावधान में किसी भी त्रुटि की जवाबदेही सम्बद्ध होगी </b>I</span>
                        </div>

                    <?php } ?>
                    <?php
                    $form = ActiveForm::begin([
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'Searchform'
                                ],
                                'id' => 'Searchform',
                                'layout' => 'inline',
                                'method' => 'get',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_search_shg', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    
                     
                    
                    <div class="col-lg-12 mb-2">
                        <div class="col-xs-4 col-sm-4">
                            <div style="margin: 0px 24px 0px 10px;border: 0px">
                                <label class="control-label">Legends</label>
                            </div>
                            <div class="widget-box" style="background-color: #D0E9C6;font-size: 14px;height: 40px;margin: 0px 20px;border: 0px">
                                <div class="widget-header" style="background-color: #D0E9C6;height:25px;border:0px"><span class="badge success" style="background-color:#D0E9C6;height:25px;width:40px;color: black;font: 18;font-weight: bold">1</span> Verified SHG</div>
                            </div>
                            <div class="widget-box warning" style="background-color: #FCF8E3;font-size: 14px;height: 40px;margin: 0px 20px;border: 0px">
                                <div class="widget-header" style="background-color: #FCF8E3;height:25px;border:0px"><span class="badge warning" style="background-color: #FCF8E3;height:25px;width:40px;color: black;font: 18;font-weight: bold">2</span> Return SHG</div>
                            </div>


                        </div>
                    </div> 
                     
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-responsive table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'rowOptions' => function ($model) {

                            if ($model->verification_status > '0' and $model->verify_mobile_no == '2') {
                                return ['class' => 'color-warning-600'];
                            } elseif ($model->verification_status > '0' and $model->verify_mobile_no == '1') {
                                return ['class' => 'color-success-400'];
                            } else {
                                
                            }
                        },
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'id',
//                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'contentOptions' => ['class' => 'info'],
                            ],
                            [
                                'attribute' => 'name_of_shg',
//                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->name_of_shg != NULL ? $model->name_of_shg. $model->getColumnstatus($model->verify_shg_name) : '';
                                }
                            ],
                            [
                                'attribute' => 'shg_code',
                                'label' => 'NRLM SHG Code',
//                                'contentOptions' => ['style' => 'width: 5%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->shg_code != NULL ? $model->shg_code. $model->getColumnstatus($model->verify_shg_code) : '';
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District',
//                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->district_name;
                                }
                            ],
                            [
                                'attribute' => 'block_name',
                                'label' => 'Block ',
//                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->block_name;
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'label' => 'Gram Panchayat /Rev. Village /Hamlate ',
//                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->gram_panchayat_name.' /'.$model->village_name.' /'.$model->hamlet. $model->getColumnstatus($model->verify_shg_location);
                                    
                                }
                            ],
//                            [
//                                'attribute' => 'village_name',
//                                'label' => 'Rev. Village',
////                                'contentOptions' => ['style' => 'width: 10%'],
//                                'enableSorting' => false,
//                                'format' => 'raw',
//                                'value' => function ($model) {
//                                    return $model->village_name. $model->getColumnstatus($model->verify_shg_location);
//                                    
//                                }
//                            ],
//                            [
//                                'attribute' => 'hamlet',
////                                'contentOptions' => ['style' => 'width: 10%'],
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->hamlet. $model->getColumnstatus($model->verify_shg_location);
//                                    
//                                }
//                            ],
                            [
                                'attribute' => 'no_of_members',
//                                'contentOptions' => ['style' => 'width: 5%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->no_of_members. $model->getColumnstatus($model->verify_shg_members);
                                    
                                }
                            ],
                            [
                                'attribute' => 'chaire_person_name',
                                'label' => 'Chair Person',
//                                'contentOptions' => ['style' => 'width: 10%'],
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $mmodel = $model->getRmembers()->andWhere(['role' => 1])->one();
                                    return isset($mmodel) ? $mmodel->name . "<br/>" . $mmodel->mobile. "<br/>". $model->getColumnstatus($model->verify_chaire_person_mobile_no) : '';
                                }
                            ],
                            [
                                'attribute' => 'secretary_name',
                                'label' => 'Secretary',
//                                'contentOptions' => ['style' => 'width: 10%'],
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $mmodel = $model->getRmembers()->andWhere(['role' => 2])->one();
                                    return isset($mmodel) ? $mmodel->name . "<br/>" . $mmodel->mobile. "<br/>". $model->getColumnstatus($model->verify_secretary_mobile_no) : '';
                                }
                            ],
//     
                            [
                                'attribute' => 'treasurer_name',
                                'label' => 'Treasurer',
//                                'contentOptions' => ['style' => 'width: 10%'],
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $mmodel = $model->getRmembers()->andWhere(['role' => 3])->one();
                                    return isset($mmodel) ? $mmodel->name . "<br/>" . $mmodel->mobile. "<br/>". $model->getColumnstatus($model->verify_treasurer_mobile_no) : '';
                                }
                            ],
                            [
                                'attribute' => 'created_by',
//                                'contentOptions' => ['style' => 'width: 8%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->entryby) ? $model->entryby->name . " (" . $model->entryby->mobile_no . ")" : '';
                                }
                            ],
                            
                            
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM]),
                                'template' => '{view}',
                                'buttons' => [
                                    
                                    'view' => function ($url, $model) {
                                        return ' ' . Html::a('<span class="fal fa-eye"></span>', ['/shg/view?shgid=' . $model->id], [
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-sm btn-primary',
                                        ]);
                                    },
                                ]
                            ],
//                            [
//                                'attribute' => 'Action',
//                                'format' => 'raw',
//                                'visible' => 0, //in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
//                                'contentOptions' => ['style' => 'width: 5%'],
//                                'value' => function ($model) {
//                                    $html = '';
//                                    if ($model->return == 0) {
//                                        $html .= Html::a('<span class="fal fa-undo"> Return</span>', ['/shg/default/return?shgid=' . $model->id], [
//                                                    'data-pjax' => "0",
//                                                    'class' => 'btn btn-sm btn-danger',
//                                                    'data' => [
//                                                        'confirm' => 'Are you absolutely sure return this SHG? this action not undon',
//                                                        'method' => 'post',
//                                                    ],
//                                        ]);
//                                    }
//                                    return $html;
//                                }
//                            ],
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
                     <?php ActiveForm::end(); ?> 
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