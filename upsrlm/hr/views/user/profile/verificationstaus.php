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
                                'attribute' => 'verification_status1',
                                'format' => 'raw',
                                'value' => $model->verificationstatus1,
                            ],
                            [
                                'attribute' => 'verification_status2',
                                'format' => 'raw',
                                'value' => $model->verificationstatus2,
                            ],
                            [
                                'attribute' => 'verification_status3',
                                'format' => 'raw',
                                'value' => $model->verificationstatus3,
                            ],
                            [
                                'attribute' => 'verification_status4',
                                'format' => 'raw',
                                'value' => $model->verificationstatus4,
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
                                'attribute' => 'verification_status5',
                                'format' => 'raw',
                                'value' => $model->verificationstatus5,
                            ],
                            [
                                'attribute' => 'verification_by',
                                'format' => 'raw',
                                'value' => isset($model->veriyby)?$model->veriyby->name:''
                            ],
                            [
                                'attribute' => 'verification_datetime',
                                'format' => 'raw',
                                'value' => $model->verification_datetime,
                            ],
                        ],
                    ])
                    ?> 
                </div>
            </div>
        </div>
    </div>
<?php } ?>