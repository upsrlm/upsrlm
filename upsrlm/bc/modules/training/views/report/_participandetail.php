<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
?>

<div class="training-default-index">
    <div class="panel panel-primary">
        <div class="panel-heading"> <?='Venue participant'?></div>
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
                        'attribute' => 'name',
                        'contentOptions' => ['style' => 'width: 20%'],
                        'enableSorting' => false,
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a($model->participant->name, ['/training/participants/view?participantid=' . $model->id], [
                                'data-pjax' => "0",
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'district_name',
                        'format' => 'html',
                        'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->district_name;
                        }
                    ],
                    [
                        'attribute' => 'block_name',
                        'format' => 'html',
                        'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->block_name;
                        }
                    ],
                    [
                        'attribute' => 'gram_panchayat_name',
                        'format' => 'html',
                        'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->gram_panchayat_name;
                        }
                    ],
                    [
                        'attribute' => 'batch',
                        'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->batch->batch_name;
                        }
                    ],
                    [
                        'label' => 'Training',
                        'attribute' => 'start_date',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function($model) {
                            return isset($model->training) ? Html::a($model->training->date, ['/training/training/view?trainingid=' . $model->training->id], [
                                'data-pjax' => "0",
                            ]) : '';
                        }
                    ],
                    [
                        'attribute' => 'schedule_date_of_exam',
                        'contentOptions' => ['style' => 'width: 15%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return isset($model->training) ? \Yii::$app->formatter->asDatetime($model->training->schedule_date_of_exam, "php:d-m-Y") : "";
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
