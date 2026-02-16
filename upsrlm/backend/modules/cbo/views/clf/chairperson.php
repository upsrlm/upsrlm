<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use common\models\master\MasterRole;
use cbo\models\CboClf;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "CLF's Member";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <div class='panel-body'>
        <?php
        Pjax::begin([
            'id' => 'grid-data',
            'enablePushState' => FALSE,
            'enableReplaceState' => FALSE,
            'timeout' => false,
        ]);
        ?>
        <div class="row-fluid">
            <div class="col-lg-4">
                District : <?= $model->district_name ?>
            </div>
            <div class="col-lg-4">
                Block : <?= $model->block_name ?> 
            </div>
        </div>
        <div class="clearfix"></div>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "\n{items}\n{summary}",
            'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
            'id' => 'grid-data',
            'pjax' => TRUE,
            'floatHeader' => true,
            'floatHeaderOptions' => ['scrollingTop' => '50'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
//                [
//                    'attribute' => 'cbo_clf_id',
//                    'enableSorting' => false,
//                    'value' => function ($model) {
//                        return $model->clf != null ? $model->clf->name_of_clf : '';
//                    }
//                ],
//                [
//                    'attribute' => 'district',
//                    'enableSorting' => false,
//                    'value' => function ($model) {
//                        return $model->clf != null ? $model->clf->district_name : '';
//                    }
//                ],
//                [
//                    'attribute' => 'block',
//                    'enableSorting' => false,
//                    'value' => function ($model) {
//                        return $model->clf != null ? $model->clf->block_name : '';
//                    }
//                ],
                [
                    'attribute' => 'name',
                    'contentOptions' => ['style' => 'width: 10%'],
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'mobile_no',
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'bank_operator',
                    'enableSorting' => false,
                    'value' => function ($model) {
                        return $model->operator;
                    }
                ],
                [
                    'attribute' => 'role',
                    'enableSorting' => false,
                    'value' => function ($model) {
                        return $model->memberrole != null ? $model->memberrole->role : '';
                    }
                ],
                [
                    'attribute' => 'cbo_vo_id',
                    'enableSorting' => false,
                    'value' => function ($model) {
                        return $model->vo != null ? $model->vo->name_of_vo : '';
                    }
                ],
                [
                    'attribute' => 'cbo_vo_off_bearer',
                    'enableSorting' => false,
                    'value' => function ($model) {
                        return $model->vooffbearer;
                    }
                ],
                [
                    'attribute' => 'cbo_shg_id',
                    'enableSorting' => false,
                    'value' => function ($model) {
                        return $model->shg != null ? $model->shg->name_of_shg : '';
                    }
                ],
                [
                    'attribute' => 'cbo_shg_off_bearer',
                    'enableSorting' => false,
                    'value' => function ($model) {
                        return $model->shgoffbearer;
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'User',
                    'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM]),
                    'template' => '{makeuser}',
                    'buttons' => [
                        'makeuser' => function ($url, $model) {
                            return $model->user_id == null ? Html::a('<span class="fa fa-plus"></span> Create CBO user', ['/cbo/clf/makeuser?clfmemberid=' . $model->id], [
                                'data-pjax' => "0",
                                'class' => 'btn btn-sm btn-info',
                                'data' => [
                                    'confirm' => 'Are you absolutely sure create cbo user of this clf member?',
                                    'method' => 'post',
                                ],
                            ]) : 'Yes';
                        },
                    ]
                ],
            ],
        ]);
        ?>

        <?php Pjax::end(); ?> 
    </div>
</div>
