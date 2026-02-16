<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

/* @var $this yii\web\View */
/* @var $searchModel bc\modules\selection\models\BcMissingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BC Misplaced';
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
                    <div class="clearfix pt-3"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                            [
                                'attribute' => 'bc_name',
                                'header' => 'BC Name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Html::a($model->bc_name, "/selection/data/application/view?id=" . $model->bc_application_id, ['target' => '_blank', 'data-pjax' => "0"]);
                                },
                            ],
                            [
                                'attribute' => 'mobile_number',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'district_name',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'block_name',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'certified',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'age',
                                'enableSorting' => false,
//                'contentOptions' => ['style' => 'width: 5%'],
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return $model->bc != null ? $model->bc->age : '';
                                },
                            ],
                            [
                                'attribute' => 'reading_skills',
                                'enableSorting' => false,
                                'label' => 'Education',
                                'format' => 'html',
                                'value' => function ($model) {

                                    return isset($model->bc->readingskills) ? $model->bc->readingskills->name_eng : '';
                                },
                            ],
                            [
                                'attribute' => 'listed_bc_application_id',
                                'enableSorting' => false,
                                'label' => 'Listed BC Name',
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return isset($model->listedbc) ? Html::a($model->listedbc->name, "/selection/data/application/view?id=" . $model->listed_bc_application_id, ['target' => '_blank', 'data-pjax' => "0"]) : '';
                                },
                            ],
                            [
                                'attribute' => 'listed_bc_training_status',
                                'enableSorting' => false,
                                'label' => 'Listed BC Training',
                                'format' => 'html',
                                'value' => function ($model) {
                                    $array = [null => '', '-2' => 'Unwilling', 0 => 'Default', 1 => 'Agree', '2' => 'Registered(Assign Batch)', '3' => 'Certified', '4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent'];
                                    return isset($model->listedbc) ? $array[$model->listed_bc_training_status] : '';
                                },
                            ],
                            [
                                'attribute' => 'reason',
                                'enableSorting' => false,
                                'label' => 'reason',
                                'format' => 'html',
                                'value' => function ($model) {
                                    $html = '';
                                    if (isset($model->listedbc)) {
                                        if ($model->listedbc->training_status == SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE) {
                                            $html .= $model->listedbc->ineligible;
                                        } else if ($model->listedbc->bc_unwilling_rsetis == 1) {
                                            $html .= $model->listedbc->rsethiunwilling;
                                        }
                                    }

                                    return $html;
                                },
                            ],
                            [
                                'attribute' => 'comment',
                                'enableSorting' => false,
                                'label' => 'Comment',
                                'format' => 'html',
                                'value' => function ($model) {

                                    return isset($model->comment) ? $model->comment : '';
                                },
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                'template' => '{view}{map}{comment}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::button('<span class="fal fa-eye"></span>', [
                                            'data-pjax' => "0",
                                            'class' => 'btn   btn-info popb',
                                            'value' => '/selection/missing/view?id=' . $model->id,
                                            'title' => 'BC : ' . $model->bc_name
                                        ]) . '<br/> ';
                                    },
                                    'map' => function ($url, $model) {
                                        return (($model->bc_application_id == 0) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) ? Html::button('<span class="fa fa-sign-in"> Map BC</span>', [
                                            'data-pjax' => "0",
                                            'class' => 'btn   btn-info popb',
                                            'style' => 'margin-top:5px',
                                            'value' => '/selection/missing/map?id=' . $model->id,
                                            'title' => 'Map BC : ' . $model->bc_name
                                        ]) . ' <br/>' : '';
                                    },
                                    'comment' => function ($url, $model) {
                                        return (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) ? Html::button('<span class=""> Comment</span>', [
                                            'data-pjax' => "0",
                                            'class' => 'btn   btn-info popb mt-10',
                                            'style' => 'margin-top:5px',
                                            'value' => '/selection/missing/comment?id=' . $model->id,
                                            'title' => 'Comment on BC : ' . $model->bc_name
                                        ]) . ' ' : '';
                                    },
                                ]
                            ],
                        ],
                    ]);
                    ?>

                    <?php
                    $js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/selection/missing/download"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
                
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/selection/missing"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

                    $this->registerJs($js);
                    ?>          
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/selection/missing"});
    $("#Searchform").attr("data-pjax", "True");                
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
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
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
                    <?php
                    Modal::begin([
                        'headerOptions' => ['id' => 'modalHeader1'],
                        'id' => 'modal1',
                        'size' => 'modal-xl',
//    'options' => ['data-backdrop' => 'true',],
                        'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
                        ],
                    ]);
                    echo "<div id='fcontent'></div>";
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
