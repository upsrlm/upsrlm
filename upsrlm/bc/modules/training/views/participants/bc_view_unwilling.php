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
        <div id="panel-4" class="panel">
            <div class="panel-hdr h3">
                <h3>
                    <?= 'बीसी सखी द्वारा अनिच्छा प्रकाश किए जाने या तर्कसंगत कारणों से अनुपलब्ध होने के प्रावधान <br/>बीसी सखी की अद्यतन स्थिति (Status)<br/>' ?>
                </h3>

            </div>

            <div class="panel-container show">
                <div class="panel-content h3">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6" >
                            <?=
                            DetailView::widget([
                                'model' => $model->bc_model,
                                'options' => ['class' => 'table table-striped table-bordered detail-view'],
                                //'template' =>'<tr><td}>{label}</td><th>{value}</th></tr>',
                                'attributes' => [
                                    [
                                        'attribute' => 'iibf_date',
                                        'format' => 'raw',
                                        'label' => 'IIBF सर्टिकेशन की तिथि:',
                                        'value' => function ($model) {
                                            $status = '';
                                            if ($model->bc_shg_funds_status == 1) {
                                                $status = 'Yes';
                                            }
                                            if ($model->bc_shg_funds_status == 0) {
                                                $status = 'No';
                                            }
                                            return \Yii::$app->formatter->asDatetime($model->iibf_date, "php:Y-m-d");
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_shg_funds_status',
                                        'format' => 'raw',
                                        'label' => 'क्या बीसी सपोर्ट फण्ड प्राप्त है?:',
                                        'value' => function ($model) {
                                            $status = '';
                                            if ($model->bc_shg_funds_status == 1) {
                                                $status = 'Yes';
                                            }
                                            if ($model->bc_shg_funds_status == 0) {
                                                $status = 'No';
                                            }
                                            return $status;
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_return_amount',
                                        'label' => 'बीसी सपोर्ट फण्ड वापसी',
                                        'visible' => $model->bc_model->bc_shg_funds_status,
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return '';
                                        }
                                    ],
                                ],
                            ])
                            ?>

                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6" >

                            <?=
                            DetailView::widget([
                                'model' => $model->bc_model,
                                'attributes' => [
                                    [
                                        'attribute' => 'handheld_machine_status',
                                        'label' => 'हैंडहेल्ड डिवाइस प्राप्त:',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->handheld_machine_status == 1 ? \Yii::$app->formatter->asDatetime($model->handheld_machine_date, "php:Y-m-d") : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'onboard',
                                        'label' => 'बीसी सखी ऑनबोर्डिंग:',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->onboarding == 1 ? \Yii::$app->formatter->asDatetime($model->onboarding_date_time, "php:Y-m-d") : 'No';
                                        }
                                    ],
                                    [
                                        'attribute' => 'operational',
                                        'label' => 'बीसी सखी ऑपरेशनल:',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->bc_operational ? 'Yes ( ' . \Yii::$app->formatter->asDatetime($model->transaction_start_date, "php:Y-m-d") . ' )' : 'No';
                                        }
                                    ],
                                ],
                            ])
                            ?>
                        </div> 
                    </div> 

                </div>
                <div class="panel-content h3">
                    <?php if (isset($model->bc_model->bankunwilling) and $model->bc_model->bankunwilling != '') { ?>
                        <h2>बीसी सखी के अनिच्छुक होने के बैंक द्वारा बताये गये कारण</h2>
                        <div class="">
                            <?= $model->bc_model->bankunwilling ?>
                        </div>    
                    <?php } ?>
                    <?php if (isset($model->bc_model->bcunwilling) and $model->bc_model->bcunwilling != '') { ?>
                        <h2>बीसी सखी द्वारा स्वयं अनिच्छा प्रकट किया गया कारण</h2>  
                        <div class="">
                            <?= $model->bc_model->bcunwilling ?>
                        </div>     
                    <?php } ?>
                    <?php if (isset($model->bc_model->cdounwilling) and $model->bc_model->cdounwilling != '') { ?>
                        <h2>बीसी सखी के अनिच्छुक होने के CDO द्वारा बताये गये कारण</h2>  
                        <div class="">
                            <?= $model->bc_model->cdounwilling ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6" >
                                <?=
                                DetailView::widget([
                                    'model' => $model->bc_model->bankunw,
                                    'options' => ['class' => 'table table-striped table-bordered detail-view'],
                                    //'template' =>'<tr><td}>{label}</td><th>{value}</th></tr>',
                                    'attributes' => [
                                        [
                                            'attribute' => 'is_pvr',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->pvr;
                                            }
                                        ],
                                        [
                                            'attribute' => 'is_shg_assign',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->shgassign;
                                            }
                                        ],
                                        [
                                            'attribute' => 'is_bc_shg_bank',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->bcshgbank;
                                            }
                                        ],
                                        [
                                            'attribute' => 'is_pfms_mapping',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->pfmsmapping;
                                            }
                                        ],
                                        [
                                            'attribute' => 'is_bc_receive_support_fund',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->bcreceivesupportfund;
                                            }
                                        ],
                                        [
                                            'attribute' => 'return_date_of_support_fund',
                                            'format' => 'raw',
                                            'visible' => ($model->bc_model->bankunw->is_bc_receive_support_fund == 1 and $model->bc_model->bankunw->funds_returned_to_shg == 2),
                                            'value' => function ($model) {
                                                return $model->return_date_of_support_fund;
                                            }
                                        ],
                                        [
                                            'attribute' => 'support_fund_responsible_name',
                                            'format' => 'raw',
                                            'visible' => ($model->bc_model->bankunw->is_bc_receive_support_fund == 1 and $model->bc_model->bankunw->funds_returned_to_shg == 2),
                                            'value' => function ($model) {
                                                return $model->support_fund_responsible_name;
                                            }
                                        ],
                                    ],
                                ])
                                ?>

                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6" >

                                <?=
                                DetailView::widget([
                                    'model' => $model->bc_model->bankunw,
                                    'attributes' => [
                                        [
                                            'attribute' => 'is_support_fund_shg',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->supportfundshg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'is_onboarding',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->onboarding;
                                            }
                                        ],
                                        [
                                            'attribute' => 'is_handheld_machine',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->handheldmachine;
                                            }
                                        ],
                                        [
                                            'attribute' => 'is_bc_operational',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->bcoperational;
                                            }
                                        ],        
                                        [
                                            'attribute' => 'funds_returned_to_shg',
                                            'format' => 'raw',
                                            'visible' => $model->bc_model->bankunw->is_bc_receive_support_fund == 1,
                                            'value' => function ($model) {
                                                return $model->fundsreturnedtoshg;
                                            }
                                        ],
                                        [
                                            'attribute' => 'support_fund_responsible_mobile_no',
                                            'format' => 'raw',
                                            'visible' => ($model->bc_model->bankunw->is_bc_receive_support_fund == 1 and $model->bc_model->bankunw->funds_returned_to_shg == 2),
                                            'value' => function ($model) {
                                                return $model->support_fund_responsible_mobile_no;
                                            }
                                        ],
                                    ],
                                ])
                                ?>
                            </div> 
                        </div>
                    <?php } ?> 
                    <?php if (isset($model->bc_model->upsrlmunwilling) and $model->bc_model->upsrlmunwilling != '') { ?>
                        <h2>बीसी सखी के अनिच्छुक होने के UPSRLM द्वारा बताये गये कारण</h2>  
                        <div class="">
                            <?= $model->bc_model->upsrlmunwilling ?>
                        </div>     
                    <?php } ?>    
                </div>
            </div>  
        </div>
    </div>
</div>  
