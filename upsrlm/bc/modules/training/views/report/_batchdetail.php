<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
?>

<div class="training-default-index">
    <div class="panel panel-default">
        <div class='panel-body'>
            <?php
            Pjax::begin([
                'id' => 'grid-data',
                'enablePushState' => FALSE,
                'enableReplaceState' => FALSE,
                'timeout' => false,
            ]);
            ?>

            <div class="clearfix"></div>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                'id' => 'grid-data',
                'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                'pjax' => TRUE,
                'floatHeader' => true,
                'floatHeaderOptions' => ['scrollingTop' => '50'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                    [
                        'attribute' => 'batch_name',
                        'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a($model->batch_name, ['/training/batch/view?batchid=' . $model->id], [
                                'data-pjax' => "0",
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'District Name',
                        'format' => 'html',
                        'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return isset($model->center) ? $model->center->district_name : '';
                        }
                    ],
                    [
                        'attribute' => 'Venue',
                        'contentOptions' => ['style' => 'width: 20%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return isset($model->center) ? $model->center->name : '';
                        }
                    ],
                    [
                        'label' => 'Training',
                        'attribute' => 'start_date',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'value' => function($model) {
                            return $model->training->date;
                        }
                    ],
                    [
                        'attribute' => 'no_of_participant',
                        'enableSorting' => false,
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'value' => function($model) {
                            return $model->no_of_participant;
                        }
                    ],
                    [
                        'attribute' => 'no_of_gp_covered',
                        'enableSorting' => false,
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'value' => function($model) {
                            return $model->no_of_gp_covered;
                        }
                    ],        
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT]),
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return ($model->created_by == Yii::$app->user->identity->id) ? Html::a('<span class="fa fa-plus"> Add Participant</span>', ['/training/batch/addparticipant?batchid=' . $model->id], [
                                    'class' => '',
                                    'data-pjax' => "0",
                                    'class' => 'btn  btn-primary',
                                ]) : '';
                            },
                            'view' => function ($url, $model) {
                                return ' ' . Html::a('<span class="fa fa-eye"></span>', ['view?batchid=' . $model->id], [
                                    'class' => '',
                                    'data-pjax' => "0",
                                    'class' => 'btn  btn-primary',
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
    $(this).closest('form').submit();
});            
    
JS;
            $this->registerJs($script);
            ?>

            <?php Pjax::end(); ?> 
        </div>
    </div>
</div>    
