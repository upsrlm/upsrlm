<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\Utility;
use yii\widgets\ListView;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class='panel-body'>
                <section class="member_section">
                    <div class="container-fluid">
                        <div class="row"> 
                            <div class="col-md-12 col-12">

                                <div class="member_heading">
                                    <h3>VO ऋण</h3>
                                </div>
                            </div>
                            <?php
                            if (isset($model->vos)) {
                                foreach ($model->vos as $vo) {
                                    ?>
                                    <div class="col-md-12 col-12">
                                        <div class="card_box border-bottom2 border-primary shadow">
                                            <h6 class="text-primary"><?= $vo->name_of_vo ?> <a href="/clf/default/addfundsvo?clfid=<?= $vo->cbo_clf_id ?>&void=<?= $vo->id ?>" class="text-right btn btn-info"><i class="fal fa-plus"></i></a></h6>
                                                    <?php
                                                    if (isset($vo->clfFunds)) {
                                                        foreach ($vo->clfFunds as $clffunds) {
                                                            ?> 
                                                            <?=
                                                            DetailView::widget([
                                                                'model' => $clffunds,
                                                                'attributes' => [
                                                                    [
                                                                        'attribute' => 'date_fund_loan_provision',
                                                                        //'label' => 'अगर उन्हें कोई फंड/ ऋण प्रदान की गई तो वह तिथि दर्ज करें',
                                                                        'label' => 'ऋण तिथि',
                                                                        'value' => function ($model) {
                                                                            return $model->date_fund_loan_provision != null ? $model->date_fund_loan_provision : '';
                                                                        },
                                                                    ],
                                                                    [
                                                                        'attribute' => 'fund_type',
                                                                        'label' => 'थीमेटिक स्कीम',
                                                                        //'label' => 'किस थीमेटिक स्कीम के तहत ऋण/ फण्ड दी गयी',
                                                                        'value' => function ($model) {
                                                                            return $model->type != null ? $model->type->fund_type : '';
                                                                        },
                                                                    ],
                                                                    [
                                                                        'attribute' => 'loan_funds_amount',
                                                                        'label' => 'कितनी ऋण/ फण्ड दी गयी',
                                                                        'value' => function ($model) {
                                                                            return $model->loan_funds_amount;
                                                                        },
                                                                    ],
                                                                    [
                                                                        'attribute' => 'refund_amount',
                                                                        'label' => 'वापसी राशि',
                                                                        'value' => function ($model) {
                                                                            return $model->refund_amount != null ? $model->refund_amount : '';
                                                                        },
                                                                    ],
                                                                    [
                                                                        'attribute' => '',
                                                                        'format' => 'raw',
                                                                        'visible' => in_array(Yii::$app->user->identity->role, [common\models\master\MasterRole::ROLE_CBO_USER]),
                                                                        'value' => function ($model) {

                                                                            $html = '<span id="' . $model->id . '">';
                                                                            $html .= "</span>";
                                                                            $html .= Html::a('<span class="fal fa-edit"></span>', ['/clf/default/addfundsvo?clfid=' . $model->cbo_clf_id . '&void=' . $model->cbo_vo_id . '&clfvofundsid=' . $model->id], [
                                                                                        'data-pjax' => "0",
                                                                                        'class' => 'btn btn-info',
                                                                            ]);
                                                                            return $html;
                                                                        }
                                                                    ],
                                                                ],
                                                            ])
                                                            ?>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>