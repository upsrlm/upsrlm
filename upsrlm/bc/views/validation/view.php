<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model bc\models\UpsrlmFrameworkValidation */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Upsrlm Framework Validations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="upsrlm-framework-validation-view">

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
            'key_id',
            'deliverables_id',
            'start_date',
            'operational_stage',
            'current_status',
            'validation_by',
            'validation_status',
            'validation_datetime',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'status',
        ],
    ]) ?>

</div>
