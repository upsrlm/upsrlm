<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use common\models\master\MasterRole;

$this->title = $model->name;

$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <a href="<?= '/page/go' ?>" class="btn bg-danger-400 btn-lg btn-xl btn-block p-3 mb-2"><span> शासनादेश</span> </a>
                    <?php if (isset($model->associate)) { ?>
                        <div class="row">
                            <div class="col-lg-12 pb-1">
                                <?php
                                echo \yii\helpers\Html::a('Field Associate', ['/bc/default/associate?bcid=' . $model->id], ['data-pjax' => 0, 'class' => 'btn btn-warning btn-block']) . '<br/>';
                                ?>

                            </div>
                        </div>   
                    <?php } ?> 
                    <?php if (isset($model->bc_shg_funds_status) and $model->id=='66940') { ?>
                        <div class="row">
                            <div class="col-lg-12 pb-1">
                                <?php
                                echo \yii\helpers\Html::a('सपोर्ट फण्ड वापसी', ['/bc/supportfund?bcid=' . $model->id], ['data-pjax' => 0, 'class' => 'btn btn-danger btn-block']) . '<br/>';
                                ?>

                            </div>
                        </div>   
                    <?php } ?>
                    <?php if ($model->id=='66940') { ?>
                        <div class="row">
                            <div class="col-lg-12 pb-1">
                                <?php
                                echo \yii\helpers\Html::a('शिकायत', ['/bc/grievance?bcid=' . $model->id], ['data-pjax' => 0, 'class' => 'btn btn-danger btn-block']) . '<br/>';
                                ?>

                            </div>
                        </div>   
                    <?php } ?>
                    <div class="row">
                        <div class="col-lg-12" ><?= $model->bcpaymentbutton ?></div>
                    </div> 
                    <div class="row">
                        <div class="col-lg-12 pb-1" ><?= $model->bcsareebutton ?></div>
                    </div>  
                    <div class="row">
                        <div class="col-lg-12" >
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
                                        'attribute' => 'aadhar_number',
                                        'format' => 'html',
                                        'value' => $model->aadhar_number != null ? $model->aadhar_number : '',
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
                                        'attribute' => 'mobile_number',
                                        'format' => 'html',
                                        'value' => $model->mobile_number != null ? $model->mobile_number : '',
                                    ],
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
                                ],
                            ])
                            ?>

                        </div>
                    </div> 


                    <div class="row">
                        <div class="col-lg-12" >
                            <?=
                            DetailView::widget([
                                'model' => $pmodel,
                                'options' => ['class' => 'table table-striped table-bordered detail-view'],
                                //'template' =>'<tr><td}>{label}</td><th>{value}</th></tr>',
                                'attributes' => [
                                    [
                                        'label' => 'Training',
                                        'attribute' => 'start_date',
                                        'format' => 'raw',
                                        'visible' => isset($pmodel->training),
                                        'value' => function ($pmodel) {
                                            return isset($pmodel->training) ? $pmodel->training->date : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'schedule_date_of_exam',
                                        'visible' => isset($pmodel->training),
                                        'value' => function ($pmodel) {
                                            return isset($pmodel->training) ? \Yii::$app->formatter->asDatetime($pmodel->training->schedule_date_of_exam, "php:d-m-Y") : "";
                                        }
                                    ],
                                    [
                                        'attribute' => 'exam_score',
                                        'visible' => isset($pmodel->training),
                                        'format' => 'raw',
                                        'value' => function ($pmodel) {
                                            return $pmodel->exam_score != null ? $pmodel->exam_score : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'certificate_code',
                                        'visible' => isset($pmodel->training),
                                        'format' => 'raw',
                                        'value' => function ($pmodel) {
                                            return $pmodel->certificate_code != null ? $pmodel->certificate_code : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_support_funds_received_amount',
                                        'label' => 'Support funds received amount',
                                        'visible' => isset($pmodel->participant->bc_support_funds_received_amount),
                                        'format' => 'raw',
                                        'value' => function ($pmodel) {

                                            return $pmodel->participant->bc_support_funds_received_amount;
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_support_funds_handheld_amount',
                                        'label' => 'Support funds handheld amount',
                                        'visible' => isset($pmodel->participant->bc_support_funds_handheld_amount),
                                        'format' => 'raw',
                                        'value' => function ($pmodel) {

                                            return $pmodel->participant->bc_support_funds_handheld_amount;
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_support_funds_od_amount',
                                        'label' => 'Support funds od amount',
                                        'visible' => isset($pmodel->participant->bc_support_funds_od_amount),
                                        'format' => 'raw',
                                        'value' => function ($pmodel) {

                                            return $pmodel->participant->bc_support_funds_od_amount;
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
                                                return $model->bank_account_no_of_the_bc;
                                            }
                                        ],
                                        [
                                            'attribute' => 'name_of_bank',
                                            'label' => 'Name of bank',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->name_of_bank;
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
                                                return $model->branch_code_or_ifsc;
                                            }
                                        ],
                                    ],
                                ])
                                ?>
                                <?php if ($model->passbook_photo != null) { ?>
                                    <table class="table table-responsive">
                                        <tr>
                                            <th>BC Bank पासबुक फोटो</th>

                                        </tr> 
                                        <tr>
                                            <td><?= $model->passbook_photo != null ? '<span class="profile-picture">
                                        <img width="300px"  src="' . \Yii::$app->params['app_url']['bc'] . $model->passbook_photo_url . '" data-src="' . \Yii::$app->params['app_url']['bc'] . $model->passbook_photo_url . '"  class="img-thumbnail lozad" title="Passbook Photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                                        </tr>
                                    </table>
                                <?php } ?>     
                            </div>
                        <?php } ?>  

                        <div class="col-lg-6">
                            <?php
                            if ($pmodel->participant->cbo_shg_id) {
                                $shg_model = cbo\models\Shg::findOne($pmodel->participant->cbo_shg_id);
                                ?>        

                                Bank Detail OF SHG
                                <?=
                                DetailView::widget([
                                    'model' => $pmodel,
                                    'options' => ['class' => 'table table-striped table-bordered detail-view'],
                                    //'template' =>'<tr><td}>{label}</td><th>{value}</th></tr>',
                                    'attributes' => [
                                        [
                                            'attribute' => 'bank_account_no_of_the_shg',
                                            'label' => 'Bank account no of SHG',
                                            'format' => 'raw',
                                            'visible' => $pmodel->participant->bank_account_no_of_the_shg != null,
                                            'value' => function ($pmodel) {
                                                return $pmodel->participant->bank_account_no_of_the_shg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'name_of_bank',
                                            'label' => 'Name of bank',
                                            'format' => 'html',
                                            'visible' => $pmodel->participant->name_of_bank_shg != null,
                                            'enableSorting' => false,
                                            'value' => function ($pmodel) {
                                                return $pmodel->participant->name_of_bank_shg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch',
                                            'label' => 'Branch',
                                            'format' => 'html',
                                            'visible' => $pmodel->participant->branch_shg != null,
                                            'value' => function ($pmodel) {
                                                return $pmodel->participant->branch_shg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'branch_code_or_ifsc',
                                            'label' => 'Branch code or IFSC',
                                            'format' => 'html',
                                            'visible' => $pmodel->participant->branch_code_or_ifsc_shg != null,
                                            'value' => function ($pmodel) {
                                                return $pmodel->participant->branch_code_or_ifsc_shg;
                                            }
                                        ],
//                                        [
//                                            'attribute' => 'shg_bank',
//                                            'label' => 'बी0सी0 सखी स्वयं सहायता समूह  बैंक विवरण',
//                                            'format' => 'html',
//                                            'visible' => $pmodel->participant->shg_bank,
//                                            'enableSorting' => false,
//                                            'value' => function ($pmodel) {
//                                                $arr = [0 => 'बैंक विवरण अपलोड नहीं ', 1 => 'बैंक विवरण अपलोड किया गया', 2 => 'बैंक विवरण सत्यापित', 3 => 'बैंक विवरण वापसी'];
//                                                return $pmodel->participant->shgbanks;
//                                            }
//                                        ],
                                    ],
                                ])
                                ?>
                                <?php if ($pmodel->participant->passbook_photo_shg != null) { ?>

                                    <table class="table">
                                        <tr>
                                            <th>SHG Bank पासबुक फोटो </th>

                                        </tr> 
                                        <tr>
                                            <td><?= $pmodel->participant->passbook_photo_shg != null ? '<span class="profile-picture">
                                        <img width="300px" src="' . \Yii::$app->params['app_url']['bc'] . $pmodel->participant->passbook_photo_shg_url . '" data-src="' . \Yii::$app->params['app_url']['bc'] . $pmodel->participant->passbook_photo_shg_url . '"  class="img-thumbnail lozad" title="Passbook Photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                            </td> 
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

                        </tr> 
                        <tr>
                            <td><?= $model->profile_photo != null ? '<span class="profile-picture">
                                        <img width="300px"  src="' . \Yii::$app->params['app_url']['bc'] . $model->profile_photo_url . '" data-src="' . \Yii::$app->params['app_url']['bc'] . $model->profile_photo_url . '"  class="lozad" title="profile_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 

                        </tr>
                    </table>
                    <table class="table table-responsive">
                        <tr>

                            <th>आधार फ्रंट फोटो</th>

                        </tr> 
                        <tr>

                            <td><?= $model->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img width="300px" src="' . \Yii::$app->params['app_url']['bc'] . $model->aadhar_front_photo_url . '" data-src="' . \Yii::$app->params['app_url']['bc'] . $model->aadhar_front_photo_url . '"  class="lozad" title="aadhar_front_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 

                        </tr>
                    </table>
                    <table class="table table-responsive">
                        <tr>

                            <th>आधार बैक फोटो</th>
                        </tr> 
                        <tr>

                            <td><?= $model->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img width="300px"  src="' . \Yii::$app->params['app_url']['bc'] . $model->aadhar_back_photo_url . '" data-src="' . \Yii::$app->params['app_url']['bc'] . $model->aadhar_back_photo_url . '"  class="lozad" title="aadhar_back_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?></td> 
                        </tr>
                    </table>
                    <table class="table table-responsive">
                        <tr>

                            <th>पैन कार्ड फोटो</th>
                        </tr> 
                        <tr>

                            <td><?= $model->pan_photo != null ? '<div class="col-lg-12"><span class="profile-picture">
                                        <img width="300px"  src="' . \Yii::$app->params['app_url']['bc'] . $model->pan_photo_url . '" data-src="' . \Yii::$app->params['app_url']['bc'] . $model->pan_photo_url . '"  class="lozad" title="aadhar_front_photo" style="cursor : pointer"/>
                                        </span></div>' : '' ?></td> 
                        </tr>
                    </table>
                    <?php if ($model->pvr_upload_file_name != null) { ?>
                        <table class="table table-responsive">
                            <tr>

                                <th>IIBF Photo</th>


                            </tr> 
                            <tr>
                                <td>
                                    <?= $model->iibf_photo_file_name != null ? '<span class="profile-picture">
                                        <img width="300px" src="' . \Yii::$app->params['app_url']['bc'] . $model->iibf_photo_url . '" data-src="' . \Yii::$app->params['app_url']['bc'] . $model->iibf_photo_url . '"  class="img-responsive lozad" title="IIBF" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                </td> 

                            </tr>
                        </table>
                    <?php } ?>
                    <?php if ($model->pvr_upload_file_name != null) { ?>
                        <table class="table table-responsive">
                            <tr>


                                <th>PVR Photo</th>

                            </tr> 
                            <tr>

                                <td >
                                    <?= $model->pvr_upload_file_name != null ? '<span class="profile-picture">
                                        <img width="300px" src="' . \Yii::$app->params['app_url']['bc'] . $model->pvr_upload_file_name_url . '" data-src="' . \Yii::$app->params['app_url']['bc'] . $model->pvr_upload_file_name_url . '"  class="img-responsive lozad" title="PVR" style="cursor : pointer"/>
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