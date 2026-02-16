<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

$this->title = 'Transaction Month';
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
                    <div class="clearfix"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
//                'floatHeader' => true,
//                'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 2%', 'class' => 'text-center']],
                            [
                                'attribute' => 'id',
                                'contentOptions' => ['style' => 'width: 3%'],
                                'format' => 'html',
                                'visible' => false,
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->id;
                                }
                            ],
                            [
                                'attribute' => 'month_no',
                                'contentOptions' => ['style' => 'width: 6%'],
                                'format' => 'html',
                                 'visible' => false,
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->month_no;
                                }
                            ],
                            [
                                'attribute' => 'year',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->year;
                                }
                            ],
                            [
                                'attribute' => 'month',
                                'value' => function ($model) {
                                    return isset($model->month_start_date) ? \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y") : '';
                                }
                            ],        
//                            [
//                                'attribute' => 'month_start_date',
//                                'format' => 'html',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->month_start_date;
//                                }
//                            ],
//                            [
//                                'attribute' => 'month_end_date',
//                                'format' => 'html',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->month_end_date;
//                                }
//                            ],
                            [
                                'attribute' => 'no_of_bc',
                                'header' => 'No. of BC',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getBctransaction()->count() ? $model->getBctransaction()->count() : '';
                                }
                            ],
                            [
                                'attribute' => 'no_of_transaction',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getBctransaction()->sum('no_of_transaction') ? $model->getBctransaction()->sum('no_of_transaction') : '';
                                }
                            ],
                            [
                                'attribute' => 'zero_transaction',
                                'header' => 'Zero Amount transaction',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getBctransaction()->sum('zero_transaction') ? $model->getBctransaction()->sum('zero_transaction') : '';
                                }
                            ],        
                            [
                                'attribute' => 'big_ticket',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getBctransaction()->sum('big_ticket_count') ? $model->getBctransaction()->sum('big_ticket_count') : '';
                                }
                            ],
                            [
                                'attribute' => 'small_ticket',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getBctransaction()->sum('small_ticket_count') ? $model->getBctransaction()->sum('small_ticket_count') : '';
                                }
                            ],
                            [
                                'attribute' => 'txt_amount',
                                'format' => 'html',
                                'enableSorting' => false,
                                'contentOptions' => ['class' => 'text-right'],
                                'value' => function ($model) {
                                    return $model->getBctransaction()->sum('transaction_amount') ? common\helpers\Utility::numberIndiaStyle($model->getBctransaction()->sum('transaction_amount'), 2) : '';
                                }
                            ],
                            [
                                'attribute' => 'commission_amount',
                                'format' => 'html',
                                'enableSorting' => false,
                                'contentOptions' => ['class' => 'text-right'],
                                'value' => function ($model) {
                                    return $model->getBctransaction()->sum('commission_amount') ? common\helpers\Utility::numberIndiaStyle($model->getBctransaction()->sum('commission_amount'), 2) : '';
                                }
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
