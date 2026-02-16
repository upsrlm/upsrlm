<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<?php if (isset($model->verification_status) and $model->verification_status) { ?>
    <div class="panel panel-info">
        <div class="panel-heading panel-info">
            <i class='icon-minus-sign'></i>
            Verification status  : <span class="badge badge-info"> <?= $model->verificationstatus ?></span>        

        </div>            
        <div class='box-content box-status'>
            <div class="row">
                <div class="col-md-6">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'verify_vo_name_code_address',
                                'format' => 'raw',
                                'value' => $model->verify1status,
                            ],
                            [
                                'attribute' => 'verify_vo_formation_date_no_shg',
                                'format' => 'raw',
                                'value' => $model->verify2status,
                            ],
                            [
                                'attribute' => 'verify_vo_related_to_bank_account',
                                'format' => 'raw',
                                'value' => $model->verify3status,
                            ],
                            [
                                'attribute' => 'verify_vo_total_amount',
                                'format' => 'raw',
                                'value' => $model->verify4status,
                            ],
                            [
                                'attribute' => 'verify_vo_affiliated_shg_detail',
                                'format' => 'raw',
                                'value' => $model->verify5status,
                            ],
                        ],
                    ])
                    ?>
                </div>
                <div class="col-md-6">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'verify_vo_members_detail',
                                'format' => 'raw',
                                'value' => $model->verify6status,
                            ],
                            [
                                'attribute' => 'verify_vo_any_other_info',
                                'format' => 'raw',
                                'value' => $model->verify7status,
                            ],
                            [
                                'attribute' => 'verify_by',
                                'format' => 'raw',
                                'value' => isset($model->verifyby) ? $model->verifyby->name : ''
                            ],
                            [
                                'attribute' => 'verify_datetime',
                                'format' => 'raw',
                                'value' => $model->verify_datetime,
                            ],
                            [
                                'attribute' => 'verification_status',
                                'format' => 'raw',
                                'value' => $model->verificationstatus,
                            ],
                        ],
                    ])
                    ?> 
                </div>
            </div>
        </div>
    </div>
<?php } ?>