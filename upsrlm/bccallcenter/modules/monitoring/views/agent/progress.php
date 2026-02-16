<?php

use yii\widgets\Pjax;

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
<div class="row mt-4">
    <div class="col-xs-6 col-sm-6  col-xl-2 col-lg-3  col-md-4 mb-3">
        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->totalagent ?>
                    <small class="m-0 l-h-n">Total Agent</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6  col-xl-2 col-lg-3  col-md-4 mb-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->totaldays ?>
                    <small class="m-0 l-h-n">Total Days</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6  col-xl-2 col-lg-3  col-md-4 mb-3">
        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->totalctcclick ?>
                    <small class="m-0 l-h-n">Total CTC Click</small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6  col-xl-2 col-lg-3  col-md-4 mb-3">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->totalagentcallrecived ?>
                    <small class="m-0 l-h-n">Total Agent Call Recivied </small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3 col-md-4 mb-3 ">
        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->totalivrduration ?>
                    <small class="m-0 l-h-n">IVR Duration</small>
                </h3>
            </div>
            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3 ">
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
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3 ">
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
    <div class="col-sm-6 col-xl-3 col-md-4 mb-3 ">
        <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white h-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <?= $searchModel->totalunanswered ?>
                    <small class="m-0 l-h-n">Total Unanswered Call </small>
                </h3>
            </div>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
    </div>
</div>

<?= $this->render('_progress_search', ['model' => $searchModel, 'user_model' => $user_model]); ?>

<div class="row mt-3">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Calling Agent Daily Progress</h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?=
                    \kartik\grid\GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{items}\n{pager}\n{summary}",
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover no-margin-bottom no-border-top table-condensed', 'id' => 'export_table'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%', 'class' => 'text-left']],
                            'agentdetail.name:raw:Calling Agent Name',
                            [
                                'header' => 'Call Date',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->calling_date;
                                }
                            ],
                            [
                                'attribute' => 'start_time',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->start_time;
                                }
                            ],
                            [
                                'attribute' => 'end_time',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->end_time;
                                }
                            ],
                            [
                                'attribute' => 'work_hour',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return gmdate("H:i:s", $model->work_hour);
                                }
                            ],
                            [
                                'header' => 'CTC Click',
                                'enableSorting' => false,
                                'value' => function ($model) use ($searchModel) {

                                    return \yii\helpers\Html::a($model->ctc_click, [
                                        '/monitoring/agent/calldetail',
                                        'BcCallingAgentProgressSearch[calling_agent_id]' => $model->calling_agent_id,
                                        'BcCallingAgentProgressSearch[calling_agent_role]' => $model->calling_agent_role,
                                        'BcCallingAgentProgressSearch[calling_date]' => $model->calling_date
                                            ], [
                                        'target' => '_blank',
                                        'title' => 'View Call Detail',
                                        'data-pjax' => "0"
                                    ]);
                                    return $model->ctc_click;
                                },
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'agent_call_recived',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->agent_call_recived;
                                }
                            ],
                            [
                                'header' => 'IVR Duration',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return gmdate("H:i:s", $model->ivr_duration);
                                }
                            ],
                            [
                                'attribute' => 'both_answered',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->both_answered;
                                }
                            ],
                            [
                                'attribute' => 'talk_duration',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return gmdate("H:i:s", $model->talk_duration);
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