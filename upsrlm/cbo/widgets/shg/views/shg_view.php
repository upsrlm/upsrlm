<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\master\MasterRole;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $model->name_of_shg ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>

                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <div class="row">
                        <div class="col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'id',
                                    'name_of_shg',
                                    'shg_code',
                                    'district_name',
                                    'block_name',
                                    'gram_panchayat_name',
                                    'village_name',
                                    'hamlet',
                                    'no_of_members',
                                    [
                                        'attribute' => 'date_of_formation',
                                        'value' => function ($model) {
                                            return isset($model->rprofile->date_of_formation) ? $model->rprofile->date_of_formation : '';
                                        },
                                    ],
                                ],
                            ])
                            ?>
                        </div> 
                        <div class="col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    
                                    [
                                        'attribute' => 'created_by',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            $model_user = common\models\User::findOne($model->created_by);
                                            return isset($model_user->name) ? $model_user->name . " (" . $model_user->mobile_no . ")" : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'format' => 'html',
                                        'value' => date('Y-m-d G:i:s', $model->created_at),
                                    ],
                                    [
                                        'attribute' => 'created_by',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            $model_user = common\models\User::findOne($model->updated_by);
                                            return isset($model_user->name) ? $model_user->name . " (" . $model_user->mobile_no . ")" : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'Verified At',
                                        'format' => 'html',
                                        'value' => date('Y-m-d G:i:s', $model->updated_at),
                                    ],
                                    'status',
                                ],
                            ])
                            ?>
                        </div> 
                    </div>

                    <div class="row">
                        <?php if ($model->verification_status) { ?>
                            <div class="col-lg-6">
                                Status of verification
                                <?=
                                DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        [
                                            'attribute' => 'verify_shg_code',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifyshgcodestatus;
                                            },
                                        ],
                                        [
                                            'attribute' => 'verify_shg_location',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifyshglocationstatus;
                                            },
                                        ],
                                        [
                                            'attribute' => 'verify_shg_name ',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifyshgnamestatus;
                                            },
                                        ],
                                        [
                                            'attribute' => 'verify_shg_members',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifyshgmembersstatus;
                                            },
                                        ],
                                        [
                                            'attribute' => 'verify_chaire_person_mobile_no',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifychairepersonmobilenostatus;
                                            },
                                        ],
                                        [
                                            'attribute' => 'verify_secretary_mobile_no',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifysecretarymobilenostatus;
                                            },
                                        ],
                                        [
                                            'attribute' => 'verify_treasurer_mobile_no',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifytreasurermobilenostatus;
                                            },
                                        ],
                                    ],
                                ])
                                ?>  
                            </div> 
                        <?php } ?>

                    </div>
                    <?php
                    if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
                        echo $this->render('_feedback', ['model' => $feedback]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>