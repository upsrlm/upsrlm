<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use common\models\master\MasterRole;

$this->title = "Center Training";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-default-index">
    <div class="panel panel-primary">
        <div class="panel-heading"> <?='Venue training'?></div>
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
                'layout' => "\n{summary}\n{items}",
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
                        'contentOptions' => ['style' => 'width: 12%;'],
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            return isset($model->tbatch)?$model->tbatch->batch_name:'';
                        }
                    ],
                    [
                        'attribute' => 'training_start_date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            return date("d-m-Y", strtotime($model->training_start_date));
                        }
                    ],
                    [
                        'attribute' => 'training_end_date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            return date("d-m-Y", strtotime($model->training_end_date));
                        }
                    ],
                    [
                        'attribute' => 'contact person',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            $html = '';
                            if ($model->contacts != null) {
                                foreach ($model->contacts as $contact) {
                                    $html .= $contact->user->name . " (" . $contact->user->mobile_no . ")" . "<br/>";
                                }
                            }
                            return $html;
                        }
                    ],
                    [
                        'attribute' => 'District Name',
                        'format' => 'html',
                        'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->district_name;
                        }
                    ],
                    [
                        'attribute' => 'schedule_date_of_exam',
                        'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->schedule_date_of_exam != null ? \Yii::$app->formatter->asDatetime($model->schedule_date_of_exam, "php:d-m-Y") : "";
                        }
                    ],
                    
                    [
                        'attribute' => 'no_of_participant',
                        'format' => 'html',
                        'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->no_of_participant;
                        }
                    ],
                    [
                        'attribute' => 'no_of_gp_covered',
                        'format' => 'html',
                        'contentOptions' => ['style' => 'width: 10%'],
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->no_of_gp_covered;
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

