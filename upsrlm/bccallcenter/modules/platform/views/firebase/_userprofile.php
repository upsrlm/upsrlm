<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

$arr = [
    41 => 'ग्राम पंचायत सचिव प्रोफाइल',
    42 => 'ग्राम पंचायत अधिकारी प्रोफाइल',
    43 => 'ग्राम पंचायत सहायक प्रोफाइल',
    44 => 'ग्राम प्रधान प्रोफाइल',
    45 => 'ग्राम रोजगार सेवक प्रोफाइल',
    46 => 'ग्राम सफाई कर्मचारी प्रोफाइल',
    47 => 'CSO User प्रोफाइल',
    100 => 'CBO / समूह सखी/ सामुदायिक कैडर प्रोफाइल'
];
?>
<div class="row">
    <div class="col-lg-12">

        <h4><?= isset($model->otp_value) ? 'PIN :' . $model->otp_value : '' ?></h4>
        <div class="row">
            <div class="col-md-4">

                <?php
                echo \yii\widgets\DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'name',
                            'label' => 'नाम',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return isset($model->name) ? $model->name : '';
                            },
                        ],
                    ],
                ])
                ?>
            </div>
            <div class="col-md-4">

                <?php
                echo \yii\widgets\DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'mobile_no',
                            'label' => 'मोबाइल नंबर',
                            'enableSorting' => false,
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->username;
                            },
                        ],
                    ],
                ])
                ?>
            </div>
            <div class="col-md-4">

                <?php
                echo \yii\widgets\DetailView::widget([
                    'model' => $bc_model,
                    'attributes' => [
                        [
                            'attribute' => 'Location',
                            'label' => 'लोकेशन ',
                            'enableSorting' => false,
                            'format' => 'raw',
                            'value' => function ($bc_model) {
                                $html = '';
                                $html .= $bc_model->district_name;
                                $html .= ' , ' .$bc_model->block_name;
                                $html .= ' , ' .$bc_model->gram_panchayat_name;
                                return $html;
                            },
                        ],
                    ],
                ])
                ?>
            </div>
        </div>     
    </div>

</div>

