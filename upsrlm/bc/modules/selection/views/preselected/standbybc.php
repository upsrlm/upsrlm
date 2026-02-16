<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
?>
<div class="nfsa-base-survey-index">

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{summary}{items}",
        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
        'id' => 'grid-data',
        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
        'pjax' => TRUE,
//        'floatHeader' => true,
//        'floatHeaderOptions' => ['scrollingTop' => '50'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
            [
                'attribute' => 'name',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 12%'],
                'format' => 'raw',
                'value' => function ($model) {
                    $status = '';
                    return $model->name;
                    return Html::a($model->first_name, "/selection/data/application/view?id=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]) . $status;
                },
            ],
            [
                'attribute' => 'guardian_name',
                'format' => 'html',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 12%'],
                'value' => function ($model) {
                    return $model->guardian_name != null ? $model->guardian_name : '';
                },
            ],
            [
                'attribute' => 'mobile_number',
                'contentOptions' => ['style' => 'width: 8%'],
                'enableSorting' => false,
            ],
            [
                'attribute' => 'gender',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 5%'],
                'format' => 'raw',
                'value' => function ($model) {

                    return $model->genderrel != null ? $model->genderrel->name_eng : '';
                },
            ],
            [
                'attribute' => 'age',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 5%'],
                'format' => 'raw',
                'value' => function ($model) {

                    return $model->age != null ? $model->age : '';
                },
            ],
            [
                'attribute' => 'Social Category',
                'enableSorting' => false,
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 8%'],
                'value' => function ($model) {
                    return $model->castrel != null ? $model->castrel->name_eng : '';
                },
            ],
            [
                'attribute' => 'reading_skills',
                'enableSorting' => false,
                'label' => 'Education',
                'format' => 'html',
                'value' => function ($model) {

                    return $model->readingskills != null ? $model->readingskills->name_eng : '';
                },
            ],
            [
                'attribute' => 'member',
                'enableSorting' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return isset($model->agm) ? $model->agm->name_eng : '';
                }
            ],
            [
                'attribute' => 'SHG Name',
                'header' => 'BC SHG Name',
                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_DC_NRLM]),
                'enableSorting' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return isset($model->your_group_name) ? $model->your_group_name : '';
                }
            ],
            [
                'attribute' => 'address',
                'enableSorting' => false,
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 20%'],
                'value' => function ($model) {
                    return $model->fulladdress;
                },
            ],
            [
                'attribute' => 'OTP Verified mobile no',
                'enableSorting' => false,
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 8%'],
                'value' => function ($model) {
                    return $model->user != null ? $model->user->mobile_no : '';
                },
            ],
        ],
    ]);
    ?>


</div>



