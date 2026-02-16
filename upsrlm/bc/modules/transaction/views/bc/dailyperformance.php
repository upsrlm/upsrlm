<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'Performance BCS ' ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    Pjax::begin([
                        'id' => 'grid-data',
                        'enablePushState' => FALSE,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                    ]);
                    ?>
                    <div class="clearfix pt-3"></div>

                    <?php
                    $form = ActiveForm::begin([
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'search-form'
                                ],
                                'id' => 'search-form',
                                'layout' => 'inline',
                                'method' => 'get',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_searchdaily', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <?php ActiveForm::end(); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'header' => 'Srl.No.',],
                            [
                                'attribute' => 'bc_application_id',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->bc) ? $model->bc->name : '';
                                    // return isset($model->bc) ? Html::a($model->bc->name, "/training/participants/detail?bcid=" . $model->bc->id, ['target' => '_blank', 'data-pjax' => "0"]) : '';
                                }
                            ],
                            [
                                'attribute' => 'district_code',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->district) ? $model->district->district_name : '';
                                }
                            ],
                            [
                                'attribute' => 'block_code',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->block) ? $model->block->block_name : '';
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_code',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->gp) ? $model->gp->gram_panchayat_name : '';
                                }
                            ],
                            [
                                'attribute' => 'master_partner_bank_id',
                                'visible' => (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])),
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->pbank) ? $model->pbank->bank_short_name : '';
                                }
                            ],
                            [
                                'attribute' => 'start_date',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->transaction_start_date) ? \Yii::$app->formatter->asDatetime($model->transaction_start_date, "php:d M-Y") : '';
                                }
                            ],
                            [
                                'attribute' => 'date',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->date) ? $model->date : '';
                                }
                            ],
                            [
                                'attribute' => 'no_of_transaction',
                                'value' => function ($model) {
                                    return isset($model->no_of_transaction) ? $model->no_of_transaction : '';
                                }
                            ],
                            [
                                'attribute' => 'transaction_amount',
                                'value' => function ($model) {
                                    return $model->transaction_amount;
                                }
                            ],
                            [
                                'attribute' => 'commission_amount',
                                'contentOptions' => ['class' => 'text-right'],
                                'value' => function ($model) {
                                    return isset($model->commission_amount) ? common\helpers\Utility::numberIndiaStyle($model->commission_amount, 2) : '';
                                }
                            ],
                        ],
                    ]);
                    ?>
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $(this).closest('form').submit();
});            
   
JS;
                    $this->registerJs($script);
                    ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>    
    </div>
</div>

