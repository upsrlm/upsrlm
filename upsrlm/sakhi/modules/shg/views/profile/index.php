<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'SHG का विवरण';
\yii\web\YiiAsset::register($this);
$app = new \sakhi\components\App();
?>
<div class="subheader">
    <h1 class="subheader-title">
        SHG का विवरण
        <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/profile/update', ['shgid' => $model->cbo_shg_id])) { ?>
            <a href="/shg/profile/update?shgid=<?= $model->cbo_shg_id ?>" class="text-right btn btn-info btn-sm float-right"><i class="fal fa-edit"></i></a>
        <?php } ?>
    </h1>
</div>
<div class="card mb-2">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'name_of_shg',
                'value' => function ($model) {
                    return $model->name_of_shg;
                },
            ],
            [
                'attribute' => 'division_name',
                'value' => function ($model) {
                    return $model->division_name;
                },
            ],
            [
                'attribute' => 'district_name',
                'value' => function ($model) {
                    return $model->district_name;
                },
            ],
            [
                'attribute' => 'block_name',
                'value' => function ($model) {
                    return $model->block_name;
                },
            ],
            [
                'attribute' => 'gram_panchayat_name',
                'value' => function ($model) {
                    return $model->gram_panchayat_name;
                },
            ],
            [
                'attribute' => 'village_name',
                'value' => function ($model) {
                    return $model->village_name;
                },
            ],
            [
                'attribute' => 'hamlet',
                'value' => function ($model) {
                    return $model->hamlet;
                },
            ],
            [
                'attribute' => 'no_of_members',
                'value' => function ($model) {
                    return $model->no_of_members;
                },
            ],
            [
                'attribute' => 'date_of_formation',
                'value' => function ($model) {
                    return isset($model->date_of_formation)?$model->date_of_formation:'';
                },
            ],
        ],
    ])
    ?>
</div>

