<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\User;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MasterVillageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ' Villages List';
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
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 6s%']],
                            [
                                'attribute' => 'district_code',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'label' => 'District Code',
                                'value' => function ($data) {
                                    return $data->district_code ? $data->district_code : '';
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'label' => 'District Name',
                                'value' => function ($data) {
                                    return $data->district_name ? $data->district_name : '';
                                }
                            ],
//                    [
//                        'attribute' => 'sub_district_code',
//                        'format' => 'raw',
//                        'enableSorting' => false,
//                        'label' => 'Sub District Code',
//                        'value' => function($data) {
//                            return $data->sub_district_code ? $data->sub_district_code : '';
//                        }
//                    ],
//                    [
//                        'attribute' => 'sub_district_name',
//                        'format' => 'raw',
//                        'enableSorting' => false,
//                        'label' => 'Sub District Name',
//                        'value' => function($data) {
//                            return $data->sub_district_name ? $data->sub_district_name : '';
//                        }
//                    ],
                            [
                                'attribute' => 'block_code',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'label' => 'Block Code',
                                'value' => function ($data) {
                                    return $data->block_code ? $data->block_code : '';
                                }
                            ],
                            [
                                'attribute' => 'block_name',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'label' => 'Block Name',
                                'value' => function ($data) {
                                    return $data->block_name ? $data->block_name : '';
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_code',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'label' => 'Panchayat Code',
                                'value' => function ($data) {
                                    return $data->gram_panchayat_code ? $data->gram_panchayat_code : '';
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'label' => 'Panchayat Name',
                                'value' => function ($data) {
                                    return $data->gram_panchayat_name ? $data->gram_panchayat_name : '';
                                }
                            ],
                            [
                                'attribute' => 'village_code',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'label' => 'Village Code',
                                'value' => function ($data) {
                                    return $data->village_code ? $data->village_code : '';
                                }
                            ],
                            [
                                'attribute' => 'village_name',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'label' => 'Village Name',
                                'value' => function ($data) {
                                    return $data->village_name ? $data->village_name : '';
                                }
                            ],
                        //['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>

                    <?php Pjax::end(); ?> 
                </div>
            </div>  
        </div>
    </div>

</div>