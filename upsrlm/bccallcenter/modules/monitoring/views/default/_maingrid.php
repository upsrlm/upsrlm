<?= \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "\n{items}\n{pager}\n{summary}",
    'id' => 'grid-data',
    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover no-margin-bottom no-border-top table-condensed', 'id' => 'export_table'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%', 'class' => 'text-left']],
        [
            'header' => 'Calling Agent Name',
            'enableSorting' => false,
            'value' => function ($model) {
                return '<a href="/monitoring/agent/todayprogress" target=_blank>' . $model->agentdetail->name . '</a>';
            },
            'format' => 'raw'
        ],
        // 'agentdetail.name:raw:Calling Agent Name',
        [
            'header' => 'Call Scenario',
            'enableSorting' => false,
            'value' => function ($model) {
                return isset($model->callscneraio) ? $model->callscneraio->call_scenario : '';
            }
        ],
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
        [
            'header' => 'Call Date',
            'enableSorting' => false,
            'value' => function ($model) {
                return isset($model->call_end_time) ? $model->call_end_time  : $model->call_complete_date;
            }
        ],
        [
            'header' => 'Fill form <br>(Seconds)',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->call_duration;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => "Audio",
            'template' => '{audio}',
            'visible' => false,
            'buttons' => [
                'audio' => function ($url, $model) {
                    return \yii\helpers\Html::a('<i class="fal fa-eye"></i> Audio', ['viewaudio?calling_list_id=' . $model->id], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                },
            ],
        ],
    ],
]);
?>