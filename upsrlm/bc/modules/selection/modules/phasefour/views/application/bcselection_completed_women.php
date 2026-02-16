<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use kartik\grid\GridView;
use common\models\master\MasterRole;
use common\helpers\Utility;
?>
<div class="nfsa-base-survey-index">

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
        'id' => 'grid-data',
        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
//        'pjax' => TRUE,
//        'floatHeader' => true,
//        'floatHeaderOptions' => ['scrollingTop' => '50'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
            [
                'attribute' => 'name',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 12%'],
                'format' => 'raw',
                'value' => function ($model) {
                    $status = '';
                    //return $model->name;
                    return Html::a($model->name, "/selection/phase4/application/view?id=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]) . $status;
                    ///return $model->name_of_head_of_household;
                },
            ],
            [
                'attribute' => 'guardian_name',
                'format' => 'html',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return $model->guardian_name != null ? $model->guardian_name : '';
                },
            ],
            [
                'attribute' => 'mobile_number',
                'contentOptions' => ['style' => 'width: 8%'],
                'enableSorting' => false,
                'value' => function ($model) {
                    return $model->mobile_number != null ? Utility::mask($model->mobile_number) : '';
                },
            ],
            [
                'attribute' => 'age',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 3%'],
                'format' => 'raw',
                'value' => function ($model) {

                    return $model->age != null ? $model->age : '';
                },
            ],
            [
                'attribute' => 'Social Category',
                'enableSorting' => false,
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 7%'],
                'value' => function ($model) {
                    return $model->castrel != null ? $model->castrel->name_eng : '';
                },
            ],
            [
                'attribute' => 'address',
                'enableSorting' => false,
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 19%'],
                'value' => function ($model) {
                    return $model->fulladdress;
                },
            ],
            [
                'attribute' => 'OTP Verified mobile no',
                'enableSorting' => false,
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 8%'],
                'value' => function ($model) {
                    return $model->user != null ? Utility::mask($model->user->mobile_no) : '';
                },
            ],
            [
                'attribute' => 'Started filling form on',
                'enableSorting' => false,
                'value' => function ($model) {
                    return $model->form_start_date != null ? $model->form_start_date : '';
                },
            ],
            [
                'attribute' => 'over_all',
                'visible' => isset(Yii::$app->user->identity->role)  and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                'enableSorting' => false,
                'value' => function ($model) {
                    return $model->over_all;
                },
            ],
//            [
//                'attribute' => 'over_all',
////                'visible' => 0,
//                'enableSorting' => false,
//                'value' => function ($model) {
//                    return $model->over_all;
//                },
//            ],
//            [
//                'attribute' => 'pre_selected',
//                'enableSorting' => false,
//                'visible' => isset(Yii::$app->user->identity) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
//                'value' => function ($model) {
//                    return $model->status == 2 ? "Yes" : 'No';
//                },
//            ],
//            [
//                'attribute' => 'pre_selected',
//                'header' => 'Error Pre Selected',
//                'enableSorting' => false,
//                'visible' => isset(Yii::$app->user->identity) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
//                'value' => function ($model) {
//                    return $model->status_new == 2 ? "Yes" : 'No';
//                },
//            ],
            [
                'attribute' => 'Action',
                'format' => 'raw',
                'visible' => 0,
                'contentOptions' => ['style' => 'width: 5%'],
                'value' => function ($model) {
                    $status = '';

                    $html = '<span id="' . $model->id . '">';
                    $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> View Data', ['id' => 'call' . $model->id, 'class' => 'btn  btn-warning btn-block popb', 'value' => '/selection/data/application/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);

                    return $html;
                }
            ],
        ],
    ]);
    ?>


</div>
<?php
$css = <<<cs
 .pagination{margin: 0px !important;}
 .modal-lg {
    width: 100% !important;;
}       
cs;
$this->registerCss($css);
?>
<?php
$js = <<<JS
$(function () {
       
   $('.popbc').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';     
        });
});  
        
JS;
$this->registerJs($js);
?> 
<?php
$js = <<<JS
$(function () {
   $('.popnelig').click(function(){
        $('#fcontent').html('');
        $('#modal1').modal('show')
         .find('#fcontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader1').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';     
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
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader1'],
    'id' => 'modal1',
    'size' => 'modal-md',
//    'options' => ['data-backdrop' => 'true',],
    'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
    ],
]);
echo "<div id='fcontent'></div>";
Modal::end();
?>
<?php
$css = <<<cs
      .img{cursor : pointer }
cs;
$this->registerCss($css);
?>
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





</div>
