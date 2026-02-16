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

$this->title = 'RSETIs District Unit';
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
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                            ],
                            [
                                'attribute' => 'name',
                                'format' => 'raw',
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'username',
                                'header' => 'Mobile No.',
                                'enableSorting' => false
                            ],
                            [
                                'attribute' => 'role',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->urole != null ? $model->urole->role_name : '';
                                },
                            ],
                            [
                                'attribute' => 'Location',
                                'header' => 'District',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $html = '';
                                    if (in_array($model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->districts, 'district.district_name')));
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
