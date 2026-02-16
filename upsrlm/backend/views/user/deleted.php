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

$this->title = 'Users List';
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


                    <?php echo $this->render('_searchdeleted', ['model' => $searchModel]); ?>
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
                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false
                            ],
                            [
                                'attribute' => 'email',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'enableSorting' => false
                            ],
                            [
                                'attribute' => 'role',
                                'contentOptions' => ['style' => 'width: 12%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->urole != null ? $model->urole->role_name : '';
                                },
                            ],
                            [
                                'attribute' => 'Location',
                                'header' => 'Location',
                                'contentOptions' => ['style' => 'width: 20%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $html = '';
                                    if (in_array($model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->districts, 'district.district_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                                        
                                    } elseif (in_array($model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                                        
                                    } elseif (in_array($model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->division, 'division.division_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_DM])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->districts, 'district.district_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_DSO])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->districts, 'district.district_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_CDO])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->districts, 'district.district_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->districts, 'district.district_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->districts, 'district.district_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_DC_NRLM])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->districts, 'district.district_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_BDO, MasterRole::ROLE_BMMU])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->blocks, 'district.district_name')));
                                        $html .= ' , ' . implode(', ', array_unique(ArrayHelper::getColumn($model->blocks, 'block.block_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_GP_ADHIKARI])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->blocks, 'district.district_name')));
                                        $html .= ' , ' . implode(', ', array_unique(ArrayHelper::getColumn($model->blocks, 'block.block_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->grampanchayat, 'district.district_name')));
                                        $html .= ' , ' . implode(', ', array_unique(ArrayHelper::getColumn($model->grampanchayat, 'block.block_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->grampanchayat, 'district.district_name')));
                                        $html .= ' , ' . implode(', ', array_unique(ArrayHelper::getColumn($model->grampanchayat, 'block.block_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->ulbs, 'district.district_name')));
                                        $html .= ' , ' . implode(', ', array_unique(ArrayHelper::getColumn($model->ulbs, 'ulb.ulb_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_URBAN_SECONDARY_ENUMERATOR])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->ulbs, 'district.district_name')));
                                        $html .= ' , ' . implode(', ', array_unique(ArrayHelper::getColumn($model->ulbs, 'ulb.ulb_name')));
                                    } elseif (in_array($model->role, [MasterRole::ROLE_MC])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->ulbs, 'district.district_name')));
                                        $html .= ' , ' . implode(', ', array_unique(ArrayHelper::getColumn($model->ulbs, 'ulb.ulb_name')));
                                    } else {
                                        
                                    }
                                    return $html;
                                },
                            ],
                            [
                                'attribute' => 'profile_status',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->userprofilestatus;
                                },
                            ],
                            [
                                'attribute' => 'password',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'visible' => 0, //in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                'value' => function ($model) {
                                    return substr($model->upd, 3);
                                },
                            ],
                            [
                                'attribute' => 'Action',
                                'format' => 'raw',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN]),
                                'contentOptions' => ['style' => 'width: 18%'],
                                'value' => function ($model) {
                                    $html = '';

                                    $html .= Html::a('<i class="fal fa fa-edit"></i>', ['/user/update', 'userid' => $model->id], [
                                                'title' => 'Update User',
                                                'data-pjax' => "0",
                                                'class' => 'btn btn-sm btn-info',
                                            ]) . ' ';

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