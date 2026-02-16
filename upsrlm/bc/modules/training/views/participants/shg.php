<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "SHG's";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
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

                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "\n{items}\n{pager}\n{summary}",
                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                    'id' => 'grid-data',
                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                    'pjax' => TRUE,
                    'floatHeader' => true,
                    'floatHeaderOptions' => ['scrollingTop' => '50'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                        [
                            'attribute' => 'name_of_shg',
                            'contentOptions' => ['style' => 'width: 8%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'district_name',
                            'label' => 'District',
                            'contentOptions' => ['style' => 'width: 8%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'block_name',
                            'label' => 'Block ',
                            'contentOptions' => ['style' => 'width: 8%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'gram_panchayat_name',
                            'label' => 'Gram Panchayat ',
                            'contentOptions' => ['style' => 'width: 10%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'village_name',
                            'label' => 'Rev. Village',
                            'contentOptions' => ['style' => 'width: 10%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'hamlet',
                            'contentOptions' => ['style' => 'width: 10%'],
                            'enableSorting' => false,
                        ],
                        [
                            'attribute' => 'chaire_person_name',
                            'label' => 'Chair Person',
                            'contentOptions' => ['style' => 'width: 10%'],
                            'format' => 'html',
                            'enableSorting' => false,
                            'value' => function ($model) {
                                return $model->chaire_person_name . "<br/>" . $model->chaire_person_mobile_no;
                            }
                        ],
                        [
                            'attribute' => 'secretary_name',
                            'label' => 'Secretary',
                            'contentOptions' => ['style' => 'width: 10%'],
                            'format' => 'html',
                            'enableSorting' => false,
                            'value' => function ($model) {
                                return $model->secretary_name . "<br/>" . $model->secretary_mobile_no;
                            }
                        ],
                        [
                            'attribute' => 'treasurer_name',
                            'label' => 'Treasurer',
                            'contentOptions' => ['style' => 'width: 10%'],
                            'format' => 'html',
                            'enableSorting' => false,
                            'value' => function ($model) {
                                return $model->treasurer_name . "<br/>" . $model->treasurer_mobile_no;
                            }
                        ],
                    ],
                ]);
                ?>

                <?php Pjax::end(); ?> 
            </div>
        </div>
    </div> 
</div>     
