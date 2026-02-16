<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'SHG का विवरण';
\yii\web\YiiAsset::register($this);
?>
<div class="subheader">
    <h1 class="subheader-title">
        SHG का विवरण   
        <a href="/shg/default/updateprofile?shgid=<?= $model->cbo_shg_id ?>&profileid=<?= $model->id ?>" class="text-right btn btn-info btn-sm float-right"><i class="fal fa-edit"></i></a>
    </h1>
</div>
<div class="card mb-2">
    <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'name_of_shg',
                    'label' => 'SHG का नाम',
                    'value' => function ($model) {
                        return $model->name_of_shg;
                    },
                ],
                [
                    'attribute' => 'division_name',
                    'label' => 'प्रभाग का नाम',
                    'value' => function ($model) {
                        return $model->division_name;
                    },
                ],
                [
                    'attribute' => 'district_name',
                    'label' => 'जिला',
                    'value' => function ($model) {
                        return $model->district_name;
                    },
                ],
                [
                    'attribute' => 'block_name',
                    'label' => 'ब्लाक',
                    'value' => function ($model) {
                        return $model->block_name;
                    },
                ],
                [
                    'attribute' => 'gram_panchayat_name',
                    'label' => 'ग्राम पंचायत',
                    'value' => function ($model) {
                        return $model->gram_panchayat_name;
                    },
                ],
                [
                    'attribute' => 'village_name',
                    'label' => 'ग्राम',
                    'value' => function ($model) {
                        return $model->village_name;
                    },
                ],
                [
                    'attribute' => 'hamlet',
                    'label' => 'मजरा/ टोला',
                    'value' => function ($model) {
                        return $model->hamlet;
                    },
                ],
                [
                    'attribute' => 'no_of_members',
                    'label' => 'सदस्यों की संख्या',
                    'value' => function ($model) {
                        return $model->no_of_members;
                    },
                ],
                [
                    'attribute' => 'date_of_formation',
                    'label' => 'गठन की तारीख',
                    'value' => function ($model) {
                        return $model->date_of_formation;
                    },
                ],
            ],
        ])?>
</div>

