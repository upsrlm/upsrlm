<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use cbo\models\CboClf;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Dashboard CLF";
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

                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
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
                    <div class="clearfix"></div>
                    <div class="row mt-3">
                        <div class="col-sm-6 col-xl-2 mb-3">
                            <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-white h-100">
                                <div class="">
                                    <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                        <?php
                                    $amount = $reports[0]->total_funds_amount;
                                    if ($searchModel->type_column) {
                                        $column_name = $searchModel->type_column;
                                        $amount = $reports[0]->$column_name;
                                    }
                                    ?>
                                    <?= \common\helpers\Utility::numberIndiaStyle($amount, 0) ?>
                                        <small class="m-0 l-h-n">1. Funds received from UPSRLM</small>

                                    </h3>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-2 mb-3">
                            <div class="p-3 bg-success-300 rounded overflow-hidden position-relative text-white h-100">
                                <div class="">
                                    <h3 class="display-5 d-block l-h-n m-0 fw-300">
                                       <?= \common\helpers\Utility::numberIndiaStyle($reports[0]['bank_balance'], 0) ?>
                                        <small class="m-0 l-h-n"> 2. Bank Balance</small>

                                    </h3>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-2 mb-3">
                            <div class="p-3 bg-success-500 rounded overflow-hidden position-relative text-white h-100">
                                <div class="">
                                    <h3 class="display-5 d-block l-h-n m-0 fw-300">
                                       <?= '' ?>
                                        <small class="m-0 l-h-n">3. Funds Sent to VO's (Amount)</small>

                                    </h3>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-2 mb-3">
                            <div class="p-3 bg-success-700 rounded overflow-hidden position-relative text-white h-100">
                                <div class="">
                                    <h3 class="display-5 d-block l-h-n m-0 fw-300">
                                       <?= '' ?>
                                        <small class="m-0 l-h-n">4. Funds Sent to VO's (No.) </small>

                                    </h3>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-2 mb-3">
                            <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white h-100">
                                <div class="">
                                    <h3 class="display-5 d-block l-h-n m-0 fw-300">
                                       <?= '' ?>
                                        <small class="m-0 l-h-n">5. Repayments recd. from VO</small>

                                    </h3>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-2 mb-3">
                            <div class="p-3 bg-success-900 rounded overflow-hidden position-relative text-white h-100">
                                <div class="">
                                    <h3 class="display-5 d-block l-h-n m-0 fw-300">
                                       <?= '' ?>
                                        <small class="m-0 l-h-n">6. Variance (CLF Books bank) </small>

                                    </h3>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{items}\n{summary}\n{pager}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'floatHeader' => true,
                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'id',
                                'contentOptions' => ['style' => 'width: 4%'],
                                'enableSorting' => false,
                                'contentOptions' => ['class' => 'info'],
                            ],
                            [
                                'attribute' => 'name_of_clf',
                                'contentOptions' => ['style' => 'width: 20%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'nrlm_clf_code',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'block_name',
                                'label' => 'Block ',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'total_amount_received',
                                'label' => 'Funds received from UPSRLM',
                                'contentOptions' => ['style' => 'width: 20%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) use ($searchModel) {
                                    $amount = $model->total_funds_amount;
                                    if ($searchModel->type_column) {
                                        $column_name = $searchModel->type_column;
                                        $amount = $model->$column_name;
                                    }
                                    return common\helpers\Utility::numberIndiaStyle($amount);
                                }
                            ],
                            [
                                'attribute' => 'total_amount_received',
                                'label' => "Bank Balance",
                                'contentOptions' => ['style' => 'width: 10%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bank_balance != null ? common\helpers\Utility::numberIndiaStyle($model->bank_balance) : '0';
                                }
                            ],
                            [
                                'attribute' => 'created_by',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->entryby) ? $model->entryby->name . " (" . $model->entryby->mobile_no . ")" : '';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM]),
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return ' ' . Html::a('<span class="fal fa-eye"></span>', ['/clf/view?clfid=' . $model->id], [
                                            'class' => '',
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-sm btn-primary',
                                        ]);
                                    },
                                ]
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
                    <?php
                    $js = <<<JS
$(function () {
         
    $('.popb').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';     
        });
});  
        
JS;
                    $this->registerJs($js);
                    ?> 
                    <?php
                    Modal::begin([
                        'headerOptions' => ['id' => 'modalHeader'],
                        'id' => 'modal',
                        'size' => 'modal-lg',
//    'options' => ['data-backdrop' => 'true',],
                        'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
                        ],
                    ]);
                    echo "<div id='imagecontent'></div>";
                    Modal::end();
                    ?>           
                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div>
    </div>
</div>