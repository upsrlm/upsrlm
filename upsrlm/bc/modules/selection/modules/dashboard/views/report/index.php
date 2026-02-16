<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\selection\models\base\GenralModel;
use common\models\User;

$this->title = 'SRLM BC Selection report';
$this->params['icon'] = 'fa fa-pie-chart';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
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
                    $form = ActiveForm::begin([
                                'layout' => 'inline',
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'Searchform'
                                ],
                                'method' => 'get',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_search', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <?php ActiveForm::end(); ?>
                    <div class="clearfix pt-3"></div>

                    <div class="row">
                        <div class="col-md-12 col-lg-12">

                            <?php if ($searchModel->report_type == 1) { ?>
                                <?=
                                GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
//                                    'pjax' => TRUE,
//                                    'floatHeader' => true,
//                                    'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'district_name',
                                            'header' => 'District',
                                            'enableSorting' => false,
                                            'contentOptions' => ['style' => 'width: 12%'],
                                            'format' => 'raw',
                                            'value' => function ($model) use ($searchModel) {
                                                return $model->district != null ? $model->district->district_name : '';
                                            },
                                        ],
                                        [
                                            'attribute' => 'total_no_of_gp',
                                            'header' => 'Total no of GP',
                                            'format' => 'html',
                                            'enableSorting' => false,
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                return $model->district != null ? $model->district->gram_panchayat_count : '';
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Total no of GP coverd on basis of above filter',
                                            'enableSorting' => false,
                                            'format' => 'html',
//                                            'contentOptions' => ['style' => 'width: 20%'],
                                            'value' => function ($model) use ($searchModel) {
                                                return $model->getAppgp($model, $searchModel);
                                                //return $model->application_gp_count;
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_received',
                                            'header' => 'Total BC application received',
                                            'enableSorting' => false,
//                                            'contentOptions' => ['style' => 'width: 18%'],
                                            'format' => 'raw',
                                            'value' => function ($model) use ($searchModel) {
                                                return Html::a($model->district->bc_selection_application_receive, $searchModel->district_base_url . '=' . $model->district_code, ['target' => '_blank', 'data-pjax' => "0"]);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_received',
                                            'header' => 'BC application by filter',
                                            'enableSorting' => false,
//                                            'contentOptions' => ['style' => 'width: 20%'],
                                            'format' => 'raw',
                                            'value' => function ($model) use ($searchModel) {
                                                return Html::a($model->application_count, $searchModel->district_base_url . '=' . $model->district_code . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->application_count;
                                            },
                                        ],
//                [
//                    'attribute' => 'application_gp',
//                    'header' => 'SC / ST',
//                    'enableSorting' => false,
//                    'format' => 'raw',
//                    'contentOptions' => ['style' => 'width: 5%'],
//                    'value' => function($model) use ($searchModel) {
//                        return Html::a($model->district->bc_selection_sc_st_application_receive, $searchModel->district_base_url . '=' . $model->district_code . '&DashboardSearchForm[cast]=1', ['target' => '_blank', 'data-pjax' => "0"]);
//                        return $model->district != null ? $model->district->bc_selection_sc_st_application_receive : '';
//                    },
//                ],
//                [
//                    'attribute' => 'application_gp',
//                    'header' => 'OBC',
//                    'enableSorting' => false,
//                    'format' => 'raw',
//                    'contentOptions' => ['style' => 'width: 5%'],
//                    'value' => function($model) use ($searchModel) {
//                        return Html::a($model->district->bc_selection_obc_application_receive, $searchModel->district_base_url . '=' . $model->district_code . '&DashboardSearchForm[cast]=2', ['target' => '_blank', 'data-pjax' => "0"]);
//                        return $model->district != null ? $model->district->bc_selection_obc_application_receive : '';
//                    },
//                ],
//                [
//                    'attribute' => 'application_gp',
//                    'header' => 'General',
//                    'enableSorting' => false,
//                    'format' => 'html',
//                    'contentOptions' => ['style' => 'width: 8%'],
//                    'value' => function($model) use ($searchModel) {
//                        return Html::a($model->district->bc_selection_general_application_receive, $searchModel->district_base_url . '=' . $model->district_code . '&DashboardSearchForm[cast]=3', ['target' => '_blank', 'data-pjax' => "0"]);
//                        return $model->district != null ? $model->district->bc_selection_general_application_receive : '';
//                    },
//                ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Highest rated SHG Chairperson',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = 2;
                                                $model->highest_score_in_gp = "Y";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->district_base_url . '=' . $model->district_code . '&DashboardSearchForm[custom_already_group_member]=2&DashboardSearchForm[highest_score_in_gp]=1' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Highest rated Samuh sakhi',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = 5;
                                                $model->highest_score_in_gp = "Y";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->district_base_url . '=' . $model->district_code . '&DashboardSearchForm[custom_already_group_member]=5&DashboardSearchForm[highest_score_in_gp]=1' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Highest rated Samuh Member',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = $searchModel->member;
                                                $model->highest_score_in_gp = "Y";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->district_base_url . '=' . $model->district_code . $searchModel->am . '&DashboardSearchForm[custom_already_group_member]=14&DashboardSearchForm[highest_score_in_gp]=1' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Chairperson of SHG',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = 2;
                                                $model->highest_score_in_gp = "";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->district_base_url . '=' . $model->district_code . '&DashboardSearchForm[custom_already_group_member]=2' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Samuh sakhi',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = 5;
                                                $model->highest_score_in_gp = "";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->district_base_url . '=' . $model->district_code . '&DashboardSearchForm[custom_already_group_member]=5' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Member of SHG',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = $searchModel->member;
                                                $model->highest_score_in_gp = "";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->district_base_url . '=' . $model->district_code . '&DashboardSearchForm[custom_already_group_member]=14' . '' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                    ],
                                ]);
                                ?>
                            <?php } ?>
                            <?php if ($searchModel->report_type == 2) { ?>
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
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'block_name',
                                            'header' => 'Block',
                                            'enableSorting' => false,
//                                            'contentOptions' => ['style' => 'width: 12%'],
                                            'format' => 'raw',
                                            'value' => function ($model) use ($searchModel) {
                                                return $model->block != null ? $model->block->block_name : '';
                                            },
                                        ],
                                        [
                                            'attribute' => 'total_no_of_gp',
                                            'header' => 'Total no of GP',
                                            'format' => 'html',
                                            'enableSorting' => false,
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                return $model->block != null ? $model->block->gram_panchayat_count : '';
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_received',
                                            'header' => 'Total BC application received',
                                            'enableSorting' => false,
//                                            'contentOptions' => ['style' => 'width: 18%'],
                                            'format' => 'raw',
                                            'value' => function ($model) use ($searchModel) {
                                                return Html::a($model->block->bc_selection_application_receive, $searchModel->block_base_url . '=' . $model->block_code, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->block != null ? $model->block->bc_selection_application_receive : '';
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_received',
                                            'header' => 'BC application by filter',
                                            'enableSorting' => false,
//                                            'contentOptions' => ['style' => 'width: 20%'],
                                            'format' => 'raw',
                                            'value' => function ($model) use ($searchModel) {
                                                return Html::a($model->block->bc_selection_application_receive, $searchModel->block_base_url . '=' . $model->block_code . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->application_count;
                                            },
                                        ],
//                [
//                    'attribute' => 'application_gp',
//                    'header' => 'BC application_received on filter GP',
//                    'enableSorting' => false,
//                    'format' => 'raw',
//                    'contentOptions' => ['style' => 'width: 20%'],
//                    'value' => function($model) use ($searchModel) {
//                        return $model->getAppgp($model, $searchModel);
//                        //return $model->application_gp_count;
//                    },
//                ],
//                [
//                    'attribute' => 'application_gp',
//                    'header' => 'SC / ST',
//                    'enableSorting' => false,
//                    'format' => 'raw',
//                    'contentOptions' => ['style' => 'width: 5%'],
//                    'value' => function($model) use ($searchModel) {
//                        return Html::a($model->block->bc_selection_sc_st_application_receive, $searchModel->block_base_url . '=' . $model->block_code . '&DashboardSearchForm[cast]=1', ['target' => '_blank', 'data-pjax' => "0"]);
//                        return $model->block != null ? $model->block->bc_selection_sc_st_application_receive : '';
//                    },
//                ],
//                [
//                    'attribute' => 'application_gp',
//                    'header' => 'OBC',
//                    'enableSorting' => false,
//                    'format' => 'raw',
//                    'contentOptions' => ['style' => 'width: 5%'],
//                    'value' => function($model) use ($searchModel) {
//                        return Html::a($model->block->bc_selection_obc_application_receive, $searchModel->block_base_url . '=' . $model->block_code . '&DashboardSearchForm[cast]=2', ['target' => '_blank', 'data-pjax' => "0"]);
//                        return $model->block != null ? $model->block->bc_selection_obc_application_receive : '';
//                    },
//                ],
//                [
//                    'attribute' => 'application_gp',
//                    'header' => 'General',
//                    'enableSorting' => false,
//                    'format' => 'raw',
//                    'contentOptions' => ['style' => 'width: 5%'],
//                    'value' => function($model) use ($searchModel) {
//                        return Html::a($model->block->bc_selection_general_application_receive, $searchModel->block_base_url . '=' . $model->block_code . '&DashboardSearchForm[cast]=3', ['target' => '_blank', 'data-pjax' => "0"]);
//                        return $model->block != null ? $model->block->bc_selection_general_application_receive : '';
//                    },
//                ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Highest rated SHG Chairperson',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = 2;
                                                $model->highest_score_in_gp = "Y";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->block_base_url . '=' . $model->block_code . '&DashboardSearchForm[custom_already_group_member]=2&DashboardSearchForm[highest_score_in_gp]=1' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Highest rated Samuh sakhi',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = 5;
                                                $model->highest_score_in_gp = "Y";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->block_base_url . '=' . $model->block_code . '&DashboardSearchForm[custom_already_group_member]=5&DashboardSearchForm[highest_score_in_gp]=1' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Highest rated Samuh Member',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = $searchModel->member;
                                                $model->highest_score_in_gp = "Y";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->block_base_url . '=' . $model->block_code . '&DashboardSearchForm[custom_already_group_member]=14' . '&DashboardSearchForm[highest_score_in_gp]=1' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Chairperson of SHG',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = 2;
                                                $model->highest_score_in_gp = "";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->block_base_url . '=' . $model->block_code . '&DashboardSearchForm[custom_already_group_member]=2' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Samuh sakhi',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = 5;
                                                $model->highest_score_in_gp = "";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->block_base_url . '=' . $model->block_code . '&DashboardSearchForm[custom_already_group_member]=5' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Member of SHG',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = $searchModel->member;
                                                $model->highest_score_in_gp = "";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->block_base_url . '=' . $model->block_code . '&DashboardSearchForm[custom_already_group_member]=14' . '' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                    ],
                                ]);
                                ?>
                            <?php } ?>
                            <?php if ($searchModel->report_type == 3) { ?>
                                <?=
                                GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
//                                    'pjax' => TRUE,
//                                    'floatHeader' => true,
//                                    'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'header' => 'Gram panchayat',
                                            'enableSorting' => false,
//                                            'contentOptions' => ['style' => 'width: 18%'],
                                            'format' => 'raw',
                                            'value' => function ($model) use ($searchModel) {
                                                return $model->gp != null ? $model->gp->gram_panchayat_name : '';
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_received',
                                            'header' => 'Total BC application received',
                                            'enableSorting' => false,
//                                            'contentOptions' => ['style' => 'width: 18%'],
                                            'format' => 'raw',
                                            'value' => function ($model) use ($searchModel) {
                                                return Html::a($model->gp->bc_selection_application_receive, $searchModel->gp_base_url . '=' . $model->gram_panchayat_code, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->gp != null ? $model->gp->bc_selection_application_receive : '';
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_received',
                                            'header' => 'BC application by filter',
                                            'enableSorting' => false,
//                                            'contentOptions' => ['style' => 'width: 18%'],
                                            'format' => 'raw',
                                            'value' => function ($model) use ($searchModel) {
                                                return Html::a($model->application_count, $searchModel->gp_base_url . '=' . $model->gram_panchayat_code . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->application_count;
                                            },
                                        ],
//                [
//                    'attribute' => 'application_gp',
//                    'header' => 'SC / ST',
//                    'enableSorting' => false,
//                    'format' => 'raw',
//                    'contentOptions' => ['style' => 'width: 8%'],
//                    'value' => function($model) use ($searchModel) {
//                        return Html::a($model->gp->bc_selection_sc_st_application_receive, $searchModel->gp_base_url . '=' . $model->gram_panchayat_code . '&DashboardSearchForm[cast]=1', ['target' => '_blank', 'data-pjax' => "0"]);
//                        return $model->gp != null ? $model->gp->bc_selection_sc_st_application_receive : '';
//                    },
//                ],
//                [
//                    'attribute' => 'application_gp',
//                    'header' => 'OBC',
//                    'enableSorting' => false,
//                    'format' => 'raw',
//                    'contentOptions' => ['style' => 'width: 8%'],
//                    'value' => function($model) use ($searchModel) {
//                        return Html::a($model->gp->bc_selection_obc_application_receive, $searchModel->gp_base_url . '=' . $model->gram_panchayat_code . '&DashboardSearchForm[cast]=2', ['target' => '_blank', 'data-pjax' => "0"]);
//                        return $model->gp != null ? $model->gp->bc_selection_obc_application_receive : '';
//                    },
//                ],
//                [
//                    'attribute' => 'application_gp',
//                    'header' => 'General',
//                    'enableSorting' => false,
//                    'format' => 'raw',
//                    'contentOptions' => ['style' => 'width: 8%'],
//                    'value' => function($model) use ($searchModel) {
//                        return Html::a($model->gp->bc_selection_general_application_receive, $searchModel->gp_base_url . '=' . $model->gram_panchayat_code . '&DashboardSearchForm[cast]=3', ['target' => '_blank', 'data-pjax' => "0"]);
//                        return $model->gp != null ? $model->gp->bc_selection_general_application_receive : '';
//                    },
//                ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Highest rated SHG Chairperson',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = 2;
                                                $model->highest_score_in_gp = "Y";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->gp_base_url . '=' . $model->gram_panchayat_code . '&DashboardSearchForm[custom_already_group_member]=2&DashboardSearchForm[highest_score_in_gp]=1' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Highest rated Samuh sakhi',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = 5;
                                                $model->highest_score_in_gp = "Y";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->gp_base_url . '=' . $model->gram_panchayat_code . '&DashboardSearchForm[custom_already_group_member]=5&DashboardSearchForm[highest_score_in_gp]=1' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Highest rated Samuh Member',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = $searchModel->member;
                                                $model->highest_score_in_gp = "Y";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->gp_base_url . '=' . $model->gram_panchayat_code . '&DashboardSearchForm[custom_already_group_member]=14' . '&DashboardSearchForm[highest_score_in_gp]=1' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Chairperson of SHG',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = 2;
                                                $model->highest_score_in_gp = "";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->gp_base_url . '=' . $model->gram_panchayat_code . '&DashboardSearchForm[custom_already_group_member]=2' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Samuh sakhi',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = 5;
                                                $model->highest_score_in_gp = "";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->gp_base_url . '=' . $model->gram_panchayat_code . '&DashboardSearchForm[custom_already_group_member]=5' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                        [
                                            'attribute' => 'application_gp',
                                            'header' => 'Member of SHG',
                                            'enableSorting' => false,
                                            'format' => 'raw',
//                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'value' => function ($model) use ($searchModel) {
                                                $model->already_group_member = $searchModel->member;
                                                $model->highest_score_in_gp = "";
                                                return Html::a($model->getAppgp($model, $searchModel), $searchModel->gp_base_url . '=' . $model->gram_panchayat_code . '&DashboardSearchForm[custom_already_group_member]=14' . '' . $searchModel->filter, ['target' => '_blank', 'data-pjax' => "0"]);
                                                return $model->getAppgp($model, $searchModel);
                                            },
                                        ],
                                    ],
                                ]);
                                ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/selection/dashboard/report"});
     $("#Searchform").attr("data-pjax", "True");    
    $(this).closest('form').submit();
});            
        
JS;
$this->registerJs($script);
?>      


<?php Pjax::end(); ?>    


