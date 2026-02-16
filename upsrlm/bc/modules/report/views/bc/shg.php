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

$this->title = "BC SHG's";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?=$this->title?>
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

                    <div class="mb-3"></div>


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
                                'enableSorting' => false,
                                'contentOptions' => ['class' => 'info'],
                            ],
                            [
                                'attribute' => 'name_of_shg',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->name_of_shg != NULL ? $model->name_of_shg . $model->getColumnstatus($model->verify_shg_name) : '';
                                }
                            ],
                            [
                                'attribute' => 'shg_code',
                                'label' => 'NRLM SHG Code',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->shg_code != NULL ? $model->shg_code . $model->getColumnstatus($model->verify_shg_code) : '';
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->district_name;
                                }
                            ],
                            [
                                'attribute' => 'block_name',
                                'label' => 'Block ',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->block_name;
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'label' => 'Gram Panchayat /Rev. Village ',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->gram_panchayat_name . ' /' . $model->village_name . $model->getColumnstatus($model->verify_shg_location);
                                }
                            ],
//   
                            [
                                'attribute' => 'no_of_members',
//                                'contentOptions' => ['style' => 'width: 5%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->no_of_members . $model->getColumnstatus($model->verify_shg_members);
                                }
                            ],
                            [
                                'attribute' => 'chaire_person_name',
                                'label' => 'Chair Person',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $mmodel = $model->getRmembers()->andWhere(['role' => 1])->one();
                                    return isset($mmodel) ? $mmodel->name . "<br/>" . $mmodel->mobile . "<br/>" . $model->getColumnstatus($model->verify_chaire_person_mobile_no) : '';
                                }
                            ],
                            [
                                'attribute' => 'secretary_name',
                                'label' => 'Secretary',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $mmodel = $model->getRmembers()->andWhere(['role' => 2])->one();
                                    return isset($mmodel) ? $mmodel->name . "<br/>" . $mmodel->mobile . "<br/>" . $model->getColumnstatus($model->verify_secretary_mobile_no) : '';
                                }
                            ],    
                            [
                                'attribute' => 'treasurer_name',
                                'label' => 'Treasurer',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $mmodel = $model->getRmembers()->andWhere(['role' => 3])->one();
                                    return isset($mmodel) ? $mmodel->name . "<br/>" . $mmodel->mobile . "<br/>" . $model->getColumnstatus($model->verify_treasurer_mobile_no) : '';
                                }
                            ],
                             [
                                'attribute' => 'bc_sakhi',
                                'label' => 'BC Sakhi',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->bcuser) ? $model->bcuser->name . "<br/>" . $model->bcuser->username : '';
                                }
                            ],
                            
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => 0,//in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM]),
                                'template' => '{update}{view}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return (($model->status == 0 or ($model->status == 2 and ($model->verify_mobile_no == 2 or $model->verify_shg_location == 2 or $model->verify_shg_name == 2 or $model->verify_shg_members == 2 or $model->verify_shg_code == 2))) and in_array($model->block_code, \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->blocks, 'block_code')) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BMMU])) ? Html::a('<span class="fal fa-pencil"></span>', ['update?shgid=' . $model->id], [
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-sm btn-primary',
                                        ]) : '';
                                    },
                                    'view' => function ($url, $model) {
                                        return ' ' . Html::a('<span class="fal fa-eye"></span>', ['/shg/view?shgid=' . $model->id], [
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