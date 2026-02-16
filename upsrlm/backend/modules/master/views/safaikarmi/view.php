<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\master\SafaiKarmi */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Safai Karmis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="safai-karmi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            's_no',
            'district',
            'block',
            'gram_panchyat',
            'name',
            'gender',
            'age',
            'mobile_no',
            'alternative_mobile_no',
            'district_code',
            'block_code',
            'gram_panchayat_code',
            'role',
            'user_id',
            'status',
            'mobile_status',
            'ctc_click_count',
            'ibd',
            'ibd_date',
            'ibd_datetime',
        ],
    ]) ?>

</div>
