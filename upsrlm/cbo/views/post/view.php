<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CboVo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cbo Vos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cbo-vo-view">

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
            'state_code',
            'state_name',
            'division_code',
            'division_name',
            'district_code',
            'district_name',
            'block_code',
            'block_name',
            'gram_panchayat_code',
            'gram_panchayat_name',
            'name_of_vo',
            'date_of_formation',
            'no_of_shg_connected',
            'bank_account_no_of_the_vo',
            'name_of_bank',
            'branch',
            'branch_code_or_ifsc',
            'date_of_opening_the_bank_account',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'status',
        ],
    ]) ?>

</div>
