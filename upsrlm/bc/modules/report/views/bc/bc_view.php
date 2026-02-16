<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

$this->title = "BC Sakhi :" . $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-4" class="panel">
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6" >
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'options' => ['class' => 'table table-striped table-bordered detail-view'],
                                //'template' =>'<tr><td}>{label}</td><th>{value}</th></tr>',
                                'attributes' => [
                                    [
                                        'attribute' => 'name',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'age',
                                        'format' => 'html',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->age;
                                        }
                                    ],
                                    
                                    [
                                        'attribute' => 'guardian_name',
                                        'format' => 'html',
                                        'value' => $model->guardian_name != null ? $model->guardian_name : '',
                                    ],
                                    [
                                        'attribute' => 'reading_skills',
                                        'label' => 'Education',
                                        'format' => 'html',
                                        'value' => $model->readingskills != null ? $model->readingskills->name_eng : '',
                                    ],
                                   
                                    [
                                        'attribute' => 'pan_photo_status',
                                        'label' => 'PAN available',
                                        'visible' => 1,
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->pan_card_status == 1 ? 'Yes' : 'No';
                                        }
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
                                        'attribute' => 'district_name',
                                        'enableSorting' => false,
                                        'value' => $model->district_name,
                                    ],
                                    [
                                        'attribute' => 'block_name',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->block_name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'gram_panchayat_name',
                                        'format' => 'html',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->gram_panchayat_name;
                                        }
                                    ],
                                    
                                    [
                                        'attribute' => 'shg_name',
                                        'label' => 'UPSRLM SHG Name',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $shg = cbo\models\Shg::findOne($model->cbo_shg_id);
                                            return isset($shg->name_of_shg) ? $shg->name_of_shg : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_support_funds_received_amount',
                                        'label' => 'Support funds received amount',
                                        'visible' => isset($model->bc_support_funds_received_amount),
                                        'format' => 'raw',
                                        'value' => function ($model) {

                                            return $model->bc_support_funds_received_amount;
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_support_funds_handheld_amount',
                                        'label' => 'Support funds handheld amount',
                                        'visible' => isset($model->bc_support_funds_handheld_amount),
                                        'format' => 'raw',
                                        'value' => function ($model) {

                                            return $model->bc_support_funds_handheld_amount;
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_support_funds_od_amount',
                                        'label' => 'Support funds od amount',
                                        'visible' => isset($model->bc_support_funds_od_amount),
                                        'format' => 'raw',
                                        'value' => function ($model) {

                                            return $model->bc_support_funds_od_amount;
                                        }
                                    ],
                                ],
                            ])
                            ?>
                        </div> 
                    </div> 
                    <div class="row">
                        <?php if ($model->bank_account_no_of_the_bc != null) { ?>        


                            <div class="col-sm-6 col-md-6 col-lg-6" >
                                Bank Detail OF BC Settlement
                                <?=
                                DetailView::widget([
                                    'model' => $model,
                                    'options' => ['class' => 'table table-striped table-bordered detail-view'],
                                    //'template' =>'<tr><td}>{label}</td><th>{value}</th></tr>',
                                    'attributes' => [
                                        [
                                            'attribute' => 'bank_account_no_of_the_bc',
                                            'label' => 'Bank account no of BC',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->bc_settlement_account_no;
                                            }
                                        ],
                                        [
                                            'attribute' => 'name_of_bank',
                                            'label' => 'Name of bank',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->bc_settlement_account_bank_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch',
                                            'label' => 'Branch',
                                            'format' => 'html',
                                            'value' => function ($model) {
                                                return $model->branch;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch_code_or_ifsc',
                                            'label' => 'Branch code or IFSC',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->bc_settlement_account_ifsc_code;
                                            }
                                        ],
                                        [
                                            'attribute' => 'bc_bank',
                                            'label' => 'बी0सी0 सखी  बैंक विवरण',
                                            'format' => 'html',
                                            'visible' => $model->bc_bank,
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                $arr = [0 => 'बैंक विवरण अपलोड नहीं ', 1 => 'बैंक विवरण अपलोड किया गया', 2 => 'बैंक विवरण सत्यापित', 3 => 'बैंक विवरण वापसी'];
                                                return $model->bcbanks;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch_code_or_ifsc',
                                            'label' => 'बी0सी0 सखी  बैंक विवरण वापसी का कारण ',
                                            'format' => 'html',
                                            'visible' => $model->bcbankrjregion,
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->bcbankrjregion;
                                            }
                                        ],
                                    ],
                                ])
                                ?>
                                <?php if ($model->passbook_photo != null) { ?>
                                    <table class="table table-responsive">
                                        <tr>
                                            <th>पासबुक फोटो</th>

                                        </tr> 
                                        <tr>
                                            <td><?= $model->passbook_photo != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->passbook_photo_url . '" data-src="' . $model->passbook_photo_url . '"  class="img-thumbnail lozad" title="Passbook Photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                                        </tr>
                                    </table>
                                <?php } ?>     
                            </div>


                        <?php } ?>  


                        <?php
                        if ($model->cbo_shg_id) {
                            $shg_model = cbo\models\Shg::findOne($model->cbo_shg_id);
                            ?>        


                            <div class="col-sm-6 col-md-6 col-lg-6" >
                                Bank Detail OF SHG
                                <?=
                                DetailView::widget([
                                    'model' => $model,
                                    'options' => ['class' => 'table table-striped table-bordered detail-view'],
                                    //'template' =>'<tr><td}>{label}</td><th>{value}</th></tr>',
                                    'attributes' => [
                                        [
                                            'attribute' => 'bank_account_no_of_the_shg',
                                            'label' => 'Bank account no of SHG',
                                            'format' => 'raw',
                                            'visible' => $model->bank_account_no_of_the_shg != null,
                                            'value' => function ($model) {
                                                return $model->bank_account_no_of_the_shg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'name_of_bank',
                                            'label' => 'Name of bank',
                                            'format' => 'html',
                                            'visible' => $model->name_of_bank_shg != null,
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->name_of_bank_shg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch',
                                            'label' => 'Branch',
                                            'format' => 'html',
                                            'visible' => $model->branch_shg != null,
                                            'value' => function ($model) {
                                                return $model->branch_shg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch_code_or_ifsc',
                                            'label' => 'Branch code or IFSC',
                                            'format' => 'html',
                                            'visible' => $model->branch_code_or_ifsc_shg != null,
                                            'value' => function ($model) {
                                                return $model->branch_code_or_ifsc_shg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'shg_bank',
                                            'label' => 'बी0सी0 सखी स्वयं सहायता समूह  बैंक विवरण',
                                            'format' => 'html',
                                            'visible' => $model->shg_bank,
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                $arr = [0 => 'बैंक विवरण अपलोड नहीं ', 1 => 'बैंक विवरण अपलोड किया गया', 2 => 'बैंक विवरण सत्यापित', 3 => 'बैंक विवरण वापसी'];
                                                return $model->shgbanks;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch_code_or_ifsc',
                                            'label' => 'बी0सी0 सखी स्वयं सहायता समूह बैंक विवरण वापसी का कारण',
                                            'format' => 'html',
                                            'visible' => $model->bcshgbankrjregion,
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->bcshgbankrjregion;
                                            }
                                        ],
                                    ],
                                ])
                                ?>
                                <?php if ($model->passbook_photo_shg != null) { ?>
                                    <table class="table table-responsive">
                                        <tr>
                                            <th>पासबुक फोटो </th>

                                        </tr> 
                                        <tr>
                                            <td><?= $model->passbook_photo_shg != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->passbook_photo_shg_url . '" data-src="' . $model->passbook_photo_shg_url . '"  class="img-thumbnail lozad" title="Passbook Photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                                        </tr>
                                    </table>
                                    <?php
                                }
                            }
                            ?>  
                        </div>

                    </div>


                    <table class="table table-responsive">
                        <tr>
                            <th>प्रोफाइल फोटो</th>
                            <th>आधार फ्रंट फोटो</th>
                            <th>आधार बैक फोटो</th>
                        </tr> 
                        <tr>
                            <td><?= $model->user->profile_photo != null ? '<span class="profile-picture">
                                        <img width="300px" height="220px" src="' . $model->profile_photo_url . '" data-src="' . $model->profile_photo_url . '"  class="lozad" title="profile_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                            <td><?= $model->user->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img width="300px" height="220px" src="' . $model->aadhar_front_photo_url . '" data-src="' . $model->aadhar_front_photo_url . '"  class="lozad" title="aadhar_front_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                            <td><?= $model->user->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img width="300px" height="220px" src="' . $model->aadhar_back_photo_url . '" data-src="' . $model->aadhar_back_photo_url . '"  class="lozad" title="aadhar_back_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                        </tr>
                    </table>

                    <?php if ($model->iibf_photo_file_name != null or $model->pvr_upload_file_name != null) { ?>
                        <table class="table table-responsive">
                            <tr>

                                <th width="50%">IIBF Certificate</th>


                                <th width="50%">PVR Photo</th>

                            </tr> 
                            <tr>
                                <td width="50%">
                                    <?= $model->iibf_photo_file_name != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->iibf_photo_url . '" data-src="' . $model->iibf_photo_url . '"  class="img-responsive lozad" title="IIBF Certificate" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                </td> 
                                <td width="50%">
                                    <?= $model->pvr_upload_file_name != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->pvr_upload_file_name_url . '" data-src="' . $model->pvr_upload_file_name_url . '"  class="img-responsive lozad" title="PVR" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                </td> 
                            </tr>
                        </table>
                    <?php } ?>
                    <?php if ($model->pan_photo != null or $model->bc_handheld_machine_photo != null) { ?>
                        <table class="table table-responsive">
                            <tr>


                                <th width="50%">PAN Photo</th>
                                <th width="50%">Handheld machine photo</th>
                            </tr> 
                            <tr>
                                <td width="50%">
                                    <?= $model->pan_photo != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->pan_photo_url . '" data-src="' . $model->pan_photo_url . '"  class="img-responsive lozad" title="PAN Photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                </td> 
                                <td width="50%">
                                    <?= $model->bc_handheld_machine_photo != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->bc_handheld_machine_photo_url . '" data-src="' . $model->bc_handheld_machine_photo_url . '"  class="img-responsive lozad" title="Handheld machine photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                </td> 
                            </tr>
                        </table>
                    <?php } ?>
                    <?php if ($model->shg_confirm_funds_return_photo != null) { ?>
                        <table class="table table-responsive">
                            <tr>


                                <th width="50%">कार्यवाही पुस्तिका की फोटो</th>
                                <th width="50%"></th>
                            </tr> 
                            <tr>
                                <td width="50%">
                                    <?= $model->shg_confirm_funds_return_photo != null ? '<span class="profile-picture">
                                        <img src="' . Yii::$app->params['app_url']['bc'] . $model->shg_confirm_funds_return_photo_url . '" data-src="' . Yii::$app->params['app_url']['bc'] . $model->shg_confirm_funds_return_photo_url . '"  class="img-responsive lozad" title="कार्यवाही पुस्तिका की फोटो" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                </td> 

                            </tr>
                        </table>
                    <?php } ?>

                </div>
            </div>  
        </div>
    </div>
</div>  
