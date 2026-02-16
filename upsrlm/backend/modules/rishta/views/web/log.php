<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

$this->title = 'Rishta Web Log';
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
                    <div class="clearfix"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 2%', 'class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->user) ? $model->user->name : '';
                                }
                            ],
                            [
                                'attribute' => 'type',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->tmodule) ? $model->tmodule : '';
                                }
                            ],
                            [
                                'attribute' => 'type_id',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->type_id) ? $model->type_id : '';
                                }
                            ],
                            [
                                'attribute' => 'type_url',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->type_url) ? $model->type_url : '';
                                }
                            ],
                           [
                                'attribute' => 'app_version',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->app_version) ? $model->app_version : '';
                                }
                            ],         
                           [
                                'attribute' => 'datetime',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->datetime) ? $model->datetime : '';
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
