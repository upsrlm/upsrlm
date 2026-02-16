<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel common\models\dynamicdb\support\ConversationDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Conversation Details';
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
                    <div class="clearfix pt-6"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
//                        'pjax' => TRUE,
//                        'floatHeader' => true,
//                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                            [
                                'attribute' => 'call_type',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->ctype;
                                }
                            ],
                            [
                                'attribute' => 'calling_no',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->calling_no;
                                }
                            ],
                            [
                                'attribute' => 'call_date',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->call_date;
                                }
                            ],
                            [
                                'attribute' => 'calling_person_district',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->calling_person_district;
                                }
                            ],
                            [
                                'attribute' => 'calling_person_block',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->calling_person_block;
                                }
                            ],
                            [
                                'attribute' => 'calling_person_gp',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->calling_person_gp;
                                }
                            ],
                            [
                                'attribute' => 'call_response',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->call_response;
                                }
                            ],
                            [
                                'attribute' => 'comments',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->call_response;
                                }
                            ],
                            [
                                'attribute' => 'cc_executive_code',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->executive) ? $model->executive->cc_executive_name : '';
                                }
                            ],
                            [
                                'class' => 'kartik\grid\ExpandRowColumn',
                                'width' => '50px',
                                'value' => function ($model, $key, $index, $column) {
                                    return GridView::ROW_COLLAPSED;
                                },
                                'detail' => function ($model, $key, $index, $column) {
                                    return Yii::$app->controller->renderPartial('_conversation_status', ['model' => $model->convstatus]);
                                },
                                'headerOptions' => ['class' => 'kartik-sheet-style'],
                                'expandOneOnly' => true,
                                'expandIcon' => '<span class="fal fa-expand-arrows-alt"></span>',
                                'collapseIcon' => '<span class="fal fa-angle-down"></span>',
                            ],
                        ],
                    ]);
                    ?>

                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
     $("#Searchform").attr({ "action":"/report/callconversation"});
     $("#Searchform").attr("data-pjax", "True");                       
    $(this).closest('form').submit();
});            
    
JS;
                    $this->registerJs($script);
                    ?>
                    <?php
                    $js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/report/callconversation/downloadcsv"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
                   
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/report/callconversation"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

                    $this->registerJs($js);
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
