<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel bc\models\NotificationLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BC :'.$model->name.' Notification';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                
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
                    
                    <div class="clearfix pt-6"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,

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
                            [
                                'attribute' => 'message',
                                'label' => 'Message',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->message;
                                },
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
                                    return $model->acknowledge_status==1?'Yes':'NO';
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