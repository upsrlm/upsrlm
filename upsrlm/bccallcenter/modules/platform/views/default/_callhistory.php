<?php

use kartik\grid\GridView;
use yii\widgets\Pjax;
?>

<div id="panel-101" class="panel">
    <div class="panel-container show">
        <div class="panel-content">
            <p class="font-weight-bold">कॉल हिस्ट्री</p>
            <?php
            Pjax::begin([
                'id' => 'grid-data-poppup',
                'enablePushState' => false,
                'enableReplaceState' => false,
                'timeout' => false,
            ]);
            ?>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{pager}\n{summary}",
                'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed'],
                'id' => 'grid-data-poppup',
                'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                'pjax' => TRUE,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                    [
                        'attribute' => 'calling_to',
                        'format' => 'html',
                        'enableSorting' => false,
                        'value' => function ($model) {
                            return $model->customernumber;
                        }
                    ],
                    [
                        'attribute' => 'call_scenario',
                        'format' => 'html',
                        'enableSorting' => false,
                        'value' => function ($model) {
                            return $model->callscenario != null ? $model->callscenario->call_scenario : '';
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
                        'attribute' => 'upsrlm_connection_status',
                        'header' => 'Connection Status',
                        'format' => 'html',
                        'enableSorting' => false,
                        'value' => function ($model) {
                            return $model->connectionstatus != null ? $model->connectionstatus->connection_status : '';
                        }
                    ],
                    [
                        'attribute' => 'upsrlm_call_status',
                        'header' => 'Call Status',
                        'format' => 'html',
                        'enableSorting' => false,
                        'value' => function ($model) {
                            return $model->callstatus != null ? $model->callstatus->call_status : '';
                        }
                    ],
                    [
                        'attribute' => 'upsrlm_call_quality',
                        'format' => 'html',
                        'enableSorting' => false,
                        'value' => function ($model) {
                            return $model->callqullity != null ? $model->callqullity->call_quality : '';
                        }
                    ],
                    [
                        'attribute' => 'upsrlm_call_outcome',
                        'format' => 'html',
                        'enableSorting' => false,
                        'value' => function ($model) {
                            return $model->calloutcome != null ? $model->calloutcome->call_outcome : '';
                        }
                    ],
//                    [
//                        'attribute' => 'upsrlm_call_again',
//                        'format' => 'html',
//                        'enableSorting' => false,
//                        'value' => function ($model) {
//                            return $model->callagain != null ? $model->callagain->call_again : '';
//                        }
//                    ],
//                    [
//                        'class' => 'kartik\grid\ExpandRowColumn',
//                        'width' => '50px',
//                        'header' => 'Detail',
//                        'value' => function ($model, $key, $index, $column) {
//                            return GridView::ROW_COLLAPSED;
//                        },
//                        'detailUrl' => \yii\helpers\Url::to(['/platform/default/callhistoryscenario']),
//                        'expandOneOnly' => true,
//                        'contentOptions' => ['style' => 'width: 10%'],
//                        'expandIcon' => '<span class="fal fa-expand-arrows-alt"></span>',
//                        'collapseIcon' => '<span class="fal fa-angle-down"></span>',
//                    ],
                ],
            ]);
            ?>


            <?php Pjax::end(); ?>
        </div>
    </div>
</div>