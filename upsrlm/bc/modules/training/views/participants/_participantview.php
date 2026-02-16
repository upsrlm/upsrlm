<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
?>

<div class="row">
    <div class="col-xl-12">
        <div class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $model->name ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>

                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-lg-6" >
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
                                            return $model->participant->age;
                                        }
                                    ],
                                    [
                                        'attribute' => 'aadhar_number',
                                        'format' => 'html',
                                        'value' => $model->participant->aadhar_number != null ? common\helpers\Utility::maskaadhar($model->participant->aadhar_number) : '',
                                    ],
                                    [
                                        'attribute' => 'guardian_name',
                                        'format' => 'html',
                                        'value' => $model->participant->guardian_name != null ? $model->participant->guardian_name : '',
                                    ],
                                    [
                                        'attribute' => 'reading_skills',
                                        'label' => 'Education',
                                        'format' => 'html',
                                        'value' => $model->participant->readingskills != null ? $model->participant->readingskills->name_eng : '',
                                    ],
                                    [
                                        'attribute' => 'mobile_number',
                                        'format' => 'html',
                                        'value' => $model->mobile_number != null ? common\helpers\Utility::mask($model->mobile_number) : '',
                                    ],
                                    [
                                        'attribute' => 'otp_mobile_no',
                                        'label' => 'OTP Verified mobile no',
                                        'format' => 'html',
                                        'value' => $model->otp_mobile_no != null ? common\helpers\Utility::mask($model->otp_mobile_no) : '',
                                    ],
                                    [
                                        'attribute' => 'pan_photo_status',
                                        'label' => 'PAN available',
                                        'visible' => 1,
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->participant->pan_card_status == 1 ? 'Yes' : 'No';
                                        }
                                    ],
                                ],
                            ])
                            ?>

                        </div>
                        <div class="col-lg-6" >

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
//                            [
//                                'attribute' => 'batch',
//                                'format' => 'raw',
//                                'visible' => isset($model->batch->batch_name),
//                                'value' => function ($model) {
//                                    return isset($model->batch->batch_name) ? $model->batch->batch_name : '';
//                                }
//                            ],
                                    [
                                        'label' => 'Training',
                                        'attribute' => 'start_date',
                                        'format' => 'raw',
                                        'visible' => isset($model->training),
                                        'value' => function ($model) {
                                            return isset($model->training) ? $model->training->date : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'schedule_date_of_exam',
                                        'visible' => isset($model->training),
                                        'value' => function ($model) {
                                            return isset($model->training) ? \Yii::$app->formatter->asDatetime($model->training->schedule_date_of_exam, "php:d-m-Y") : "";
                                        }
                                    ],
                                    [
                                        'attribute' => 'exam_score',
                                        'visible' => isset($model->training),
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->exam_score != null ? $model->exam_score : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'certificate_code',
                                        'visible' => isset($model->training),
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->certificate_code != null ? $model->certificate_code : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'shg_name',
                                        'label' => 'UPSRLM SHG Name',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $shg = cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                                            return isset($shg->name_of_shg) ? $shg->name_of_shg : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_support_funds_received_amount',
                                        'label' => 'Support funds received amount',
                                        'visible' => isset($model->participant->bc_support_funds_received_amount),
                                        'format' => 'raw',
                                        'value' => function ($model) {

                                            return $model->participant->bc_support_funds_received_amount;
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_support_funds_handheld_amount',
                                        'label' => 'Support funds handheld amount',
                                        'visible' => isset($model->participant->bc_support_funds_handheld_amount),
                                        'format' => 'raw',
                                        'value' => function ($model) {

                                            return $model->participant->bc_support_funds_handheld_amount;
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_support_funds_od_amount',
                                        'label' => 'Support funds od amount',
                                        'visible' => isset($model->participant->bc_support_funds_od_amount),
                                        'format' => 'raw',
                                        'value' => function ($model) {

                                            return $model->participant->bc_support_funds_od_amount;
                                        }
                                    ],
//                            [
//                                'attribute' => 'training_status',
//                                'format' => 'raw',
//                                'value' => function ($model) {
//                                    return $model->trainingstatus;
//                                }
//                            ],
                                ],
                            ])
                            ?>
                        </div> 
                    </div> 
                    <?php if ($model->participant->tfeedback != null) { ?> 
                        <div class="row">
                            <div class="col-lg-12">प्रशिक्षण व संवेदीकरण</div>
                            <div class="col-lg-12">

                                <?=
                                DetailView::widget([
                                    'model' => $model,
                                    'options' => ['class' => 'table table-striped table-bordered detail-view'],
                                    //'template' =>'<tr><td}>{label}</td><th>{value}</th></tr>',
                                    'attributes' => [
                                        [
                                            'attribute' => 'ques_1',
                                            'label' => 'फ़्रॉड कॉल के माध्यम से ऑनलाइन आपके बैंक खाते से पैसे निकाल लेने के ख़तरे',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->participant->tfeedback->ques1;
                                            }
                                        ],
                                        [
                                            'attribute' => 'ques_2',
                                            'label' => 'ऐंटी मनी लॉंडरिंग (AML)/ ग़लत तरीक़े से ऑनलाइन पैसे के लेनदेन से जुड़े विषय ',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->tfeedback->ques2;
                                            }
                                        ],
                                        [
                                            'attribute' => 'ques_3',
                                            'label' => 'नक़ली मुद्रा/ नोट के ख़तरे - उनके व्यवहार एवं पहचान करने के तरीक़े ताकि उनसे बचा जा सके ।',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->participant->tfeedback->ques3;
                                            }
                                        ],
                                        [
                                            'attribute' => 'ques_4',
                                            'label' => 'क्या आपको सभी विषय एवं उनसे सम्बंधित सावधानियों के बारे समझ मिली?',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->tfeedback->ques4;
                                            }
                                        ],
                                    ],
                                ])
                                ?>

                            </div>

                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-lg-6">
                        <?php if ($model->participant->bank_account_no_of_the_bc != null) { ?>        
                            
                                Bank Detail OF BC
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
                                                return $model->participant->bank_account_no_of_the_bc;
                                            }
                                        ],
                                        [
                                            'attribute' => 'name_of_bank',
                                            'label' => 'Name of bank',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->name_of_bank;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch',
                                            'label' => 'Branch',
                                            'format' => 'html',
                                            'value' => function ($model) {
                                                return $model->participant->branch;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch_code_or_ifsc',
                                            'label' => 'Branch code or IFSC',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->branch_code_or_ifsc;
                                            }
                                        ],
                                        [
                                            'attribute' => 'bc_bank',
                                            'label' => 'बी0सी0 सखी  बैंक विवरण',
                                            'format' => 'html',
                                            'visible' => $model->participant->bc_bank,
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                $arr = [0 => 'बैंक विवरण अपलोड नहीं ', 1 => 'बैंक विवरण अपलोड किया गया', 2 => 'बैंक विवरण सत्यापित', 3 => 'बैंक विवरण वापसी'];
                                                return $model->participant->bcbanks;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch_code_or_ifsc',
                                            'label' => 'बी0सी0 सखी  बैंक विवरण वापसी का कारण ',
                                            'format' => 'html',
                                            'visible' => $model->participant->bcbankrjregion,
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->bcbankrjregion;
                                            }
                                        ],
                                    ],
                                ])
                                ?>
                                <?php if ($model->participant->passbook_photo != null) { ?>
                                    <table class="table">
                                        <tr>
                                            <th>पासबुक फोटो</th>

                                        </tr> 
                                        <tr>
                                            <td><?= $model->participant->passbook_photo != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->participant->passbook_photo_url . '" data-src="' . $model->participant->passbook_photo_url . '"  class="img-thumbnail lozad" title="Passbook Photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                            </td> 
                                        </tr>
                                    </table>
                                <?php } ?>     
                            


                        <?php } ?>  
                          </div>      
                        <div class="col-lg-6">
                        <?php
                        if ($model->participant->cbo_shg_id) {
                            $shg_model = cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                            ?>        
                            
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
                                            'visible' => $model->participant->bank_account_no_of_the_shg != null,
                                            'value' => function ($model) {
                                                return $model->participant->bank_account_no_of_the_shg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'name_of_bank',
                                            'label' => 'Name of bank',
                                            'format' => 'html',
                                            'visible' => $model->participant->name_of_bank_shg != null,
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->name_of_bank_shg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch',
                                            'label' => 'Branch',
                                            'format' => 'html',
                                            'visible' => $model->participant->branch_shg != null,
                                            'value' => function ($model) {
                                                return $model->participant->branch_shg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch_code_or_ifsc',
                                            'label' => 'Branch code or IFSC',
                                            'format' => 'html',
                                            'visible' => $model->participant->branch_code_or_ifsc_shg != null,
                                            'value' => function ($model) {
                                                return $model->participant->branch_code_or_ifsc_shg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'shg_bank',
                                            'label' => 'बी0सी0 सखी स्वयं सहायता समूह  बैंक विवरण',
                                            'format' => 'html',
                                            'visible' => $model->participant->shg_bank,
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                $arr = [0 => 'बैंक विवरण अपलोड नहीं ', 1 => 'बैंक विवरण अपलोड किया गया', 2 => 'बैंक विवरण सत्यापित', 3 => 'बैंक विवरण वापसी'];
                                                return $model->participant->shgbanks;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch_code_or_ifsc',
                                            'label' => 'बी0सी0 सखी स्वयं सहायता समूह बैंक विवरण वापसी का कारण',
                                            'format' => 'html',
                                            'visible' => $model->participant->bcshgbankrjregion,
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->bcshgbankrjregion;
                                            }
                                        ],
                                    ],
                                ])
                                ?>
                                <?php if ($model->participant->passbook_photo_shg != null) { ?>
                                  
                                    <table class="table">
                                        <tr>
                                            <th>पासबुक फोटो </th>

                                        </tr> 
                                        <tr>
                                            <td><?= $model->participant->passbook_photo_shg != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->participant->passbook_photo_shg_url . '" data-src="' . $model->participant->passbook_photo_shg_url . '"  class="img-thumbnail lozad" title="Passbook Photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                            </td> 
                                        </tr>
                                    </table>
                                    <?php
                                }
                            }
                            ?>  
                        </div>
                        <div class="clearfix">&nbsp;</div>
                    </div>

                    <div class="row">
                        <table class="table">
                            <tr>
                                <th>प्रोफाइल फोटो</th>
                                <th>आधार फ्रंट फोटो</th>
                                <th>आधार बैक फोटो</th>
                            </tr> 
                            <tr>
                                <td><?= $model->participant->user->profile_photo != null ? '<span class="profile-picture">
                                        <img width="300px" height="220px" src="' . $model->participant->profile_photo_url . '" data-src="' . $model->participant->profile_photo_url . '"  class="lozad" title="profile_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                                <td><?= $model->participant->user->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img width="300px" height="220px" src="' . $model->participant->aadhar_front_photo_url . '" data-src="' . $model->participant->aadhar_front_photo_url . '"  class="lozad" title="aadhar_front_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                                <td><?= $model->participant->user->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img width="300px" height="220px" src="' . $model->participant->aadhar_back_photo_url . '" data-src="' . $model->participant->aadhar_back_photo_url . '"  class="lozad" title="aadhar_back_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                            </tr>
                        </table>
                    </div>
                    <?php if ($model->participant->iibf_photo_file_name != null or $model->participant->pvr_upload_file_name != null) { ?>
                        <div class="row">
                            <table class="table">
                                <tr>

                                    <th width="50%">IIBF Certificate</th>


                                    <th width="50%">PVR Photo</th>

                                </tr> 
                                <tr>
                                    <td width="50%">
                                        <?= $model->participant->iibf_photo_file_name != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->participant->iibf_photo_url . '" data-src="' . $model->participant->iibf_photo_url . '"  class="img-responsive lozad" title="IIBF Certificate" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                    </td> 
                                    <td width="50%">
                                        <?= $model->participant->pvr_upload_file_name != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->participant->pvr_upload_file_name_url . '" data-src="' . $model->participant->pvr_upload_file_name_url . '"  class="img-responsive lozad" title="PVR" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                    </td> 
                                </tr>
                            </table>
                        </div>      
                    <?php } ?>
                    <?php if ($model->participant->pan_photo != null or $model->participant->bc_handheld_machine_photo != null) { ?>
                      <div class="row">  
                      <table class="table">
                            <tr>


                                <th width="50%">PAN Photo</th>
                                <th width="50%">Handheld machine photo</th>
                            </tr> 
                            <tr>
                                <td width="50%">
                                    <?= $model->participant->pan_photo != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->participant->pan_photo_url . '" data-src="' . $model->participant->pan_photo_url . '"  class="img-responsive lozad" title="PAN Photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                </td> 
                                <td width="50%">
                                    <?= $model->participant->bc_handheld_machine_photo != null ? '<span class="profile-picture">
                                        <img width="475px" src="' . $model->participant->bc_handheld_machine_photo_url . '" data-src="' . $model->participant->bc_handheld_machine_photo_url . '"  class="img-responsive lozad" title="Handheld machine photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                </td> 
                            </tr>
                        </table>
                      </div>
                    <?php } ?>

                </div>
            </div>  
        </div>
    </div>
</div>
<div class="clearfix"></div>