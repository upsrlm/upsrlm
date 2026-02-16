<?php

use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use common\models\User;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\master\MasterBlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blocks';
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
                    <?php echo $this->render('_bsearch', ['model' => $searchModel]); ?>
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
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%']],
                            [
                                'attribute' => 'District',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district != null ? $model->district->district_name : '';
                                },
                            ],
                            [
                                'attribute' => 'block_name',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'Total Registration',
                                'header' => 'Total Registration',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'Total Registration'],
                                'value' => function ($model) {
                                    return $model->getBcall()->count();
                                }
                            ],
                            [
                                'attribute' => 'Registration Start',
                                'header' => 'Registration Start',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'Registration Start'],
                                'value' => function ($model) {
                                    return $model->getBasicprofile()->count();
                                }
                            ],
                            [
                                'attribute' => 'Application complete',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'Application complete'],
                                'value' => function ($model) {
                                    return $model->getPart4()->count();
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
