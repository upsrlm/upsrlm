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

$this->title = "Transactions w/o BC ID";
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
                        <?= Html::a('Upload Transaction CSV', ['import'], ['class' => 'btn btn-success']) ?>
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


                    <?php echo $this->render('_searchwobcid', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-6"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{summary}\n{pager}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'pager' => [
                            'options' => ['class' => 'pagination'],
                            'prevPageLabel' => 'Previous',
                            'nextPageLabel' => 'Next',
                            'firstPageLabel' => 'First',
                            'lastPageLabel' => 'Last',
                            'nextPageCssClass' => 'paginate_button page-item',
                            'prevPageCssClass' => 'paginate_button page-item',
                            'firstPageCssClass' => 'paginate_button page-item',
                            'lastPageCssClass' => 'paginate_button page-item',
                            'maxButtonCount' => 10,
                        ],
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'Txn. count',
                            ],
                            [
                                'attribute' => 'banktransactionid',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->banktransactionid;
                                }
                            ],
                            [
                                'attribute' => 'bankidbc',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bankidbc;
                                }
                            ],
                            [
                                'attribute' => 'bc_application_id',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->bc) ? $model->bc->name : '';
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
                                'attribute' => 'transaction_datetime',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->transaction_datetime;
                                }
                            ],
                            [
                                'attribute' => 'transaction_amount',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->transaction_amount;
                                }
                            ],
                            [
                                'attribute' => 'transaction_type',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->transaction_type;
                                }
                            ],
                            [
                                'attribute' => 'commission_amount',
                                'enableSorting' => false,
                                'contentOptions' => ['class' => 'text-right'],
                                'value' => function ($model) {
                                    return isset($model->commission_amount) ? common\helpers\Utility::numberIndiaStyle($model->commission_amount,2) : '';
                                }
                            ],
                        //'file_id',
                        //'fileupload_datetime',
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
