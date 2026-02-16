<?php

use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use app\models\UserModel;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\master\MasterBlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'District';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="master-block-index">

    <div style="text-align: right"> Time : <?= date('d-m-Y h:i:s') ?></div><br/>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
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
                ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%']],
                [
                    'attribute' => 'district_code',
                    'contentOptions' => ['style' => 'width: 15%'],
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'District',
                    'contentOptions' => ['style' => 'width: 15%'],
                    'enableSorting' => false,
                    'value' => function ($model) {
                        return $model->district_name;
                    },
                ],
                [
                    'attribute' => 'No of GPs',
                    'header' => 'No of GPs',
                    'format' => 'raw',
                    'contentOptions' => ['data-title' => 'No of GPs'],
                    'value' => function($model) {
                        return $model->getGp()->count();
                    }
                ],
                [
                    'attribute' => 'No of GPs with zero registration',
                    'header' => 'No of GPs with zero registration',
                    'format' => 'raw',
                    'contentOptions' => ['data-title' => 'No of GPs with zero registration'],
                    'value' => function($model) {
                        return $model->getGpnoreg()->count();
                    }
                ],
                
            ],
        ]);
        ?>


        </div>


