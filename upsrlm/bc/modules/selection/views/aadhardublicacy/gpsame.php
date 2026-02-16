<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use bc\modules\selection\models\SrlmBcApplication;
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
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
//            'floatHeader' => true,
//            'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'pager' => [
                            'options' => ['class' => 'pagination'],
                            'prevPageLabel' => 'Previous',
                            'nextPageLabel' => 'Next',
                            'firstPageLabel' => 'First',
                            'lastPageLabel' => 'Last',
                            'nextPageCssClass' => 'paginate_button page-item',
                            'prevPageCssClass' => 'paginate_button page-item',
                            'firstPageCssClass' => 'paginate_button page-item',
                            'lastPageCssClass' => 'paginate_button page-item',
                            'maxButtonCount' => 10,
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 12%'],
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return Html::a($model['first_name'], "/selection/data/application/view?id=" . $model['id'], ['target' => '_blank', 'data-pjax' => "0"]);
                                },
                            ],
                            [
                                'attribute' => 'guardian_name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 10%'],
                                'value' => function ($model) {
                                    return $model['guardian_name'];
                                },
                            ],
                            [
                                'attribute' => 'aadhar_number',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                 'value' => function ($model) {
                                    return common\helpers\Utility::maskaadhar($model['aadhar_number']);
                                },
                            ],
                            [
                                'attribute' => 'mobile_number',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                 'value' => function ($model) {
                                    return common\helpers\Utility::mask($model['mobile_number']);
                                },
                            ],
                            [
                                'attribute' => 'gender',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 5%'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $model = SrlmBcApplication::findOne($model['id']);
                                    return $model->genderrel != null ? $model->genderrel->name_eng : '';
                                },
                            ],
                            [
                                'attribute' => 'age',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 5%'],
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'Social Category',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'value' => function ($model) {
                                    $model = SrlmBcApplication::findOne($model['id']);
                                    return $model->castrel != null ? $model->castrel->name_eng : '';
                                },
                            ],
                            [
                                'attribute' => 'address',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 18%'],
                                'value' => function ($model) {
                                    $model = SrlmBcApplication::findOne($model['id']);
                                    return $model->fulladdress;
                                },
                            ],
//                [
//                    'attribute' => 'Section at',
//                    'enableSorting' => false,
//                    'format' => 'html',
//                    'contentOptions' => ['style' => 'width: 5%'],
//                    'value' => function ($model) {
//                        $model = SrlmBcApplication::findOne($model['id']);
//                        return $model->form_number == 6 ? 'Completed' : $model->form_number;
//                    },
//                ],
//                [
//                    'attribute' => 'Started filling form on',
//                    'enableSorting' => false,
//                    'value' => function ($model) {
//                        $model = SrlmBcApplication::findOne($model['id']);
//                        return $model->form_start_date != null ? $model->form_start_date : '';
//                    },
//                ],
                            [
                                'attribute' => 'Selection Status',
                                'format' => 'raw',
                                // 'visible' => 0,
                                'contentOptions' => ['style' => 'width: 5%'],
                                'value' => function ($model) {
                                    $status = '';

                                    $html = '<span id="' . $model['id'] . '">';
                                    if ($model['status'] == SrlmBcApplication::STATUS_RECIEVED) {
                                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> Pending', ['id' => 'call1' . $model['id'], 'class' => 'btn  btn-info btn-block popb', 'value' => '/selection/data/application/view?id=' . $model['id'], 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                                    }
                                    if ($model['status'] == SrlmBcApplication::STATUS_PROVISIONAL) {
                                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> Selected', ['id' => 'call2' . $model['id'], 'class' => 'btn  btn-success btn-block popb', 'value' => '/selection/data/application/view?id=' . $model['id'], 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                                    }

                                    $html .= '</span>';
                                    return $html;
                                }
                            ],
                            [
                                'attribute' => 'training_status',
                                'enableSorting' => false,
                                'label' => 'Status',
                                'format' => 'html',
                                'value' => function ($model) {
                                    $array = [null => '', '-2' => 'Unwilling', 0 => 'Default', 1 => 'Agree', '2' => 'Registered(Assign Batch)', '3' => 'Certified', '4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent'];
                                    return isset($array[$model['training_status']]) ? $array[$model['training_status']] : '';
                                },
                            ],
                        ],
                    ]);
                    ?>


                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
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
        $('.popb').elevateZoom({
         scrollZoom : true,
        responsive : true,
        zoomWindowOffetx:-600
   });
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
$(".popb").elevateZoom({
       scrollZoom : true,
        responsive : true,
        zoomWindowOffetx:-600
   });
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
