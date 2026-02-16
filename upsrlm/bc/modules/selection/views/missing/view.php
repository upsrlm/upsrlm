<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use bc\modules\selection\models\SrlmBcApplication;

/* @var $this yii\web\View */
/* @var $model bc\modules\selection\models\BcMissing */

$this->title = $model->bc_name;
$this->params['breadcrumbs'][] = ['label' => 'Bc Missings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6" >

                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'bc_name',
                                        'header' => 'BC Name',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'mobile_number',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => isset($model->mobile_number) ? common\helpers\Utility::mask($model->mobile_number) : '',
                                    ],
                                    [
                                        'attribute' => 'otp_mobile_no',
                                        'label' => 'OTP Verified mobile no',
                                        'format' => 'html',
                                        'value' => isset($model->bc->mobile_no) ? common\helpers\Utility::mask($model->bc->mobile_no) : '',
                                    ],
                                    [
                                        'attribute' => 'district_name',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'block_name',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'gram_panchayat_name',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'certified',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'age',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {

                                            return isset($model->bc) ? $model->bc->age : '';
                                        },
                                    ],
                                    [
                                        'attribute' => 'rseti_bc_shg_member',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'visible' => $model->bc_application_id != 0,
                                        'value' => function ($model) {

                                            return $model->rseti_bc_shg_member == 1 ? 'Yes' : 'No';
                                        },
                                    ],
                                    [
                                        'attribute' => 'reading_skills',
                                        'enableSorting' => false,
                                        'label' => 'Education',
                                        'format' => 'html',
                                        'value' => function ($model) {

                                            return isset($model->bc->readingskills) ? $model->bc->readingskills->name_eng : '';
                                        },
                                    ],
                                    [
                                        'attribute' => 'cast',
                                        'label' => 'सामाजिक वर्ग',
                                        'format' => 'html',
                                        'value' => isset($model->bc->castrel) ? $model->bc->castrel->name_hi : '',
                                    ],
                                    [
                                        'attribute' => 'aadhar_number',
                                        'label' => 'आधार नंबर',
                                        'format' => 'html',
                                        'value' => isset($model->bc->aadhar_number) ? common\helpers\Utility::maskaadhar($model->bc->aadhar_number) : '',
                                    ],
                                    [
                                        'attribute' => 'guardian_name',
                                        'label' => 'पति/ पिता/ अभिभावक का नाम',
                                        'format' => 'html',
                                        'value' => isset($model->bc->guardian_name) ? $model->bc->guardian_name : '',
                                    ],
                                    [
                                        'attribute' => 'phone_type',
                                        'label' => 'कौन सा मोबाइल है?',
                                        'format' => 'html',
                                        'value' => isset($model->bc->phonetype) ? $model->bc->phonetype->name_hi : '',
                                    ],
                                    [
                                        'attribute' => 'over_all',
                                        'label' => 'Over all rating',
                                        'format' => 'html',
                                        'value' => isset($model->bc->over_all) ? $model->bc->over_all . '/' . SrlmBcApplication::MAX_NO_TOTAL . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(' . \common\helpers\Utility::percentageOf($model->bc->over_all, SrlmBcApplication::MAX_NO_TOTAL) . ')' : '',
                                    ],
                                    [
                                        'attribute' => 'rseti_bc_application_status',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'visible' => $model->bc_application_id != 0,
                                        'value' => function ($model) {

                                            return $model->rseti_bc_application_status == 1 ? 'Completed' : 'Not Complete';
                                        },
                                    ],
                                    [
                                        'attribute' => 'bc_same',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'visible' => $model->bc_application_id != 0,
                                        'value' => function ($model) {

                                            return $model->bc_same == 1 ? 'Yes' : 'No';
                                        },
                                    ],
                                ],
                            ])
                            ?>

                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6" >

                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'bc_name',
                                        'header' => 'Listed BC Name',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => isset($model->listedbc->name) ? $model->listedbc->name : '',
                                    ],
                                    [
                                        'attribute' => 'mobile_number',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => isset($model->listedbc->mobile_number) ? $model->listedbc->mobile_number : '',
                                    ],
                                    [
                                        'attribute' => 'otp_mobile_no',
                                        'label' => 'OTP Verified mobile no',
                                        'format' => 'html',
                                        'value' => isset($model->listedbc->mobile_no) ? $model->listedbc->mobile_no : '',
                                    ],
                                    [
                                        'attribute' => 'district_name',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => isset($model->listedbc->district_name) ? $model->listedbc->district_name : '',
                                    ],
                                    [
                                        'attribute' => 'block_name',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => isset($model->listedbc->block_name) ? $model->listedbc->block_name : '',
                                    ],
                                    [
                                        'attribute' => 'gram_panchayat_name',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => isset($model->listedbc->gram_panchayat_name) ? $model->listedbc->gram_panchayat_name : '',
                                    ],
                                    [
                                        'attribute' => 'listed_bc_training_status',
                                        'enableSorting' => false,
                                        'label' => 'Listed BC Training',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            $array = [null => '', 0 => 'Default', 1 => 'Agree', '2' => 'Registered(Assign Batch)', '3' => 'Certified', 7 => 'Onboarding', '4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent'];
                                            return isset($model->listedbc) ? $array[$model->listed_bc_training_status] : '';
                                        },
                                    ],
                                    [
                                        'attribute' => 'age',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {

                                            return isset($model->listedbc) ? $model->listedbc->age : '';
                                        },
                                    ],
                                    [
                                        'attribute' => 'listed_bc_shg_member',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'visible' => $model->bc_application_id != 0,
                                        'value' => function ($model) {

                                            return $model->listed_bc_shg_member == 1 ? 'Yes' : 'No';
                                        },
                                    ],
                                    [
                                        'attribute' => 'reading_skills',
                                        'enableSorting' => false,
                                        'label' => 'Education',
                                        'format' => 'html',
                                        'value' => function ($model) {

                                            return isset($model->listedbc->readingskills) ? $model->listedbc->readingskills->name_eng : '';
                                        },
                                    ],
                                    [
                                        'attribute' => 'cast',
                                        'label' => 'सामाजिक वर्ग',
                                        'format' => 'html',
                                        'value' => isset($model->listedbc->castrel) ? $model->listedbc->castrel->name_hi : '',
                                    ],
                                    [
                                        'attribute' => 'aadhar_number',
                                        'label' => 'आधार नंबर',
                                        'format' => 'html',
                                        'value' => isset($model->listedbc->aadhar_number) ? common\helpers\Utility::maskaadhar($model->listedbc->aadhar_number) : '',
                                    ],
                                    [
                                        'attribute' => 'guardian_name',
                                        'label' => 'पति/ पिता/ अभिभावक का नाम',
                                        'format' => 'html',
                                        'value' => isset($model->listedbc->guardian_name) ? $model->listedbc->guardian_name : '',
                                    ],
                                    [
                                        'attribute' => 'phone_type',
                                        'label' => 'कौन सा मोबाइल है?',
                                        'format' => 'html',
                                        'value' => isset($model->listedbc->phonetype) ? $model->listedbc->phonetype->name_hi : '',
                                    ],
                                    [
                                        'attribute' => 'over_all',
                                        'label' => 'Over all rating',
                                        'format' => 'html',
                                        'value' => isset($model->listedbc->over_all) ? $model->listedbc->over_all . '/' . SrlmBcApplication::MAX_NO_TOTAL . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(' . \common\helpers\Utility::percentageOf($model->listedbc->over_all, SrlmBcApplication::MAX_NO_TOTAL) . ')' : '',
                                    ],
                                    [
                                        'attribute' => 'listed_bc_onboard',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'visible' => $model->bc_application_id != 0,
                                        'value' => function ($model) {

                                            return $model->listed_bc_onboard == 1 ? 'Yes' : 'No';
                                        },
                                    ],
                                    [
                                        'attribute' => 'listed_bc_funds_transfer',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'visible' => $model->bc_application_id != 0,
                                        'value' => function ($model) {

                                            return $model->listed_bc_funds_transfer == 1 ? 'Yes' : 'No';
                                        },
                                    ],
                                ],
                            ])
                            ?>

                        </div>
                    </div> 
                </div>        
            </div>    
        </div>    
    </div>    
</div>  