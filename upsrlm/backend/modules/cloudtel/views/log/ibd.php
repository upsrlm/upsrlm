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

$this->title = 'IBD Call Logs';
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


                    <?php echo $this->render('_searchibd', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-6"></div>
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
                                'attribute' => 'upsrlm_user_mobile_no',
                                'header' => 'Agent No.',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->upsrlm_user_mobile_no != null ? $model->upsrlm_user_mobile_no : '';
                                }
                            ],
                            [
                                'attribute' => 'customernumber',
                                'header' => 'From Calling',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->customernumber != null ? $model->customernumber : '';
                                }
                            ],
                            [
                                'attribute' => 'api_status',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $status = '';
                                    if ($model->api_status) {
                                        $status .= $model->api_status;
                                    }
                                    if (isset($model->apicallerror->error_discription)) {
                                        $status .= ' : ' . $model->apicallerror->error_discription;
                                    }
                                    return $status;
                                }
                            ],
                            [
                                'attribute' => 'callStatus',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->apicallstatus != null ? $model->apicallstatus->id . ' : ' . $model->apicallstatus->call_status_genral : '';
                                }
                            ],
                            [
                                'attribute' => 'api_request_datetime',
                                'header' => 'Datetime',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->api_request_datetime != null ? $model->api_request_datetime : '';
                                }
                            ],

                            [
                                'attribute' => 'ivrDuration',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->ivrDuration != null ? $model->ivrDuration : '';
                                }
                            ],
                            [
                                'attribute' => 'talkDuration',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->talkDuration != null ? $model->talkDuration : '';
                                }
                            ],
                            [
                                'attribute' => 'recording_file',
                                'header' => 'Audio file',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->recording_file != null ? Html::button('<span class="fal fa-file-audio">Audio</span>', [
                                        'data-pjax' => "0",
                                        'class' => 'btn btn-block btn-danger popb',
                                        'value' => '/cloudtel/log/telecalleribdaudio?log_id=' . $model->id. '&date=' . date('Y-m-d', $model->created_at),
                                        'title' => 'Audio'
                                    ]) . ' ' : '';
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