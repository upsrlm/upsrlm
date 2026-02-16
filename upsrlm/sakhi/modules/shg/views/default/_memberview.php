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
                    'attribute' => 'name',
                    'label' => 'सदस्य का नाम',
                    'value' => function ($model) {
                        return $model->name;
                    },
                ],
                [
                    'attribute' => 'mobile',
                    'label' => 'मोबाइल न0',
                    'value' => function ($model) {
                        return $model->mobile;
                    },
                ],
                [
                    'attribute' => 'marital_status',
                    'label' => 'विवाहित',
                    'value' => function ($model) {
                        return $model->maritalstatus;
                    },
                ],
                [
                    'attribute' => 'age',
                    'label' => 'उम्र',
                    'value' => function ($model) {
                        return $model->agestatus;
                    },
                ],
                [
                    'attribute' => 'caste_category',
                    'label' => 'सामाजिक वर्ग',
                    'value' => function ($model) {
                        return $model->castecategory;
                    },
                ],
                [
                    'attribute' => 'duration_of_membership',
                    'label' => 'कितने समय से समूह के सदस्य हैं',
                    'value' => function ($model) {
                        return $model->durationofmembership;
                    },
                ],
                [
                    'attribute' => 'total_saving',
                    'label' => 'अबतक समूह में कुल बचत',
                    'value' => function ($model) {
                        return $model->totalsaving;
                    },
                ],
                [
                    'attribute' => 'loan',
                    'label' => 'ऋण प्राप्ति',
                    'value' => function ($model) {
                        return $model->loanstatus;
                    },
                ],   
                [
                    'attribute' => 'loan_count',
                    'label' => 'अगर हाँ, तो कितनी बार',
                    'value' => function ($model) {
                        return $model->loan_count;
                    },
                ],  
                [
                    'attribute' => 'loan',
                    'label' => 'ऋण के रकम व तिथि',
                    'value' => function ($model) {
                        return $model->loan_amount .' / '.$model->loan_date;
                    },
                ],   
                [
                    'attribute' => 'mcp_status',
                    'label' => 'अगर ना, तो MCP की स्थिति',
                    'value' => function ($model) {
                        return $model->mcpstatus;
                    },
                ],       
                [
                    'attribute' => '',
                    'format' => 'raw',
                    // 'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_CBO_USER]),
                    'value' => function ($model) {

                        $html = '<span id="' . $model->id . '">';
                        $html .= "</span>";
                        $html .= Html::a('<span class="fal fa-edit"></span>', ['/shg/default/updatemember?shgid=' . $model->cbo_shg_id . '&shgmemberid=' . $model->id], [
                                    'data-pjax' => "0",
                                    'class' => 'btn btn-sm btn-info',
                                ]) . ' ';

                        $html .= Html::a('<span class="fal fa-edit"></span>', ['/shg/default/officebearers?shgid=' . $model->cbo_shg_id . '&shgmemberid=' . $model->id], [
                            'data-pjax' => "0",
                            'class' => 'btn btn-sm btn-info',
                        ]) . ' ';

                        $html .= Html::a('<span class="fal fa-times"></span>', ['/shg/default/removemember?shgid=' . $model->cbo_shg_id . '&shgmemberid=' . $model->id], [
                                    'class' => '',
                                    'data-pjax' => "0",
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                        'confirm' => 'क्या आप निश्चित रूप से इस सदस्य को हटा रहे हैं ?',
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

