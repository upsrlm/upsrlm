<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel bc\models\NotificationLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notification Logs';
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
                    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-3"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'bsVersion' => '4.x',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'message_title',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->message_title;
                                }
                            ],
//                            [
//                                'attribute' => 'message',
//                                'label' => 'Message',
//                                'enableSorting' => false,
//                                'contentOptions' => ['style' => 'width: 10%;'],
//                                'format' => 'raw',
//                                'value' => function ($model) {
//                                    return \kartik\popover\PopoverX::widget([
//                                        'bsVersion' => '4.x',
//                                        'header' => isset($model->template->name) ? $model->template->name : $model->message_title,
//                                        'placement' => \kartik\popover\PopoverX::ALIGN_RIGHT,
//                                        'type' => \kartik\popover\PopoverX::TYPE_INFO,
//                                        'content' => $model->message,
//                                        'toggleButton' => ['label' => 'Message', 'class' => 'btn btn-info'],
//                                    ]);
//                                },
//                            ],
                            [
                                'attribute' => 'user_id',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->user_id;
                                }
                            ],
                            [
                                'attribute' => 'app_id',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->app_id;
                                }
                            ],
                            [
                                'attribute' => 'genrated_on',
                                'label' => 'Genrated Datetime',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->genrated_on != null ? $model->genrated_on : '';
                                }
                            ],
                            [
                                'attribute' => 'send_datetime',
                                'label' => 'Sent Datetime',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->send_datetime != null ? $model->send_datetime : '';
                                }
                            ],
                            [
                                'attribute' => 'acknowledge_status',
                                'label' => 'Acknowledgement Status',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->acknowledge_status;
                                }
                            ],
                            [
                                'attribute' => 'acknowledge_date',
                                'label' => 'Acknowledgement Datetime',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->acknowledge_date != null ? $model->acknowledge_date : '';
                                }
                            ],
                            [
                                'attribute' => 'send_count',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->send_count;
                                }
                            ],
                            [
                                'attribute' => 'cron_status',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->cron_status;
                                }
                            ],
//                            [
//                                'attribute' => 'status',
//                                'format' => 'html',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->status;
//                                }
//                            ],
                            [
                                'class' => 'kartik\grid\ExpandRowColumn',
                                'width' => '50px',
                                'header' => 'Detail',
                                'value' => function ($model, $key, $index, $column) {
                                    return GridView::ROW_COLLAPSED;
                                },
                                'detailUrl' => Url::to(['/rishta/notificationlog/detail']),
                                'expandOneOnly' => true,
                                'contentOptions' => ['style' => 'width: 10%'],
                                'expandIcon' => '<span class="fal fa-expand-arrows-alt"></span>',
                                'collapseIcon' => '<span class="fal fa-angle-down"></span>',        
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
    </div>
</div>         