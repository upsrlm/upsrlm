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
                    'attribute' => 'mobile_no',
                    'label' => 'मोबाइल नंबर',
                    'value' => function ($model) {
                        return $model->mobile_no;
                    },
                ],
                [
                    'attribute' => 'role',
                    'label' => 'विलेज आर्गेनाइजेशन में भूमिका',
                    'value' => function ($model) {
                        return $model->memberrole != null ? $model->memberrole->role : '';
                    },
                ],
                [
                    'attribute' => 'bank_operator',
                    'label' => 'क्या बैंक अकाउंट संचालक हैं?',
                    'value' => function ($model) {
                        return $model->operator;
                    },
                ],
                [
                    'attribute' => 'cbo_vo_id',
                    'label' => 'विलेज आर्गेनाइजेशन',
                    'value' => function ($model) {
                        return $model->vo != null ? $model->vo->name_of_vo : '';
                    },
                ],
                [
                    'attribute' => 'cbo_vo_off_bearer',
                    'value' => function ($model) {
                        return $model->vooffbearer;
                    },
                ],
                [
                    'attribute' => 'cbo_shg_id',
                    'value' => function ($model) {
                        return $model->shg != null ? $model->shg->name_of_shg : '';
                    },
                ],
                [
                    'attribute' => 'cbo_shg_off_bearer',
                    'value' => function ($model) {
                        return $model->shgoffbearer;
                    },
                ],
                [
                    'attribute' => '',
                    'format' => 'raw',
                    'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_CBO_USER]),
                    'value' => function ($model) {

                        $html = '<span id="' . $model->id . '">';
                        $html .= "</span>";
                        $html .= Html::a('<span class="fal fa-edit"></span>', ['/clf/default/updatemember?clfid=' . $model->cbo_clf_id . '&clfmemberid=' . $model->id], [
                                    'data-pjax' => "0",
                                    'class' => 'btn btn-sm btn-info',
                                ]) . ' ';
                        $html .= Html::a('<span class="fal fa-times"></span>', ['/clf/default/removemember?clfid=' . $model->cbo_clf_id . '&clfmemberid=' . $model->id], [
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

