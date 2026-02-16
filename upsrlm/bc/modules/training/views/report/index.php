<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = "Training Report";
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
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-3"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
//                        'floatHeader' => true,
//                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'showPageSummary' => true,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 2%', 'class' => 'text-center']],
                            [
                                'attribute' => 'District Name',
                                'header' => 'District',
                                'format' => 'html',
                                //'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district_name;
                                },
                            ],
                            [
                                'attribute' => 'contact person',
                                'header' => 'RSETI Director',
                                //'contentOptions' => ['style' => 'width: 12%;'],
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $html = '';
                                    if ($model->rsethicontacts != null) {
                                        foreach ($model->rsethicontacts as $contact) {
                                            $html .= $contact->user->name . " (" . $contact->user->mobile_no . ")" . "<br/>";
                                        }
                                    }
                                    return $html;
                                }
                            ],
                            [
                                'attribute' => 'lead_bank',
                                'header' => 'RSETI Bank',
                                'format' => 'html',
                                //'contentOptions' => ['style' => 'width: 12%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return implode("<br/>", array_unique(yii\helpers\ArrayHelper::getColumn($model->rsethileadbank, 'profile.bank_name')));
                                },
                            ],
                            [
                                'attribute' => 'bc_bank_partner',
                                'header' => 'BC Partner Bank',
                                'format' => 'html',
                                // 'contentOptions' => ['style' => 'width: 12%'],
                                'enableSorting' => false,
                                'value' => function ($model) {                                    
                                    return isset($model->pbank->parnerbank)?$model->pbank->parnerbank->bank_name:'';
                                },
                                'pageSummary' => 'Total'
                            ],
                            [
                                'attribute' => 'total_gp',
                                'header' => 'Total GP',
                                'format' => 'html',
                                'contentOptions' => ['class' => 'info'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->total_gp;
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'total_bc',
                                'header' => 'Total BC Shortlisted',
                                'format' => 'html',
                                'contentOptions' => ['class' => 'info'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->total_bc_sortlisted;
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'total_bc',
                                'header' => 'Total BC Shortlisted after GP update',
                                'format' => 'html',
                                'contentOptions' => ['class' => 'info'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->total_bc_sortlisted - $model->urban;
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'no_of_training',
                                'header' => 'No. of batches Proposed',
                                'format' => 'html',
                                'contentOptions' => ['class' => 'info'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return ceil($model->total_bc_sortlisted / 30);
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'no_of_training_planned',
                                'header' => 'No. of Batches Planned',
                                'format' => 'html',
                                //'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->nooftrainingplaned;
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'no_of_training_finish',
                                'header' => 'No. of Batches concluded',
                                'format' => 'html',
                                //'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->nooftrainingfinished;
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'avg_batch_size',
                                'header' => 'Avg Batch Size',
                                'format' => 'html',
                                //'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return (int) $model->getTraining()->count() != 0 ? round((int) $model->getTraining()->sum('no_of_participant') / (int) $model->getTraining()->count()) : '';
                                },
//                        'pageSummary' => true
                            ],
                            [
                                'attribute' => 'no_of_participant',
                                'header' => 'No. of Participants',
                                'format' => 'html',
                                //'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return (int) $model->getTraining()->sum('no_of_participant');
                                },
                                'pageSummary' => true
                            ],
//                    [
//                        'attribute' => 'no_of_gp_covered',
//                        'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 9%'],
//                        'enableSorting' => false,
//                        'value' => function($model) {
//                            return $model->no_of_gp_covered;
//                        },
//                        'pageSummary' => true
//                    ],
                            [
                                'attribute' => 'no_of_participant_pass',
                                'header' => 'Certified by IIBF ',
                                //'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getParticipant()->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS])->count();
                                },
                                'pageSummary' => true
                            ],
                        ],
                    ]);
                    ?>

                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $(this).closest('form').submit();
});            
    var loader = $(".ajax");
    $(document).on({
        ajaxStart: function () {
            loader.addClass("loader");
        },
        ajaxStop: function () {
            loader.removeClass("loader");
        }
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


