<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel common\models\dynamicdb\internalcallcenter\CloudTeleApiLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cloud Tele User Report';
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
                        'pjax' => TRUE,
                        'afterHeader' => [
                            [
                                'columns' => [
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center bg-warning-100']],
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center bg-warning-100']],
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center bg-warning-100']],
                                    ['content' => '', 'options' => ['colspan' => 1, 'class' => 'text-center bg-warning-100']],
                                    ['content' => 'Total', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => \common\models\dynamicdb\internalcallcenter\CloudTeleUserReport::getTotal($dataProvider->models, 'no_of_call'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => \common\models\dynamicdb\internalcallcenter\CloudTeleUserReport::getTotal($dataProvider->models, 'api_call_status3'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => \common\models\dynamicdb\internalcallcenter\CloudTeleUserReport::getTotal($dataProvider->models, 'api_call_status7'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => \common\models\dynamicdb\internalcallcenter\CloudTeleUserReport::getTotal($dataProvider->models, 'api_call_status11'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => \common\models\dynamicdb\internalcallcenter\CloudTeleUserReport::getTotal($dataProvider->models, 'total_call_duration'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => \common\models\dynamicdb\internalcallcenter\CloudTeleUserReport::getTotal($dataProvider->models, 'upsrlm_connection_status1'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => \common\models\dynamicdb\internalcallcenter\CloudTeleUserReport::getTotal($dataProvider->models, 'upsrlm_call_status10'), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                ],
                            ]
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'date',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->date;
                                }
                            ],
                            [
                                'attribute' => 'user_id',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->user != null ? $model->user->name : '';
                                }
                            ],
                            [
                                'attribute' => 'start_time',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->start_time != null ? $model->start_time : '';
                                }
                            ],
                            [
                                'attribute' => 'end_time',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->end_time != null ? $model->end_time : '';
                                }
                            ],
                            [
                                'attribute' => 'no_of_call',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->no_of_call;
                                }
                            ],
                             [
                                'attribute' => 'api_call_status3',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->api_call_status3;
                                }
                            ], 
                            [
                                'attribute' => 'api_call_status7',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->api_call_status7;
                                }
                            ],         
                            [
                                'attribute' => 'api_call_status11',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->api_call_status11;
                                }
                            ],
                                    
                            [
                                'attribute' => 'total_call_duration',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->total_call_duration;
                                }
                            ],
                            [
                                'attribute' => 'upsrlm_connection_status1',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->upsrlm_connection_status1;
                                }
                            ],
                            [
                                'attribute' => 'upsrlm_call_status10',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->upsrlm_call_status10;
                                }
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
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
        
         
   
    });
});  
        
JS;
                    $this->registerJs($js);
                    ?> 
                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div>    
    </div>
</div>    
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