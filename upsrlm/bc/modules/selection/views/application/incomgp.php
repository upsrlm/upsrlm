<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

?>
<div class="master-gram-panchayat-index">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'id' => 'grid-datar',
                'layout' => "<div class=\"row\"><div class=\"col-lg-6\">{summary}</div></div>{items}<div class=\"row\"><div class=\"col-lg-6\">{summary}</div><div class=\"col-lg-6 pull-right\">{pager}</div></div>",
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
                    ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 6%']],
                    [
                        'attribute' => 'gram_panchayat_name',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->gram_panchayat_name;
                        }
                    ],
                    [
                        'attribute' => 'block_name',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($model) {
                            return $model->block_name;
                        }
                    ],
                    [
                        'attribute' => 'District',
                        //'contentOptions' => ['style' => 'width: 15%'],
                        'enableSorting' => false,
                        'value' => function ($model) {
                            return $model->district != null ? $model->district->district_name : '';
                        },
                    ],
                    [
                        'attribute' => 'Total Registration',
                        'header' => 'Total Registration',
                        'format' => 'raw',
                        'contentOptions' => ['data-title' => 'Total Registration'],
                        'value' => function($model) {
                            return $model->getBcall()->count();
                        }
                    ],
                    
                    
                ],
            ]);
            ?>


</div>
