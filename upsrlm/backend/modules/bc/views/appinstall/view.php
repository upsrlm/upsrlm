<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model bc\modules\selection\models\SrlmBcSelectionAppDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Srlm Bc Selection App Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="srlm-bc-selection-app-detail-view">

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
            'srlm_bc_selection_user_id',
            'imei_no',
            'os_type',
            'manufacturer_name',
            'os_version',
            'firebase_token:ntext',
            'app_version',
            'date_of_install',
            'date_of_uninstall',
            'status',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
