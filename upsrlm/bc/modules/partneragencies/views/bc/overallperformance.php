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
                    <?= 'Overall Performance BCs ' ?>
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
                                    'id' => 'Searchform'
                                ],
                                'id' => 'Searchform',
                                'layout' => 'inline',
                                'method' => 'get',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_searchoverallperformance', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <?php ActiveForm::end(); ?>
                    <div class="col-xl-12 mt-3">
                        <div class="row">
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-warning-700 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Total BC operational</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('no_of_transaction'));
                                            ?>
                                            <small class="m-0 l-h-n">Total no. of Txn.</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa fa-volume-up position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo '<i class="fal fa-rupee-sign"></i> '.common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('transaction_amount'));
                                            ?>
                                            <small class="m-0 l-h-n">Total transaction amount</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-rupee-sign fa-spin position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo '<i class="fal fa-rupee-sign"></i> '.common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('commission_amount'));
                                            ?>
                                            <small class="m-0 l-h-n">Total BC commission earned</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-rupee-sign fa-spin position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>

                        </div>

                    </div>
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
                                    return isset($model->bc) ? Html::a($model->bc->name, "/partneragencies/bc/dailyperformance?BcTransactionDailyReportSearch[bc_application_id]=" . $model->bc->id, ['target' => '_blank', 'data-pjax' => "0"]) : '';
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
                                    return isset($model->start_date) ? \Yii::$app->formatter->asDatetime($model->start_date, "php:d M-Y") : '';
                                }
                            ],        
                            [
                                'attribute' => 'no_of_transaction',
                                'value' => function ($model) {
                                    return isset($model->no_of_transaction) ? $model->no_of_transaction : '';
                                }
                            ],
                            [
                                'attribute' => 'zero_transaction',
                                'header'=>'Zero Amount transaction',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->zero_transaction) ? $model->zero_transaction : '';
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
                            [
                                'attribute' => 'no_of_days',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->no_of_days) ? $model->no_of_days : '';
                                }
                            ],
                            [
                                'attribute' => 'no_of_working_days',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->no_of_working_days) ? $model->no_of_working_days : '';
                                }
                            ],
                            [
                                'attribute' => 'no_of_not_working_days',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->no_of_not_working_days) ? $model->no_of_not_working_days : '';
                                }
                            ],
                        ],
                    ]);
                    ?>
                    <?php
                    $js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/partneragencies/bc/downloadoverall"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
             
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/partneragencies/bc/overallperformance"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

                    $this->registerJs($js);
                    ?>     
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/partneragencies/bc/overallperformance"});
    $("#Searchform").attr("data-pjax", "True");                
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

