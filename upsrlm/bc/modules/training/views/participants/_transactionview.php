<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\User;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    
                </div>
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
         
                    <div class="col-xl-12 mt-3">
                        <div class="row">

                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('no_of_transaction'));
                                            ?>
                                            <small class="m-0 l-h-n">Total no. of Txn.</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-dark', 'name' => 'button_type', 'value' => '2'])  ?>   
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
                                                echo '<i class="fal fa-rupee-sign"></i> ' . common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('transaction_amount'));
                                            ?>
                                            <small class="m-0 l-h-n">Total transaction amount</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-dark', 'name' => 'button_type', 'value' => '3'])  ?>   
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
                                                echo '<i class="fal fa-rupee-sign"></i> ' . common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('commission_amount'));
                                            ?>
                                            <small class="m-0 l-h-n">Total BC commission earned</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-dark', 'name' => 'button_type', 'value' => '4'])  ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-rupee-sign fa-spin position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-12" ">
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
                                'attribute' => 'month',
                                 'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->month_start_date) ? \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y") : '';
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
                                'attribute' => 'total_working_day',
                                'header'=>"No. of days worked in the month",
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->total_working_day) ? $model->total_working_day : '';
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
                        ],
                    ]);
                    ?>
                    </div> 
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
<div class="clearfix"></div>