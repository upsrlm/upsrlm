<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model bc\modules\selection\models\PaytmBcSakhi */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Paytm Bc Sakhis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="paytm-bc-sakhi-view">

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
            'sr_no',
            'application_no',
            'name',
            'otp_mobile_no',
            'mobile_number',
            'onboarding_status',
            'bmd_1650',
            'sarthi_device_25000',
            'both_devices',
            'device_not_purchased',
            'bc_operational',
            'district',
            'block',
            'gp',
            'district_code',
            'block_code',
            'gram_panchayat_code',
            'bc_shg_payment_status',
            'acknowledge_support_funds_received',
            'bankidofbc',
            'upsrlm_onboarding_status',
            'upsrlm_handheld_machine_status',
            'upsrlm_bc_handheld_machine_recived',
            'upsrlm_pan_card_status',
            'upsrlm_bc_shg_funds_status',
            'upsrlm_bc_support_funds_received',
            'upsrlm_bankidbc',
            'upsrlm_master_partner_bank_id',
            'upsrlm_training_status',
            'upsrlm_bc_operational',
        ],
    ]) ?>

</div>
