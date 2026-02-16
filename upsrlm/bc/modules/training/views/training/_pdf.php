<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use bc\modules\selection\models\SrlmBcApplication;
use kartik\grid\GridView;
use yii\widgets\Pjax;
?>
<div class="baseline-master-center-view">
    <div class="box box-info">
        <div class="row-fluid">

            <div class="panel panel-primary">
                <div class="panel-heading"> <?= 'Training Detail' ?>

                </div>
                <div class="panel-body">
                    <div class="col-sm-6 col-md-6 col-lg-6" >
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'options' => ['class' => 'table table-striped table-bordered detail-view'],
                            'template' => '<tr><th width="50%">{label}</th><td width="50%">{value}</td></tr>',
                            'attributes' => [
                                [
                                    'attribute' => 'batch_name',
                                    'enableSorting' => false,
                                    'value' => $model->tbatch->batch_name,
                                ],
                                [
                                    'attribute' => 'district_name',
                                    'enableSorting' => false,
                                    'value' => $model->center->district_name,
                                ],
//                                [
//                                    'attribute' => 'Venue',
//                                    'enableSorting' => false,
//                                    'value' => $model->center->name,
//                                ],
                                [
                                    'attribute' => 'training_start_date',
                                    'format' => 'raw',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return date("d-m-Y", strtotime($model->training_start_date));
                                    }
                                ],
                                [
                                    'attribute' => 'training_end_date',
                                    'format' => 'raw',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return date("d-m-Y", strtotime($model->training_end_date));
                                    }
                                ],
                                [
                                    'attribute' => 'contact person',
                                    'format' => 'raw',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        $html = '';
                                        if ($model->contacts != null) {
                                            foreach ($model->contacts as $contact) {
                                                $html .= $contact->user->name . " (" . $contact->user->mobile_no . ")" . "<br/>";
                                            }
                                        }
                                        return $html;
                                    }
                                ],
                                [
                                    'attribute' => 'lead_bank',
                                    'label' => 'RSETI Bank',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        return implode("<br/>", array_unique(yii\helpers\ArrayHelper::getColumn($model->rsethileadbank, 'profile.bank_name')));
                                    },
                                ],
                                [
                                    'attribute' => 'bc_bank_partner',
                                    'label' => 'BC Partner Bank',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        $html = '';
                                        if ($model->bcbankpartner != null) {
                                            foreach ($model->bcbankpartner as $bcbankpartner) {
                                                $html .= $bcbankpartner->user->name . "<br/>";
                                            }
                                        }
                                        return $html;
                                    },
                                ],
                                [
                                    'attribute' => 'batch_status',
                                    'label' => 'Batch Status',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->batchstatus;
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
                            'template' => '<tr><th width="50%">{label}</th><td width="50%">{value}</td></tr>',
                            'attributes' => [
                                [
                                    'attribute' => 'schedule_date_of_exam',
                                    'label' => 'Schedule date of exam',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->schedule_date_of_exam != null ? \Yii::$app->formatter->asDatetime($model->schedule_date_of_exam, "php:d-m-Y") : "";
                                    }
                                ],
                                [
                                    'attribute' => 'no_of_participant',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->no_of_participant;
                                    }
                                ],
                                [
                                    'attribute' => 'no_of_gp_covered',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->no_of_gp_covered;
                                    }
                                ],
                                [
                                    'attribute' => 'no_of_participant_certified',
                                    'label' => 'No of participant Certified',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->getParticipant()->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS])->count();
                                    },
                                ],
                                [
                                    'attribute' => 'no_of_participant_not_certified',
                                    'label' => 'No of participant Not Certified',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->getParticipant()->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_FAIL])->count();
                                    },
                                ],
                                [
                                    'attribute' => 'no_of_participant_ineligible',
                                    'label' => 'No of participant Ineligible',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->getParticipant()->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE])->count();
                                    },
                                ],
                                [
                                    'attribute' => 'no_of_participant_not_absent',
                                    'label' => 'No of participant Absent',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->getParticipant()->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ABSENT])->count();
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
    <div class="training-default-index">
        <div class="panel panel-primary">
            <div class="panel-heading"> <?= 'Training participant' ?></div>
            <div class='panel-body'>

                <div class="clearfix"></div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProviderp,
                    'layout' => "\n{items}",
                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                    'id' => 'grid-data',
                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                    'pjax' => TRUE,
                    'floatHeader' => true,
                    'floatHeaderOptions' => ['scrollingTop' => '50'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 5%', 'class' => 'text-center']],
                        [
                            'attribute' => 'name',
                            'header' => 'Name/ <br/>Mobile No',
                            'enableSorting' => false,
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->participant->name.'<br/>'.common\helpers\Utility::mask($model->mobile_number).'<br/>'.common\helpers\Utility::mask($model->otp_mobile_no);
                            }
                        ],
                        [
                            'attribute' => 'gram_panchayat_name',
                            'format' => 'html',
                            'header' => 'GP <br/>Block',
//                        'contentOptions' => ['style' => 'width: 10%'],
                            'enableSorting' => false,
                            'value' => function ($model) {
                                return $model->gram_panchayat_name . '<br/> (' . $model->block_name . ')';
                            }
                        ],
//                    [
//                        'label' => 'Training',
//                        'attribute' => 'start_date',
//                        'contentOptions' => ['style' => 'width: 12%;'],
//                        'format' => 'raw',
//                        'value' => function($model) {
//                            return isset($model->training) ? $model->training->date : '';
//                        }
//                    ],
//                        [
//                            'attribute' => 'schedule_date_of_exam',
////                        'contentOptions' => ['style' => 'width: 12%'],
//                            'enableSorting' => false,
//                            'value' => function($model) {
//                                return isset($model->training) ? \Yii::$app->formatter->asDatetime($model->training->schedule_date_of_exam, "php:d-m-Y") : "";
//                            }
//                        ],
                        [
                            'attribute' => 'exam_score',
//                        'contentOptions' => ['style' => 'width: 6%'],
                            'enableSorting' => false,
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->exam_score != null ? $model->exam_score : '';
                            }
                        ],
                        [
                            'attribute' => 'certificate_code',
//                        'contentOptions' => ['style' => 'width: 8%'],
                            'enableSorting' => false,
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->certificate_code != null ? $model->certificate_code : '';
                            }
                        ],
                        [
                            'attribute' => 'training_status',
//                        'contentOptions' => ['style' => 'width: 8%'],
                            'enableSorting' => false,
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->trainingstatus;
                            }
                        ],
                    ],
                ]);
                ?>

            </div>
        </div>
    </div>  
</div>
