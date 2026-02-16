<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use bc\models\master\MasterBlock;
use bc\models\master\MasterBlockSearch;

$searchModels = new MasterBlockSearch();
$searchModels->district_code = $model->district_code;
$dataProvider = $searchModels->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
?>
<div class="pfa-domestic-premium-freight-index">


    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 50px;', 'data-title' => '#']],
            [
                'attribute' => 'block_name',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 20%'],
                'contentOptions' => ['data-title' => 'block name'],
                'value' => function ($model) {
                    return $model->block_name;
                }
            ],
            [
                'attribute' => 'Total Hhs Covered',
                'header' => 'BC list',
                'format' => 'raw',
                'contentOptions' => ['data-title' => 'BC list'],
                'value' => function ($model) use ($searchModel) {

                    //return "<a data-pjax ='0'   target='_blank' href='/nfsaSurvey/data/survey?DashboardSearchForm[district_code]=$model->district_code&DashboardSearchForm[block_code]=$model->block_code&DashboardSearchForm[area]=1$searchModel->filter_uri' >Download <a>";
                    return "<a data-pjax ='0'   target='_blank' href='/selection/bcdata/reportpdf?DashboardSearchForm[district_code]=$model->district_code&DashboardSearchForm[block_code]=$model->block_code'><i class='fal fa-download'></i> Download <a>";
                }
            ],
        ],
    ]);
    ?>

</div>