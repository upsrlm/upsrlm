<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\User;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel bc\models\transaction\BcTransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "BC's Transactions report";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">
                    <?php if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT])) { ?>
                        <?= Html::a('Upload Transaction CSV', ['/partneragencies/transaction/import'], ['class' => 'btn btn-success']) ?>
                    <?php } ?>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
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


                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-6"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'afterHeader' =>in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN,MasterRole::ROLE_MD,MasterRole::ROLE_MSC,MasterRole::ROLE_BANK_DISTRICT_UNIT])? [
                            [
                                'columns' => [
                                    
                                    ['content' => 'Total', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => \Yii::$app->formatter->asDatetime($searchModel->month, "php:M-Y"), 'options' => ['colspan' => 1, 'class' => 'bg-warning-100']],
                                    ['content' => \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::getTotal($dataProvider, 'no_of_transaction', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::getTotal($dataProvider, 'no_of_bc', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => common\helpers\Utility::numberIndiaStyle(\bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::getTotal($dataProvider, 'total_txn_amount', $searchModel)), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => common\helpers\Utility::numberIndiaStyle(\bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::getTotal($dataProvider, 'total_bc_commition', $searchModel), 2), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                    ['content' => \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::getTotal($dataProvider, 'download', $searchModel), 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100']],
                                ],
                            ]
                        ]:'',
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                            ],
                            [
                                'attribute' => 'transaction_date',
                                'header' => 'Date',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->date;
                                }
                            ],
                            [
                                'attribute' => 'no_of_transaction',
                                'header' => 'No. of transaction',
                                'enableSorting' => false,
                                'value' => function ($model) use ($searchModel) {

                                    return $model->getTransaction($model, $searchModel);
                                }
                            ],
                            [
                                'attribute' => 'no_of_bc',
                                'header' => 'No. of BC',
                                'enableSorting' => false,
                                'value' => function ($model) use ($searchModel) {

                                    return $model->getNobc($model, $searchModel);
                                }
                            ],
                            [
                                'attribute' => 'total_txn_amount',
                                'header' => 'Total Txn amount',
                                'enableSorting' => false,
                                'value' => function ($model) use ($searchModel) {

                                    return common\helpers\Utility::numberIndiaStyle($model->getTotaltxnamount($model, $searchModel));
                                }
                            ],
                            [
                                'attribute' => 'total_bc_commition',
                                'header' => 'Total BC Commission',
                                'enableSorting' => false,
                                'value' => function ($model) use ($searchModel) {

                                    return common\helpers\Utility::numberIndiaStyle($model->getTotalbccom($model, $searchModel), 2);
                                }
                            ],
                           [
                                'attribute' => 'Download',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) use ($searchModel) {
                                    return Html::a('<i class="fal fa fa-download"> Download</i>', [$model->getDownloadurl($model, $searchModel)], [
                                        'title' => 'Download',
                                        'data-pjax' => "0",
                                        'class' => 'btn  btn-info',
                                    ]);
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
    var loader = $(".ajax");
    $(document).on({
        ajaxStart: function () {
            loader.addClass("loader");
        },
        ajaxStop: function () {
            loader.removeClass("loader");
        }
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
