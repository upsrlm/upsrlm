<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

$this->title = 'Certified BC';
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
                        'layout' => "\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
//                'floatHeader' => true,
//                'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'header' => 'BC Name',
//                        'contentOptions' => ['style' => 'width: 18%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return $model->name;
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'header' => 'BC District',
                                'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district_name;
                                }
                            ],
                            [
                                'attribute' => 'block_name',
                                'header' => 'BC Block',
                                'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->block_name;
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'header' => 'BC GP',
                                'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->gram_panchayat_name;
                                }
                            ],
                            [
                                'attribute' => 'member',
                                'header' => 'BC Member',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->agm) ? $model->agm->name_eng : '';
                                }
                            ],
                            [
                                'attribute' => 'shg_name',
                                'header' => 'BC SHG Name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->your_group_name) ? $model->your_group_name : '';
                                }
                            ],
                            [
                                'attribute' => 'upsrlm_shg_name',
                                'header' => 'UPSRLM SHG Name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $shg = cbo\models\Shg::findOne($model->cbo_shg_id);
                                    return isset($shg->name_of_shg) ? $shg->name_of_shg : '';
                                }
                            ],
                            [
                                'attribute' => 'BC bank a/c',
                                'header' => 'BC bank a/c',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->bank_account_no_of_the_bc) ? $model->bank_account_no_of_the_bc : '';
                                }
                            ],
                            [
                                'attribute' => 'Passbook image',
                                'header' => 'BC Passbook/Statement image',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $status = '';
                                    $html = '<span id="' . $model->id . '">';

                                    $html .= $model->passbook_photo != null ? '<span class="profile-picture">
                                        <img width="150px" height="150px" data-src="' . \Yii::$app->params['app_url']['bc'] . $model->passbook_photo_url . '"  class="lozad" title="aadhar_back_photo" style="cursor : pointer"/>
                                        </span> ' : '';

                                    $html .= '</span>';
                                    return $html;
                                }
                            ],
//                    [
//                        'attribute' => 'SHG Name',
//                        'header' => 'Assign SHG',
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function($model) {
//                            return isset($model->cbo_shg_id) ? 'Yes' : 'NO';
//                        }
//                    ],
                            [
                                'attribute' => 'BC as Samuh Sakhi',
                                'header' => 'BC as Samuh Sakhi',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->already_group_member == 5 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                'template' => '{assignshg}',
                                'buttons' => [
                                    'assignshg' => function ($url, $model) {
                                        return $model->cbo_shg_id == null ? yii\helpers\Html::button('<i class="fa fa-task"></i> Assign SHG', ['id' => 'take-action-' . $model->id, 'class' => 'btn btn-sm btn-warning btn-block popb', 'value' => '/bc/certified/assignshg?bcid=' . $model->id, 'name' => 'takeaction', 'title' => 'Assign SHG']) : yii\helpers\Html::button('<i class="fa fa-task"></i> Update SHG', ['id' => 'take-action-' . $model->id, 'class' => 'btn btn-sm btn-warning btn-block popb', 'value' => '/bc/certified/assignshg?bcid=' . $model->id, 'name' => 'takeaction', 'title' => 'Update SHG']);
                                        return $model->cbo_shg_id == null ? Html::a('<span class="fa fa-tasks"></span> Assign SHG', ['assignshg?bcid=' . $model->id], [
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-sm btn-primary',
                                        ]) . ' ' : Html::a('<span class="fa fa-tasks"></span> Update SHG', ['assignshg?bcid=' . $model->id], [
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
