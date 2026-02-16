<?=

\kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
    'id' => 'grid-data',
    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover no-margin-bottom no-border-top table-condensed', 'id' => 'export_table'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%', 'class' => 'text-left']],
        // [
        //     'attribute' => 'calling_agent_id',
        //     'enableSorting' => false,
        //     'value' => function ($model) {
        //         return $model->calling_agent_id;
        //     }
        // ],
        // [
        //     'attribute' => 'cbo_shg_id',
        //     'enableSorting' => false,
        //     'value' => function ($model) {
        //         return $model->cbo_shg_id;
        //     }
        // ],
        [
            'attribute' => 'name_of_shg',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->name_of_shg;
            }
        ],
        [
            'header' => 'Member Name',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->member_name;
            }
        ],
        // [
        //     'header' => 'Call Reason',
        //     'enableSorting' => false,
        //     'value' => function ($model) {
        //         return isset($model->callreason) ? $model->callreason->reason : '';
        //     }
        // ],
        [
            'header' => 'Call Scenario',
            'enableSorting' => false,
            'value' => function ($model) {
                return isset($model->callscneraio) ? $model->callscneraio->call_scenario : '';
            }
        ],
        // [
        //     'header' => 'Schedule Date',
        //     'enableSorting' => false,
        //     'value' => function ($model) {
        //         return isset($model->call_schedule_time) ? $model->call_schedule_date . ' ' . $model->call_schedule_time : $model->call_schedule_date;
        //     }
        // ],
        [
            'header' => 'Schedule Date Time',
            'enableSorting' => false,
            'visible' => $scheaduletimevisible,
            'value' => function ($model) {
                return isset($model->call_schedule_time) ? $model->call_schedule_date . ' ' . $model->call_schedule_time : $model->call_schedule_date;
            }
        ],
        [
            'attribute' => 'call_attempt',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->call_attempt;
            }
        ],
        [
            'attribute' => 'ctc',
            'format' => 'raw',
            'header' => "Connect to Call",
            'enableSorting' => false,
            'value' => function ($model) {
                $html = '';
                $html .= yii\helpers\Html::button('<i class="fal fa-phone"></i> CTC', ['id' => 'take-no-of-call-' . $model->id, 'class' => 'btn  btn-success btn-block popb', 'value' => '/platform/default/callhistory?calling_list_id=' . $model->id, 'name' => 'takeaction', 'title' => 'Connect to call :' . $model->member_name, 'style' => "margin-top:5px;"]) . '';

                return $html;
            }
        ],
//        [
//            'class' => 'yii\grid\ActionColumn',
//            'header' => "Connect to Call",
//            'template' => '{ctc}',
//            // 'visible' => $callingtime,
//            'buttons' => [
//                'ctc' => function ($url, $model) {
//                    return \yii\helpers\Html::a('<i class="fal fa-phone"></i> CTC', ['callrequest?calling_list_id=' . $model->id], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
//                },
//            ],
//        ],
    ],
]);
?>