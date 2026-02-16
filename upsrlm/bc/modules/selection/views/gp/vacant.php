<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = 'SRLM BC Selection : Vacant GP';
$this->params['icon'] = 'fa fa-pie-chart';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
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
                    $form = ActiveForm::begin([
                                'layout' => 'inline',
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'Searchform'
                                ],
                                'method' => 'get',
                    ]);
                    ?>


                    <?php
                    echo $this->render('_search', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <?php ActiveForm::end(); ?>
                    <div class="clearfix pt-3"></div>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'district_name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'District',
                                'value' => function ($model) {
                                    return $model->district_name;
                                },
                            ],
                            [
                                'attribute' => 'block_name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'Block',
                                'value' => function ($model) {
                                    return $model->block_name;
                                },
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'GP',
                                'value' => function ($model) {
                                    return $model->gram_panchayat_name;
                                },
                            ],
                            [
                                'attribute' => 'no_of_application',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'No. of Available Application',
                                'value' => function ($model) {
                                    return $model->current_available;
                                },
                            ],
                            [
                                'attribute' => 'Vacant Reason',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'Vacant Reason',
                                'value' => function ($model) {
                                    $arr = ['4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent', '-2' => 'Unwilling', '32' => 'Certified Unwilling'];
                                    return isset($arr[$model->current_status]) ? $arr[$model->current_status] : 'No Application';
                                },
                            ],
                        ],
                    ]);
                    ?>


                </div>
            </div>
        </div>
    </div>
    <?php
    $js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/selection/gp/vdownload"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
                 
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/selection/gp/vacant"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

    $this->registerJs($js);
    ?>     
    <?php
    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/selection/gp/vacant"});
    $("#Searchform").attr("data-pjax", "True");                
    $(this).closest('form').submit();
});            
    
JS;
    $this->registerJs($script);
    ?>
    <?php Pjax::end(); ?>   
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


