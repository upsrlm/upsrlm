<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\helpers\Utility;
use bc\modules\selection\models\SrlmBcApplication5;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'acvvv' ?>
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
                    <?php echo $this->render('_dublicatesearch', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-3"></div>
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
                                'attribute' => 'name',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 12%'],
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return Html::a($model['first_name'], "/selection/phase5/application/view?id=" . $model['id'], ['target' => '_blank', 'data-pjax' => "0"]);
                                },
                            ],
                            [
                                'attribute' => 'guardian_name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 10%'],
                                'value' => function ($model) {
                                    return $model['guardian_name'];
                                },
                            ],
                            [
                                'attribute' => 'aadhar_number',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                 'value' => function ($model) {
                                    return common\helpers\Utility::maskaadhar($model['aadhar_number']);
                                },
                            ],
                            [
                                'attribute' => 'mobile_number',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return Utility::mask($model['mobile_number']);
                                },
                            ],
                            [
                                'attribute' => 'gender',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 5%'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $model = SrlmBcApplication5::findOne($model['id']);
                                    return $model->genderrel != null ? $model->genderrel->name_eng : '';
                                },
                            ],
                            [
                                'attribute' => 'age',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 5%'],
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'Social Category',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'value' => function ($model) {
                                    $model = SrlmBcApplication5::findOne($model['id']);
                                    return $model->castrel != null ? $model->castrel->name_eng : '';
                                },
                            ],
                            [
                                'attribute' => 'address',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 18%'],
                                'value' => function ($model) {
                                    $model = SrlmBcApplication5::findOne($model['id']);
                                    return $model->fulladdress;
                                },
                            ],
                            [
                                'attribute' => 'Section at',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 5%'],
                                'value' => function ($model) {
                                    $model = SrlmBcApplication5::findOne($model['id']);
                                    return $model->form_number == 6 ? 'Completed' : $model->form_number;
                                },
                            ],
                            [
                                'attribute' => 'Started filling form on',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $model = SrlmBcApplication5::findOne($model['id']);
                                    return $model->form_start_date != null ? $model->form_start_date : '';
                                },
                            ],
                            [
                                'attribute' => 'Action',
                                'format' => 'raw',
                                'visible' => 0,
                                'contentOptions' => ['style' => 'width: 5%'],
                                'value' => function ($model) {
                                    $status = '';

                                    $html = '';
                                    // $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> View Data', ['id' => 'call' . $model->id, 'class' => 'btn  btn-warning btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
//                                    $html .= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], [
//                                                'class' => 'btn  btn-danger',
//                                                'data' => [
//                                                    'confirm' => 'Are you sure you want to delete this SRLM BC Selection Application?this action not undone',
//                                                    'method' => 'post',
//                                    ]]);
                                    return $html;
                                }
                            ],
                        ],
                    ]);
                    ?>


                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
