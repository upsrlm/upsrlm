<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CboMemberProfile */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cbo Member Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cbo-member-profile-view">

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
            'user_id',
            'folder_prefix',
            'first_name',
            'middle_name',
            'sur_name',
            'gender',
            'date_of_birth',
            'primary_phone_no',
            'primary_phone_no_verified',
            'primary_phone_no_verified_date',
            'alternate_phone_no',
            'alternate_phone_no_verified',
            'alternate_phone_no_verified_date',
            'whatsapp_no',
            'whatsapp_no_verified',
            'whatsapp_no_verified_date',
            'email_id:email',
            'email_id_verified:email',
            'email_id_verified_date:email',
            'aadhaar_number',
            'bc',
            'samuh_sakhi',
            'samuh_sakhi_old',
            'wada_sakhi',
            'accountant',
            'shg',
            'vo',
            'clf',
            'age',
            'cast',
            'division_code',
            'division_name',
            'district_code',
            'district_name',
            'block_code',
            'block_name',
            'gram_panchayat_code',
            'gram_panchayat_name',
            'village_code',
            'village_name',
            'hamlet',
            'guardian_name',
            'otp_mobile_no',
            'marital_status',
            'srlm_bc_application_id',
            'srlm_bc_selection_user_id',
            'bank_account_no',
            'bank_id',
            'name_of_bank',
            'branch',
            'branch_code_or_ifsc',
            'date_of_opening_the_bank_account',
            'cin',
            'iibf_membership_no',
            'profile_photo',
            'photo_aadhaar_front',
            'photo_aadhaar_back',
            'passbook_photo',
            'pan_photo',
            'iibf_photo_file_name',
            'pvr_upload_file_name',
            'bc_handheld_machine_photo',
            'passbook_photo_shg',
            'bank_account_no_of_the_shg',
            'bank_id_shg',
            'name_of_bank_shg',
            'branch_shg',
            'branch_code_or_ifsc_shg',
            'rishta_app_last_access_time',
            'bc_no_of_transaction',
            'bc_transaction_amount',
            'ctc_call_count',
            'ibd_call_count',
            'master_partner_bank_id',
            'bc_copy_file_count',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at',
            'status',
        ],
    ]) ?>

</div>
