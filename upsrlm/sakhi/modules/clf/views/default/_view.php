<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;
use common\models\master\MasterRole;
?>

<div class="panel panel-default">
    <div class='panel-body'>
        <?php $form = ActiveForm::begin(['id' => 'form-clf', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
        <?php ActiveForm::end(); ?>
        <?=
        DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-striped table-bordered detail-view'],
            'template' => "<tr><th style='width:40%'>{label}</th><td class='col-sm-8'>{value}</td></tr>",
            'attributes' => [
//                [
//                    'attribute' => 'id',
//                   
//                    'enableSorting' => false,
//                    'contentOptions' => ['class' => 'info'],
//                ],
                [
                    'attribute' => 'name_of_clf',
                    'label' => 'संकुल का नाम',
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'nrlm_clf_code',
                    'label' => 'NRLM संकुल का कोड',
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'district_name',
                    //'label' => 'District',
                    'label' => 'जिला',
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'block_name',
//                        'label' => 'Block ',
                    'label' => 'ब्लाक',
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'no_of_vo_connected',
                    'label' => 'संकुल से कितने ग्राम संगठन संबद्ध हैं',
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'no_of_shg_connected',
                    'label' => 'संकुल से कुल कितने SHG सम्बद्ध हैं',
                    'contentOptions' => ['style' => 'width: 8%'],
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'no_of_gps_covered',
                    'label' => 'संकुल कितने ग्राम पंचायत को आच्छादित करती हैं',
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'date_of_formation',
                    'label' => 'गठन की तिथि',
                    'contentOptions' => ['style' => 'width: 10%'],
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'total_amount_received',
                    'label' => 'कुल राशि प्राप्त हुई ',
                    //'label' => 'Total amount received',
                    'format' => 'html',
                    'enableSorting' => false,
                    'value' => function($model) {
                        return $model->getFunds()->sum('total_amount_received') != null ? common\helpers\Utility::numberIndiaStyle($model->getFunds()->sum('total_amount_received')) : '';
                    }
                ],
                [
                    'attribute' => 'total_amount_received',
//                        'label' => "CLFs' updated balance in Bank",
                    'label' => "बैंक में सीएलएफ की अद्यतन शेष राशि ",
                    'format' => 'html',
                    'enableSorting' => false,
                    'value' => function($model) {
                        return $model->updated_balance_in_bank != null ? common\helpers\Utility::numberIndiaStyle($model->updated_balance_in_bank + $model->updated_balance_in_bank2) : '';
                    }
                ],
//                [
//                    'attribute' => 'status',
//                    'contentOptions' => ['style' => 'width: 5%'],
//                    'format' => 'html',
//                    'enableSorting' => false,
//                    'value' => function($model) {
//                        return $model->clfstatus;
//                    }
//                ],
                [
                    'attribute' => '',
                    'format' => 'raw',
                    'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_CBO_USER]),
                    'value' => function ($model) {

                        $html = '<span id="' . $model->id . '">';
                        $html .= "</span>";
                        $html .= Html::a('<span class="fal fa-edit"></span>', ['/clf/default/update?clfid=' . $model->id], [
                                    'data-pjax' => "0",
                                    'class' => 'btn btn-sm btn-info',
                                ]) . ' ';
                        $html .= Html::a('<span class="fal fa-eye"></span>', ['/clf/default/view?clfid=' . $model->id], [
                                    'data-pjax' => "0",
                                    'class' => 'btn btn-sm btn-info',
                        ]);
                        return $html;
                    }
                ],
            ],
        ])
        ?>
    </div>
</div>
