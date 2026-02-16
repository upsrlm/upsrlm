<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\User;
use yii\bootstrap\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'District Consultants';
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

                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
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


                    <?php echo $this->render('_searchdm', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-6"></div>
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
                            ],
                            [
                                'attribute' => 'username',
                                'header' => 'Login',
//                        'contentOptions' => ['style' => 'width: 10%'],
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
                                'attribute' => 'Location',
                                'header' => 'District',
//                        'contentOptions' => ['style' => 'width: 20%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $html = '';
                                    $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->districts, 'district.district_name')));
                                    return $html;
                                },
                            ],
                            [
                                'attribute' => 'login_method',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'visible' => 1, //in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                'value' => function ($model) {
                                    return $model->loginmethod;
//                            return substr($model->upd, 3);
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
                                'attribute' => 'Action',
                                'format' => 'raw',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN]),
//                        'contentOptions' => ['style' => 'width: 18%'],
                                'value' => function ($model) {
                                    $html = '';
                                    $html .= Html::a('<i class="fal fa fa-eye"></i>', ['/user/view', 'userid' => $model->id], [
                                                'title' => 'View District Project Managers (DPM) User',
                                                'data-pjax' => "0",
                                                'class' => 'btn btn-sm btn-info mb-2',
                                            ]) . ' ';
                                    $html .= Html::a('<i class="fal fa fa-edit"></i>', ['/user/updatedm', 'userid' => $model->id], [
                                                'title' => 'Update District Project Managers (DPM) User',
                                                'data-pjax' => "0",
                                                'class' => 'btn btn-sm btn-info',
                                            ]) . ' ';
                                    if ($model->role != MasterRole::ROLE_CBO_USER) {
                                        $html .= Html::a('<span class="fal fa fa-exchange"></span>', ['/user/changerole', 'userid' => $model->id], [
                                                    'title' => 'Change Role',
                                                    'data-pjax' => "0",
                                                    'class' => 'btn btn-sm btn-info mb-2',
                                                    'data-confirm' => 'Are you sure you want to change role of this user?',
                                                    'data-method' => 'POST',
                                                ]) . ' ';
                                    }
                                    $html .= Html::a('<span class="fal fa fa-sign-in"></span>', ['/user/changeloginmethod', 'userid' => $model->id], [
                                                'title' => 'Change Login Method',
                                                'data-pjax' => "0",
                                                'class' => 'btn btn-sm btn-info mb-2',
                                                'data-confirm' => 'Are you sure you want to change login method for this user?',
                                                'data-method' => 'POST',
                                            ]) . ' ';
                                    $html .= Html::a('<span class="fal fa fa-circle"></span>', ['/user/resetpassword', 'userid' => $model->id], [
                                                'title' => 'Reset Password',
                                                'data-pjax' => "0",
                                                'class' => 'btn btn-sm btn-info mb-2',
                                                'data-confirm' => 'Are you sure you want to Reset Password?',
                                                'data-method' => 'POST',
                                            ]) . ' ';
                                    if ($model->status == User::STATUS_INACTIVE) {
                                        $html .= Html::a('Inactive', ['/user/block', 'userid' => $model->id], [
                                                    'class' => 'btn btn-sm btn-success mb-2',
                                                    'data-pjax' => "0",
                                                    'data-method' => 'post',
                                                    'data-confirm' => 'Are you sure you want to Active this User?',
                                        ]);
                                    } if ($model->status == User::STATUS_ACTIVE) {
                                        $html .= Html::a('Active', ['/user/block', 'userid' => $model->id], [
                                                    'class' => 'btn btn-sm btn-danger mb-2',
                                                    'data-pjax' => "0",
                                                    'data-method' => 'post',
                                                    'data-confirm' => 'Are you sure you want to Inactive this User?',
                                        ]);
                                        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
                                            $html .= ' ' . Html::a('<span class="glyphicon glyphicon-user fal fa-user"></span>', ['/user/switch', 'id' => $model->id], [
                                                        'class' => 'btn btn-sm btn-danger mb-2',
                                                        'title' => 'Become this user',
                                                        'data-confirm' => 'Are you sure you want to switch to this user for the rest of this Session?',
                                                        'data-method' => 'POST',
                                            ]);
                                        }
                                    }

                                    return $html;
                                },
                            ],
                        ],
                    ]);
                    ?>
                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div>
    </div>
</div>
