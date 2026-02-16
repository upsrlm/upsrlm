<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'BCs with uploaded PAN photo' ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'header' => 'BC Name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                    $html = '';
                                    if (isset($arr[$model->participant->blocked])) {
                                        $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                    }
                                    return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                }
                            ],
                            [
                                'attribute' => 'mobile_no',
                                'header' => 'Mobile No.',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return common\helpers\Utility::mask($model->otp_mobile_no) . '<br/>' . common\helpers\Utility::mask($model->mobile_number);
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'header' => 'BC District /<br/> BC Block',
                                'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district_name . '/<br/>' . $model->block_name;
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'header' => 'BC GP',
                                'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->gram_panchayat_name;
                                }
                            ],
                            [
                                'attribute' => 'BC bank a/c',
                                'header' => 'BC bank a/c',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $html = '';
                                    if (in_array($model->participant->bc_bank, [2])) {
                                        $html .= '<br/> Verified';
                                    }
                                    return isset($model->participant->bank_account_no_of_the_bc) ? 'Yes' . $model->participant->bcbanks : 'No' . $model->participant->bcbanks;
                                }
                            ],
                            [
                                'attribute' => 'upsrlm_shg_name',
                                'header' => 'UPSRLM SHG Name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $shg = cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                                    return isset($shg->name_of_shg) ? $shg->name_of_shg : '';
                                }
                            ],
                            [
                                'attribute' => 'SHG bank a/c',
                                'header' => 'SHG bank a/c',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $html = '';
                                    if (in_array($model->participant->shg_bank, [2])) {
                                        $html .= '<br/> Verified';
                                    }
                                    $shg = cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                                    return ($model->participant->bank_account_no_of_the_shg != null) ? 'Yes' . $model->participant->shgbanks : 'No' . $model->participant->shgbanks;
                                }
                            ],
                            [
                                'attribute' => 'pfms_maped_status',
                                'header' => 'PFMS STATUS',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS]),
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $status = '';
                                    if ($model->participant->pfms_maped_status == 1) {
                                        $status = 'Yes';
                                    }
                                    if ($model->participant->pfms_maped_status == 0) {
                                        $status = 'No';
                                    }
                                    return $status;
                                }
                            ],
                            [
                                'attribute' => 'beneficiaries_code',
                                'header' => 'Beneficiaries code',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->participant->beneficiaries_code != null ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'bc_shg_funds_status',
                                'header' => 'BC-SHG payment status',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS]),
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $status = '';
                                    if ($model->participant->bc_shg_funds_status == 1) {
                                        $status = 'Yes';
                                    }
                                    if ($model->participant->bc_shg_funds_status == 0) {
                                        $status = 'No';
                                    }
                                    return $status;
                                }
                            ],
                            [
                                'attribute' => 'bankidbc',
                                'header' => 'Bank ID of BC',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->participant->bankidbc != null ? $model->participant->bankidbc : '';
                                }
                            ],
                            [
                                'attribute' => 'bc_support_funds_received',
                                'header' => 'Acknowledge support funds received',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->participant->bc_support_funds_received == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'bc_handheld_machine_recived',
                                'header' => 'Acknowledge handheld machine received',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->participant->bc_handheld_machine_recived == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'pan_photo_status',
                                'header' => 'PAN available',
                                'visible' => 1,
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->participant->pan_card_status == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'pan_photo_upload',
                                'header' => 'PAN photo',
                                'visible' => 1,
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->participant->pan_photo_upload == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'Return to BMMU',
                                'header' => 'Return to BMMU',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD]),
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->participant->return_for_shg == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'header' => 'Upload PVR',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                'value' => function ($model) {
                                    return $model->participant->pvr_status == 1 ? 'Yes' : 'No';
                                },
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>    
    </div>
</div>

