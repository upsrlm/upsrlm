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
            <div class="panel-hdr">
                <h2>
                    <?= 'Call Detail ' ?>
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
//                    Pjax::begin([
//                        'id' => 'grid-data',
//                        'enablePushState' => FALSE,
//                        'enableReplaceState' => FALSE,
//                        'timeout' => false,
//                    ]);
                    ?>

                    <div class="clearfix pt-2"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                            [
                                'attribute' => 'call_type',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->ctype;
                                }
                            ],
                            [
                                'attribute' => 'calling_no',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->calling_no;
                                }
                            ],
                            [
                                'attribute' => 'calling_person_district',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->calling_person_district;
                                }
                            ],
                            [
                                'attribute' => 'calling_person_block',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->calling_person_block;
                                }
                            ],
                            [
                                'attribute' => 'calling_person_gp',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->calling_person_gp;
                                }
                            ],
                            [
                                'attribute' => 'call_response',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->call_response;
                                }
                            ],
                            [
                                'attribute' => 'comments',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->call_response;
                                }
                            ],
                            [
                                'attribute' => 'cc_executive_code',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->executive) ? $model->executive->cc_executive_name : '';
                                }
                            ],
                            [
                                'class' => 'kartik\grid\ExpandRowColumn',
                                'width' => '50px',
                                'value' => function ($model, $key, $index, $column) {
                                    return GridView::ROW_COLLAPSED;
                                },
                                'detail' => function ($model, $key, $index, $column) {
                                    return Yii::$app->controller->renderPartial('_conversation_status', ['model' => $model->convstatus]);
                                },
                                'headerOptions' => ['class' => 'kartik-sheet-style'],
                                'expandOneOnly' => true,
                                'expandIcon' => '<span class="fal fa-expand-arrows-alt"></span>',
                                'collapseIcon' => '<span class="fal fa-angle-down"></span>',
                            ],
                        ],
                    ]);
                    ?>

                    <?php //Pjax::end(); ?> 
                </div>
            </div>
        </div> 
    </div>
</div>

