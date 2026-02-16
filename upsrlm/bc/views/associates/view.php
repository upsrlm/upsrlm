<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model bc\models\PartnerAssociates */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Partner Associates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="partner-associates-view">

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
            'master_bank_id',
            'name_of_the_field_officer',
            'gender',
            'date_of_birth',
            'age',
            'photo_profile',
            'designation',
            'mobile_no',
            'alternate_mobile_no',
            'whatsapp_no',
            'email_id:email',
            'photo_aadhaar_front',
            'photo_aadhaar_back',
            'company_letter',
            'name_of_supervisor',
            'designation_of_supervisor',
            'mobile_no_of_supervisor',
            'bank_name',
            'bank_branch',
            'bank_ifsc_code',
            'bank_account_number',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at',
            'status',
        ],
    ]) ?>

</div>
