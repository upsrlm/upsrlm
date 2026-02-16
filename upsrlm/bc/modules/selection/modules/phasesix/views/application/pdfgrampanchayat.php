<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\helpers\Utility;
?>
<div class="master-gram-panchayat-index">
    <div style="text-align: right"> Time : <?= date('d-m-Y h:i:s') ?></div><br/>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'grid-datar',
        'layout' => "{items}",
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 6%']],
            [
                'attribute' => 'gram_panchayat_name',
                'format' => 'raw',
                'enableSorting' => false,
                'value' => function ($model) {
                    return $model->gram_panchayat_name;
                }
            ],
            [
                'attribute' => 'block_name',
                'format' => 'raw',
                'enableSorting' => false,
                'value' => function ($model) {
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
                'attribute' => 'Application complete',
                'format' => 'raw',
                'contentOptions' => ['data-title' => 'Application complete'],
                'value' => function ($model) {
                    return $model->gpdetail->six_complete;
                }
            ],
        ],
    ]);
    ?>
</div>

