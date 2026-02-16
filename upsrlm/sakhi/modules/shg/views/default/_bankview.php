<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\tabs\TabsX;
use common\models\master\MasterRole;
?>
<div class="incoming-sms-error-view">
    <div class="box">
        <?=
        DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-striped table-bordered detail-view'],
            'template' => "<tr><th class='col-sm-4'>{label}</th><td class='col-sm-8'>{value}</td></tr>",
            'attributes' => [
                [
                    'attribute' => 'bank_account_no_of_the_shg',
                    'label' => 'Bank Account Number',
                    'value' => function ($model) {
                        return $model->bank_account_no_of_the_shg;
                    },
                ],
                [
                    'attribute' => 'bank name',
                    'label' => 'Name of Bank',
                    'value' => function ($model) {
                        return $model->name_of_bank;
                    },
                ],
                [
                    'attribute' => 'branch',
                    'label' => 'Branch Name',
                    'value' => function ($model) {
                        return $model->branch;
                    },
                ],
                [
                    'attribute' => 'branch_code_or_ifsc',
                    'label' => 'Branch Code or IFSC Code',
                    'value' => function ($model) {
                        return $model->branch_code_or_ifsc;
                    },
                ], 
                [
                    'attribute' => 'Date of Opening the Bank Account',
                    'label' => 'Date of opening the bank account',
                    'value' => function ($model) {
                        return $model->date_of_opening_the_bank_account;
                    },
                ], 
                [
                    'attribute' => 'balance_as_on_date',
                    'label' => 'Balance As on Date',
                    'value' => function ($model) {
                        return $model->balance_as_on_date;
                    },
                ], 
                [
                    'attribute' => '',
                    'format' => 'raw',
                    // 'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_CBO_USER]),
                    'value' => function ($model) {

                        $html = '<span id="' . $model->id . '">';
                        $html .= "</span>";
                        $html .= Html::a('<span class="fal fa-edit"></span>', ['/shg/default/bankdetail?shgid=' . $model->cbo_shg_id . '&bankid=' . $model->id], [
                                    'data-pjax' => "0",
                                    'class' => 'btn btn-sm btn-info',
                                ]) . ' ';

                        $html .= Html::a('<span class="fal fa-times"></span>', ['/shg/default/removebank?shgid=' . $model->cbo_shg_id . '&bankid=' . $model->id], [
                                    'class' => '',
                                    'data-pjax' => "0",
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                        'confirm' => 'क्या आप निश्चित रूप से इस बैंक को हटा रहे हैं ?',
                                        'method' => 'post',
                                    ],
                        ]);
                        return $html;
                    }
                ],
            ],
        ])
        ?>
    </div>
</div>

