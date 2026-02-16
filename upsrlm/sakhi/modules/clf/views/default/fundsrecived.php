<?php
//$this->title = 'Update CLF/ क्लस्टर लेवल फेडरेशन/ क्लस्टर स्तरीय संकुल : ' . $model->name_of_clf;
//$this->params['breadcrumbs'][] = $this->title;
?>
<!--<div class="clf-fundsrecived-form">-->

<!--    <div class="panel panel-default">
        <div class='panel-body'>-->

<?php
$this->render('_fundsrecivedform', [
    'model' => $model,
])
?>
<!--        </div>
    </div>    -->

<!--</div>-->
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\Utility;
use yii\widgets\ListView;
?>
<h1>क्लस्टर स्तरीय संकुल के द्वारा प्राप्त धनराशिओं का विवरण</h1>
<div class="panel panel-default">
    <div class='panel-body'>
        <section class="member_section">
            <div class="container-fluid">

                <div class="col-md-12 col-12">
                    <h6 class="text-primary"><?= 'सरकार द्वारा ' ?> <a href="/clf/default/receivefundsgov?clfid=<?= $model->id ?>" class="text-right btn btn-info"><i class="fal fa-plus"></i></a> <?= 'विलेज आर्गेनाइजेशन द्वारा ' ?> <a href="/clf/default/receivefundsvo?clfid=<?= $model->id ?>" class="text-right btn btn-info"><i class="fal fa-plus"></i></a></h6>
                </div>

                <?php
                if (isset($model->funds)) {
                    foreach ($model->funds as $funds) {
                        ?>
                        <div class="col-md-12 col-12">
                            <?=
                            DetailView::widget([
                                'model' => $funds,
                                'attributes' => [
                                    [
                                        'attribute' => 'date_of_receipt',
                                        //'label' => 'अगर उन्हें कोई फंड/ ऋण प्रदान की गई तो वह तिथि दर्ज करें',
                                        'label' => 'धन प्राप्त तिथि',
                                        'value' => function ($model) {
                                            return $model->date_of_receipt != null ? \Yii::$app->formatter->asDatetime($model->date_of_receipt, "php:d-m-Y") : "";
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
                                        'attribute' => 'instalment_if_any',
                                        'label' => 'कोई इंस्टॉलमेंट ',
                                        'value' => function ($model) {
                                            return $model->instalment_if_any != null ? $model->instalment_if_any : '';
                                        },
                                    ],
                                    [
                                        'attribute' => 'total_amount_received',
                                        'label' => 'कुल प्राप्त धनराशि',
                                        'value' => function ($model) {
                                            return $model->total_amount_received != null ? $model->total_amount_received : '';
                                        },
                                    ],
                                    [
                                        'attribute' => 'balance_as_on_date',
                                        'label' => 'बैंक अकाउंट में दर्ज अद्यतन धनराशि',
                                        'value' => function ($model) {
                                            return $model->balance_as_on_date != null ? $model->balance_as_on_date : '';
                                        },
                                    ],
                                    [
                                        'attribute' => '',
                                        'format' => 'raw',
                                        'visible' => in_array(Yii::$app->user->identity->role, [common\models\master\MasterRole::ROLE_CBO_USER]),
                                        'value' => function ($model) {

                                            $html = '<span id="' . $model->id . '">';
                                            $html .= "</span>";
                                            $html .= Html::a('<span class="fal fa-edit"></span>', ['/clf/default/receivefundsgov?clfid=' . $model->cbo_clf_id . '&clffundsid=' . $model->id], [
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


                    <?php
                    }
                }
                ?>
            </div>        

        </section>
        <section class="member_section">
            <div class="container-fluid">

                <div class="col-md-12 col-12">
                    <h6 class="text-primary"><?= 'विलेज आर्गेनाइजेशन द्वारा ' ?> <a href="/clf/default/receivefundsvo?clfid=<?= $model->id ?>" class="text-right btn btn-info"><i class="fal fa-plus"></i></a></h6>
                </div>

                <?php
                if (isset($model->fundsfindvo)) {
                    foreach ($model->fundsfindvo as $fundsvo) {
                        ?>
                        <div class="col-md-12 col-12">
                            <?=
                            DetailView::widget([
                                'model' => $fundsvo,
                                'attributes' => [
                                    [
                                        'attribute' => 'cbo_vo_id',
                                        //'label' => 'अगर उन्हें कोई फंड/ ऋण प्रदान की गई तो वह तिथि दर्ज करें',
                                        'label' => 'विलेज आर्गेनाइजेशन',
                                        'value' => function ($model) {
                                            return $model->vo != null ? $model->vo->name_of_vo : "";
                                        },
                                    ],
                                    [
                                        'attribute' => 'date_of_receipt',
                                        //'label' => 'अगर उन्हें कोई फंड/ ऋण प्रदान की गई तो वह तिथि दर्ज करें',
                                        'label' => 'धन प्राप्त तिथि',
                                        'value' => function ($model) {
                                            return $model->date_of_receipt != null ? \Yii::$app->formatter->asDatetime($model->date_of_receipt, "php:d-m-Y") : "";
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
                                        'attribute' => 'instalment_if_any',
                                        'label' => 'कोई इंस्टॉलमेंट ',
                                        'value' => function ($model) {
                                            return $model->instalment_if_any != null ? $model->instalment_if_any : '';
                                        },
                                    ],
                                    [
                                        'attribute' => 'total_amount_received',
                                        'label' => 'कुल प्राप्त धनराशि',
                                        'value' => function ($model) {
                                            return $model->total_amount_received != null ? $model->total_amount_received : '';
                                        },
                                    ],
                                    [
                                        'attribute' => 'balance_as_on_date',
                                        'label' => 'बैंक अकाउंट में दर्ज अद्यतन धनराशि',
                                        'value' => function ($model) {
                                            return $model->balance_as_on_date != null ? $model->balance_as_on_date : '';
                                        },
                                    ],
                                    [
                                        'attribute' => '',
                                        'format' => 'raw',
                                        'visible' => in_array(Yii::$app->user->identity->role, [common\models\master\MasterRole::ROLE_CBO_USER]),
                                        'value' => function ($model) {

                                            $html = '<span id="' . $model->id . '">';
                                            $html .= "</span>";
                                            $html .= Html::a('<span class="fal fa-edit"></span>', ['/clf/default/receivefundsvo?clfid=' . $model->cbo_clf_id . '&clffundsid=' . $model->id], [
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


                    <?php
                    }
                }
                ?>
            </div>        

        </section>
    </div>
</div>
