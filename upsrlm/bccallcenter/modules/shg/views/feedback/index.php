<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use cbo\models\CboClf;

$this->title = "SHG's Feedback";
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
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                            [
                                'attribute' => 'name_of_shg',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg != null ? $model->shg->name_of_shg : '';
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District/ Block',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->shg != null ? $model->shg->district_name . '<br/>' . $model->shg->block_name : '';
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'label' => 'GP',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->shg != null ? $model->shg->gram_panchayat_name : '';
                                }
                            ],
                            [
                                'attribute' => 'ques_1',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques1;
                                }
                            ],
                            [
                                'attribute' => 'ques_2',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques_2;
                                }
                            ],
                            [
                                'attribute' => 'ques_3',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques_3;
                                }
                            ],
                            [
                                'attribute' => 'ques_4',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques_4;
                                }
                            ],
                            [
                                'attribute' => 'ques_7',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques_7;
                                }
                            ],
                            [
                                'attribute' => 'ques_8',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ques8;
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
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return ' ' . Html::a('<span class="fal fa-eye"></span>', ['/shg/feedback/view?shgfeedbackid=' . $model->id], [
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
     $("#Searchform").attr({ "action":"/shg/feedback"});
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
              $("#Searchform").attr({ "action":"/shg/feedback/downloadcsv"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
                   
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/shg/feedback"});
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