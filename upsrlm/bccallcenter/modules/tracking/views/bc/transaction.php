<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
use kartik\icons\FontAwesomeAsset;
use kartik\grid\ExpandRowColumn;
FontAwesomeAsset::register($this);
$this->title = 'Previous 15 Days Transaction Performance of  BCs ';
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
<?= 'Previous 15 Days Transaction Performance of  BCs ' ?>
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
                    echo $this->render('_searchtransaction', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    $transaction = Yii::$app->params['txn'];
                    $txn_amn = '0';
                    $com_amn = Yii::$app->params['txn_com'];
                    $ext_txn_amn = Yii::$app->params['txn_amn'];
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
                                'class' => 'kartik\grid\ExpandRowColumn',
                                'width' => '50px',
                                'value' => function ($model, $key, $index, $column) {
                                    return GridView::ROW_COLLAPSED;
                                },
                                'detailUrl' => Url::to(['/tracking/bc/detailgraph']),
                                'headerOptions' => ['class' => 'kartik-sheet-style'],
                                'expandOneOnly' => true,
                                'expandIcon' => '<span class="fal fa fa-caret-right glyphicon glyphicon-triangle-right"></span>',
                                'collapseIcon' => '<span class="fal fa fa-chevron-down glyphicon glyphicon-triangle-bottom"></span>',
                                'detailRowCssClass' => 'table'
                                   
                            ],
                            [
                                'attribute' => 'bc_name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->bc_name;
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->district_name) ? $model->district_name : '';
                                }
                            ],
                            [
                                'attribute' => 'block_name',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->block_name) ? $model->block_name : '';
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->gram_panchayat_name) ? $model->gram_panchayat_name : '';
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
                                'header' => 'Zero Amount transaction',
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
//                            [
//                                'attribute' => 'no_of_days',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return isset($model->days) ? $model->days : '';
//                                }
//                            ],
                            [
                                'attribute' => 'working_day',
                                'enableSorting' => true,
                                'value' => function ($model) {
                                    return $model->working_day;
                                }
                            ],
                            [
                                'attribute' => 'not_working_day',
                                'enableSorting' => true,
                                'value' => function ($model) {
                                    return $model->not_working_day;
                                }
                            ],
                            [
                                'attribute' => 'Action',
                                'header' => 'ऐक्शन ',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'visible' => \Yii::$app->params['airphone_call'] and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE]),
                                'value' => function ($model) {
                                    return isset($model->callbutton) ? $model->callbutton : '';
                                }
                            ],
                           [
                                'attribute' => 'Action',
                                'header' => 'ऐक्शन ',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]),
                                'value' => function ($model) {
                                    return (isset($model->user) and $model->user->app_id) ? \yii\helpers\Html::a('<i class="fal fa fa-bell"></i> Send notification ', ['/platform/firebase/message?userid=' . $model->user_id], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']) : '';
                                }
                            ],         
                        ],
                    ]);
                    ?>
                    <?php
                    $js = <<<js
        
        $(document).ready(function(){         
            
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/tracking/bc/transaction"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

                    $this->registerJs($js);
                    ?>     
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/tracking/bc/transaction"});
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

