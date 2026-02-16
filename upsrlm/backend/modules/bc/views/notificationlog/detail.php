<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{items}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data-d',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'bsVersion' => '4.x',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'notification_log_id',
                                'contentOptions' => ['style' => 'width: 20%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->notification_log_id;
                                }
                            ],
                            [
                                'attribute' => 'firebase_id',
                                'contentOptions' => ['style' => 'width: 25%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->firebase_id) ? $model->firebase_id : '';
                                }
                            ],
                            [
                                'attribute' => 'firebase_message',
                                'contentOptions' => ['style' => 'width: 25%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->firebase_message) ? $model->firebase_message : '';
                                }
                            ],
                            [
                                'attribute' => 'create_on',
                                'contentOptions' => ['style' => 'width: 20%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->create_on;
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
