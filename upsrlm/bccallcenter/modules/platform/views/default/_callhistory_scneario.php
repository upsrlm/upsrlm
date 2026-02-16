<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

if ($model->callinglist->default_call_scenario_id == 1001) {
    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => \common\models\dynamicdb\internalcallcenter\platform\CallingScenarioUserVerification::find()->where([
            'calling_id' => $model->callinglist->id,
        ])->orderBy('created_at desc')->limit(1),
        'pagination' => ['pageSize' => 1],
        'sort' => [
            'defaultOrder' =>
            [
                'created_at' => SORT_DESC
            ]
        ],
    ]);
    $columns = [
        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
        'calling.agentdetail.name:raw:Caller Name',
        [
            'header' => 'SHG Name Verify',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('shg_name_and_other_verify');
            },
        ],
        [
            'header' => 'Smart Phone Availaibility',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('smart_phone');
            },
        ],
        [
            'header' => 'Agree to Download Rishta App',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('agree_download_rishta_app');
            },
        ],
        'elsehavingsmartphone:raw:Having smartphone in SHG?',
        [
            'header' => 'Carry Smartphone',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('carry_smart_phone');
            },
        ],
        [
            'header' => 'Call Purpose Achived',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('call_purpose_complete');
            },
        ],
        [
            'header' => 'Reason if Call Purpose No',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                if ($model->call_purpose_complete_no_reason == 1) {
                    return 'Not a Member of SHG Anymore';
                } else if ($model->call_purpose_complete_no_reason == 99) {
                    return 'Other';
                };
            },
        ],
        [
            'attribute' => 'created_at',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'dateTime',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->created_at;
            },
            'header' => 'Call Time',
        ],
    ];
} else if ($model->callinglist->default_call_scenario_id == 1002) {
    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => \common\models\dynamicdb\internalcallcenter\platform\CallingScenarioUserNotUsedRishtaapp::find()->where([
            'calling_id' => $model->callinglist->id,
        ])->orderBy('created_at desc')->limit(1),
        'pagination' => ['pageSize' => 1],
        'sort' => [
            'defaultOrder' =>
            [
                'created_at' => SORT_DESC
            ]
        ],
    ]);
    $columns = [
        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
        'calling.agentdetail.name:raw:Caller Name',
        // 'smart_phone',
        // 'agree_download_rishta_app',
        // 'else_having_smart_phone',
        // 'carry_smart_phone',
        [
            'header' => 'Rishta APP Install',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('install_rishta_app');
            },
        ],
        [
            'header' => 'Have Username',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('have_username');
            },
        ],
        [
            'header' => 'Have Pin',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('have_otp_pin');
            },
        ],
        'smartphoneavailaibility:raw:Smart Phone Availability',
        [
            'header' => 'Have APP Link',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('have_app_link');
            },
        ],
        [
            'header' => 'Call Purpose Achived',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('call_purpose_complete');
            },
        ],
        [
            'header' => 'Reason if Call Purpose No',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                if ($model->call_purpose_complete_no_reason == 1) {
                    return 'Not a Member of SHG Anymore';
                } else if ($model->call_purpose_complete_no_reason == 99) {
                    return 'Other';
                };
            },
        ],
        [
            'attribute' => 'created_at',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'dateTime',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->created_at;
            },
            'header' => 'Call Time',
        ],
    ];
} else if ($model->callinglist->default_call_scenario_id == 1003) {
    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => \common\models\dynamicdb\internalcallcenter\platform\CallingScenarioNotnominatedsamuhsakhi::find()->where([
            'calling_id' => $model->callinglist->id,
        ])->orderBy('created_at desc')->limit(1),
        'pagination' => ['pageSize' => 1],
        'sort' => [
            'defaultOrder' =>
            [
                'created_at' => SORT_DESC
            ]
        ],
    ]);

    $columns = [
        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
        'calling.agentdetail.name:raw:Caller Name',
        'samuhsakhinotnominated:raw:Reason for Not Nominated',
        [
            'header' => 'Call Purpose Achived',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('call_purpose_complete');
            },
        ],
        [
            'header' => 'Reason if Call Purpose No',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                if ($model->call_purpose_complete_no_reason == 1) {
                    return 'Not a Member of SHG Anymore';
                } else if ($model->call_purpose_complete_no_reason == 99) {
                    return 'Other';
                };
            },
        ],
        [
            'attribute' => 'created_at',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'dateTime',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->created_at;
            },
            'header' => 'Call Time',
        ],
    ];
} else if ($model->callinglist->default_call_scenario_id == 1004) {
    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => \common\models\dynamicdb\internalcallcenter\platform\CallingScenarioSamuhsakhinotusedrishtaapp::find()->where([
            'calling_id' => $model->callinglist->id,
        ])->orderBy('created_at desc')->limit(1),
        'pagination' => ['pageSize' => 1],
        'sort' => [
            'defaultOrder' =>
            [
                'created_at' => SORT_DESC
            ]
        ],
    ]);
    $columns = [
        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
        'calling.agentdetail.name:raw:Caller Name',
        [
            'header' => 'Rishta APP Install',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('install_rishta_app');
            },
        ],
        [
            'header' => 'Have Username',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('have_username');
            },
        ],
        [
            'header' => 'Have Pin',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('have_otp_pin');
            },
        ],
        'smartphoneavailaibility:raw:Smart Phone Availability',
        [
            'header' => 'Have APP Link',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('have_app_link');
            },
        ],
        [
            'header' => 'Call Purpose Achived',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('call_purpose_complete');
            },
        ],
        [
            'header' => 'Reason if Call Purpose No',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                if ($model->call_purpose_complete_no_reason == 1) {
                    return 'Not a Member of SHG Anymore';
                } else if ($model->call_purpose_complete_no_reason == 99) {
                    return 'Other';
                };
            },
        ],
        [
            'attribute' => 'created_at',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'dateTime',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->created_at;
            },
            'header' => 'Call Time',
        ],
    ];
} else if ($model->callinglist->default_call_scenario_id == 1005) {
    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => \common\models\dynamicdb\internalcallcenter\platform\CallingScenarioSamuhsakhinotfillform::find()->where([
            'calling_id' => $model->callinglist->id,
        ])->orderBy('created_at desc')->limit(1),
        'pagination' => ['pageSize' => 1],
        'sort' => [
            'defaultOrder' =>
            [
                'created_at' => SORT_DESC
            ]
        ],
    ]);
    $columns = [
        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
        'calling.agentdetail.name:raw:Caller Name',
        'samuhsakhinotfillform',
        [
            'header' => 'Call Purpose Achived',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->yesnoanswer('call_purpose_complete');
            },
        ],
        [
            'header' => 'Reason if Call Purpose No',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                if ($model->call_purpose_complete_no_reason == 1) {
                    return 'Not a Member of SHG Anymore';
                } else if ($model->call_purpose_complete_no_reason == 99) {
                    return 'Other';
                };
            },
        ],
        [
            'attribute' => 'created_at',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'dateTime',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->created_at;
            },
            'header' => 'Call Time',
        ],
    ];
}else if ($model->callinglist->default_call_scenario_id == 1013) {
    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => \common\models\dynamicdb\internalcallcenter\platform\CallingScenarioSamuhSakhiVerification::find()->where([
            'calling_id' => $model->callinglist->id,
        ])->orderBy('created_at desc')->limit(1),
        'pagination' => ['pageSize' => 1],
        'sort' => [
            'defaultOrder' =>
            [
                'created_at' => SORT_DESC
            ]
        ],
    ]);
    $columns = [
        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
        'calling.agentdetail.name:raw:Caller Name',

        [
            'attribute' => 'created_at',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'dateTime',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->created_at;
            },
            'header' => 'Call Time',
        ],
    ];
} else if ($model->callinglist->default_call_scenario_id == 2002) {
    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => \common\models\dynamicdb\internalcallcenter\platform\CallingScenarioMissedcall::find()->where([
            'calling_id' => $model->callinglist->id,
        ])->orderBy('created_at desc')->limit(1),
        'pagination' => ['pageSize' => 1],
        'sort' => [
            'defaultOrder' =>
            [
                'created_at' => SORT_DESC
            ]
        ],
    ]);
    $columns = [
        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
        'calling.agentdetail.name:raw:Caller Name',
        'missedcallreason:raw:Missed Call Reason',
        [
            'header' => 'Query',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->have_query;
            },
        ],
        [
            'attribute' => 'created_at',
            'contentOptions' => ['style' => 'width: 20%'],
            'format' => 'dateTime',
            'enableSorting' => false,
            'value' => function ($model) {
                return $model->created_at;
            },
            'header' => 'Call Time',
        ],
    ];
}
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-11" class="panel">

            <div class="panel-container show">

                <?php
                if (isset($dataProvider)) {
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                        'layout' => "\n{items}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data-d',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'bsVersion' => '4.x',
                        'columns' => $columns,
                    ]);
                }
                ?>
            </div>
        </div>
    </div>
</div>