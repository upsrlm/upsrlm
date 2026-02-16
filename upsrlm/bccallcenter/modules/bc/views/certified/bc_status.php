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
                    <?= 'बीसी सखी की अद्यतन स्थिति (Status)' ?>
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
               
            </div>  
        </div>
    </div>
</div>  
