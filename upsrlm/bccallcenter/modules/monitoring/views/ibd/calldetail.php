<?php

use yii\widgets\Pjax;
use yii\bootstrap4\Modal;

$this->title = 'Calling Platform';
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
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->agentdetail != null ? $searchModel->agentdetail->name : '' ?>
                    <small class="m-0 l-h-n"><?= $searchModel->agentdetail != null ? $searchModel->agentdetail->urole->role_name : '' ?></small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->calling_date ?>
                    <small class="m-0 l-h-n">Call Date</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->totalibdcall ?>
                    <small class="m-0 l-h-n">Total IBD Call</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->totalothercall ?>
                    <small class="m-0 l-h-n">Total Other Call </small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->totalregistredcall ?>
                    <small class="m-0 l-h-n">Total Registred Call</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->totalbothanswered ?>
                    <small class="m-0 l-h-n">Both Answered</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->totaltalkduration ?>
                    <small class="m-0 l-h-n">Talk Duration</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->totalagentcallrecived ?>
                    <small class="m-0 l-h-n">Total Scneario Button Click </small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
</div>

<?php // $this->render('_search', ['model' => $searchModel]); 
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>IBD Call Detail</h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?= \kartik\grid\GridView::widget([
                        'dataProvider' => $dataProvider,
                        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                        'layout' => "\n{items}\n{pager}\n{summary}",
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover no-margin-bottom no-border-top table-condensed', 'id' => 'export_table'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%', 'class' => 'text-left']],
                            // 'user.name:raw:Calling Agent Name',
                            // 'user.urole.role_name:raw:Group',
                            [
                                'header' => 'Call Time',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return  $model->api_request_datetime;
                                }
                            ],
                            [
                                'attribute' => 'Previous Call',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->previouscallibd;
                                }
                            ],
                            'ibdcallertype:raw:Caller Type',
                            'callscneario.call_scenario:raw:Call Scenario',
                            [
                                'header' => 'Scneario Button Click',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    if ($model->upsrlm_agent_call_received == 1) {
                                        return 'Yes';
                                    } else if ($model->upsrlm_agent_call_received == 2) {
                                        return 'No';
                                    }
                                }
                            ],
                            'apicallstatus.call_status_ctc:raw:API Status',
                            [
                                'header' => 'IVR Duration',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return gmdate("H:i:s", $model->ivrDuration);
                                }
                            ],
                            [
                                'attribute' => 'talk_duration',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return gmdate("H:i:s", $model->talkDuration);
                                }
                            ],
                            [
                                'attribute' => 'recording_file',
                                'header' => 'Audio file',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    if ($model->apilog) {
                                        return $model->apilog->recording_file != null ? \yii\helpers\Html::button('<span class="fal fa-file-audio">Audio</span>', [
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-block btn-danger popb',
                                            'value' => '/report/call/telecalleraudio?log_id=' . $model->apilog->id,
                                            'title' => 'Audio'
                                        ]) . ' ' : '';
                                    }
                                }
                            ],

                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>
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

'
);
?>