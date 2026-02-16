<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel bc\models\NotificationTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notification Templates';
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
                    <?php if (isset(Yii::$app->user->identity) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>

                        <?= Html::a('Add Notification Template', ['create'], ['class' => 'btn btn-success']) ?>

                    <?php } ?>
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
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 2%', 'class' => 'text-center']],
                            [
                                'attribute' => 'id',
                                'contentOptions' => ['style' => 'width: 3%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->id;
                                }
                            ],
                            [
                                'attribute' => 'name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->name;
                                }
                            ],
                            [
                                'attribute' => 'template',
//                        'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->template;
                                }
                            ],
                            [
                                'attribute' => 'visible',
                                'contentOptions' => ['style' => 'width: 5%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->visible == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'acknowledge',
                                'contentOptions' => ['style' => 'width: 5%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->acknowledge == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                'template' => '{update}{view}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="fal fa-pencil"></span>', ['update?id=' . $model->id], [
                                            'class' => '',
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-sm btn-primary',
                                        ]);
                                    },
                                    'view' => function ($url, $model) {
                                        return ' ' . Html::a('<span class="fal fa-eye"></span>', ['view?id=' . $model->id], [
                                            'class' => '',
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-sm btn-primary',
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
    </div>
</div> 
