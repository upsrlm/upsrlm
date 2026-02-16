<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use bc\models\PartnerBankDistrictPlanningDetail;

$provider = new yii\data\ActiveDataProvider([
    'query' => PartnerBankDistrictPlanningDetail::find()->where(['partner_bank_district_planning_id' => $model->id])->andWhere(['month' => $model->cmonth, 'year' => $model->cyear]),
        ]);
?>


<div class="box">

    <?=
    GridView::widget([
        'dataProvider' => $provider,
        'layout' => "{items}",
        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
        'id' => 'grid-data',
        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
        'pjax' => TRUE,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: %', 'class' => 'text-center']],
            [
                'attribute' => 'week',
                'label' => 'Week',
                'enableSorting' => false,
                'value' => function ($model) {
                    return 'Week ' . $model->week;
                },
            ],
            [
                'attribute' => 'onboarding',
                'enableSorting' => false,
                'value' => function ($model) {
                    return $model->onboarding;
                },
            ],
            [
                'attribute' => 'ac_opening',
                'header'=>'A/c opening',
                'enableSorting' => false,
                'value' => function ($model) {
                    return $model->ac_opening;
                },
            ],
            [
                'attribute' => 'supply_equipment',
                'enableSorting' => false,
                'value' => function ($model) {
                    return $model->supply_equipment;
                },
            ],
            [
                'attribute' => 'onboarding',
                'enableSorting' => false,
                'value' => function ($model) {
                    return $model->operational;
                },
            ],
        ],
    ]);
    ?>

</div>
