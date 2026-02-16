<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\bootstrap4\Modal;
use bc\modules\selection\models\SrlmBcApplication;
use common\models\master\MasterRole;
/* @var $this yii\web\View */
/* @var $model app\models\Center */


\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'Training Detail' ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
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
                                    'value' => function($model) {
                                        return date("d-m-Y", strtotime($model->training_start_date));
                                    }
                                ],
                                [
                                    'attribute' => 'training_end_date',
                                    'format' => 'raw',
                                    'enableSorting' => false,
                                    'value' => function($model) {
                                        return date("d-m-Y", strtotime($model->training_end_date));
                                    }
                                ],
                                [
                                    'attribute' => 'contact person',
                                    'format' => 'raw',
                                    'enableSorting' => false,
                                    'value' => function($model) {
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
                                    'value' => function($model) {
                                        return implode("<br/>", array_unique(yii\helpers\ArrayHelper::getColumn($model->rsethileadbank, 'profile.bank_name')));
                                    },
                                ],
                                [
                                    'attribute' => 'bc_bank_partner',
                                    'label' => 'BC Partner Bank',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function($model) {
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
                                    'value' => function($model) {
                                        return $model->batchstatus;
                                    },
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
                                    'attribute' => 'schedule_date_of_exam',
                                    'enableSorting' => false,
                                    'value' => function($model) {
                                        return $model->schedule_date_of_exam != null ? \Yii::$app->formatter->asDatetime($model->schedule_date_of_exam, "php:d-m-Y") : "";
                                    }
                                ],
                                [
                                    'attribute' => 'no_of_participant',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function($model) {
                                        return $model->no_of_participant;
                                    }
                                ],
                                [
                                    'attribute' => 'no_of_gp_covered',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function($model) {
                                        return $model->no_of_gp_covered;
                                    }
                                ],
                                [
                                    'attribute' => 'no_of_participant_certified',
                                    'label' => 'No of participant Certified',
                                    'enableSorting' => false,
                                    'value' => function($model) {
                                        return $model->getParticipant()->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS])->count();
                                    },
                                ],
                                [
                                    'attribute' => 'no_of_participant_not_certified',
                                    'label' => 'No of participant Not Certified',
                                    'enableSorting' => false,
                                    'value' => function($model) {
                                        return $model->getParticipant()->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_FAIL])->count();
                                    },
                                ],
                                [
                                    'attribute' => 'no_of_participant_ineligible',
                                    'label' => 'No of participant Ineligible',
                                    'enableSorting' => false,
                                    'value' => function($model) {
                                        return $model->getParticipant()->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE])->count();
                                    },
                                ],
                                [
                                    'attribute' => 'no_of_participant_not_absent',
                                    'label' => 'No of participant Absent',
                                    'enableSorting' => false,
                                    'value' => function($model) {
                                        return $model->getParticipant()->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ABSENT])->count();
                                    },
                                ],
                                [
                                    'attribute' => 'action',
                                    'format' => 'raw',
                                    'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT]) and $model->status==1 and $model->getParticipant()->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH])->count() == 0,
                                    'value' => function($model) {
                                        return Html::a('<span class="fa fa-eject">Conclude</span>', ['/training/training/conclude/?trainingid=' . $model->id], [
                                            'class' => '',
                                            'data-pjax' => "0",
                                            'class' => 'btn  btn-info',
                                            'data' => [
                                                'confirm' => 'Are you absolutely sure conclude this batch training ?this action not undone',
                                                'method' => 'post',
                                            ],
                                        ]);
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
