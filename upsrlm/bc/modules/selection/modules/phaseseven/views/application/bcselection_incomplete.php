<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use kartik\grid\GridView;
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
                    return Html::a($model->name, "/selection/phase7/application/view?id=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]) . $status;
                    ///return $model->name_of_head_of_household;
                },
            ],
            [
                'attribute' => 'guardian_name',
                'format' => 'html',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 12%'],
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
                'attribute' => 'gender',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 5%'],
                'format' => 'raw',
                'value' => function ($model) {

                    return $model->genderrel != null ? $model->genderrel->name_eng : '';
                },
            ],
            [
                'attribute' => 'age',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 5%'],
                'format' => 'raw',
                'value' => function ($model) {

                    return $model->age != null ? $model->age : '';
                },
            ],
            [
                'attribute' => 'Social Category',
                'enableSorting' => false,
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 8%'],
                'value' => function ($model) {
                    return $model->castrel != null ? $model->castrel->name_eng : '';
                },
            ],
            [
                'attribute' => 'address',
                'enableSorting' => false,
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 20%'],
                'value' => function ($model) {
                    return $model->fulladdress;
                },
            ],
            [
                'attribute' => 'Section at',
                'enableSorting' => false,
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 8%'],
                'value' => function ($model) {
                    return $model->form_number == 6 ? 'Completed' : $model->form_number;
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
                'attribute' => 'OTP Verified mobile no',
                'enableSorting' => false,
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 8%'],
                'value' => function ($model) {
                    return $model->user != null ? $model->user->mobile_no : '';
                },
            ],
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
