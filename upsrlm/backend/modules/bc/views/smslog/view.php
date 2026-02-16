<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model bc\modules\selection\models\SmsLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sms Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sms-log-view">

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
            'mobile_no',
            'imei_no',
            'os_type',
            'manufacturer_name',
            'os_version',
            'firebase_token:ntext',
            'app_version',
            'time',
            'sms_send_time',
            'otp',
            'message_id',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'status',
        ],
    ]) ?>

</div>
