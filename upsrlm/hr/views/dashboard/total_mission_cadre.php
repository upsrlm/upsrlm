<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'Total regd. Mission cadre' ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                'id' => 'grid-data',
                'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
//                'pjax' => TRUE,
//                'floatHeader' => true,
//                'floatHeaderOptions' => ['scrollingTop' => '50'],
                'pager' => [
                    'options' => ['class' => 'pagination'],
                    'prevPageLabel' => 'Previous',
                    'nextPageLabel' => 'Next',
                    'firstPageLabel' => 'First',
                    'lastPageLabel' => 'Last',
                    'nextPageCssClass' => 'paginate_button page-item',
                    'prevPageCssClass' => 'paginate_button page-item',
                    'firstPageCssClass' => 'paginate_button page-item',
                    'lastPageCssClass' => 'paginate_button page-item',
                    'maxButtonCount' => 10,
                ],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
//                        'contentOptions' => ['style' => 'width: 4%']
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'enableSorting' => false,
//                        'contentOptions' => ['style' => 'width: 30%'],
                        'value' => function ($model) {
                            return '<a href="/user/view?userid=' . $model->id . '" data-pjax="0">' . $model->name . '</a>';
                        }
                    ],
                    [
                        'attribute' => 'username',
                        'header' => 'Login',
//                        'contentOptions' => ['style' => 'width: 15%'],
                        'enableSorting' => false
                    ],
                    [
                        'attribute' => 'email',
//                        'contentOptions' => ['style' => 'width: 15%'],
                        'enableSorting' => false
                    ],
                    [
                        'attribute' => 'role',
//                        'contentOptions' => ['style' => 'width: 12%'],
                        'enableSorting' => false,
                        'value' => function ($model) {
                            return $model->urole != null ? $model->urole->role_name : '';
                        },
                    ],
                    [
                        'attribute' => 'profile_status',
//                        'contentOptions' => ['style' => 'width: 10%'],
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function ($model) {
                            return $model->userprofilestatus;
                        },
                    ],
                    [
                        'attribute' => 'verification_status',
//                        'contentOptions' => ['style' => 'width: 10%'],
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function ($model) {
                            return $model->profile != null ? $model->profile->verificationstatus : '';
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'visible' => isset(Yii::$app->user->identity) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_JMD, MasterRole::ROLE_HR_ADMIN]),
                        'template' => '{view}{verify}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return yii\helpers\Html::button('<i class="fal fa-eye"></i> View', ['id' => 'add-score-' . $model->id, 'class' => 'btn btn-sm btn-info popb', 'value' => '/user/view?userid=' . $model->id, 'name' => 'takeaction', 'title' => '' . $model->name]) . ' ';
                            },
                            'verify' => function ($url, $model) {
                                return ($model->profile != null and $model->profile_status == 1 and $model->profile->verification_status == null) ? yii\helpers\Html::button('<i class="fal fa-circle-o-notch"></i> Verify', ['id' => 'add-score-' . $model->id, 'class' => 'btn btn-sm btn-danger popb', 'value' => '/user/verify?userid=' . $model->id, 'name' => 'takeaction', 'title' => 'Verify profile of ' . $model->name]) . ' ' : '';
                            },
                        ]
                    ],
                   
                ],
            ]);
            ?>
                </div>
            </div>
        </div>    
    </div>
</div>

