<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
//use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CboMemberProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Members';
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
                    <div class="clearfix pt-3"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-responsive table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'name',
                                'label' => 'Name',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->user != NULL ? $model->user->name : '';
                                }
                            ],
                            [
                                'attribute' => 'mobile_no',
                                'label' => 'Mobile No.',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->user != NULL ? $model->user->username : '';
                                }
                            ],
                            [
                                'attribute' => 'district',
                                'label' => 'District',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->district_name) ? $model->district_name : '';
                                }
                            ],
                            [
                                'attribute' => 'block',
                                'label' => 'Block',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->block_name) ? $model->block_name : '';
                                }
                            ],
                            [
                                'attribute' => 'gp',
                                'label' => 'Gram Panchayat',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->gram_panchayat_name) ? $model->gram_panchayat_name : '';
                                }
                            ],        
//                            [
//                                'attribute' => 'address',
//                                'label' => 'Address',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->address;
//                                }
//                            ],
                            [
                                'attribute' => 'rishta_app_last_access_time',
                                'label' => 'Rishta Last Used Time',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->rishta_app_last_access_time != NULL ? $model->rishta_app_last_access_time : '';
                                }
                            ],
                            [
                                'attribute' => 'bc_no_of_transaction',
                                'label' => 'No. of transaction',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bc_no_of_transaction;
                                }
                            ],
                            [
                                'attribute' => 'rishta_access_page_count',
                                'header' => 'Rishta Access Page ',
                                'enableSorting' => false,
                                'format' => 'html',
                                'value' => function ($model) {
                                    return $model->rishta_access_page_count;
                                },
                            ],
                            [
                                'attribute' => 'ctc_call_count',
                                'header' => 'CTC Call ',
                                'enableSorting' => false,
                                'format' => 'html',
                                'value' => function ($model) {
                                    return $model->ctc_call_count;
                                },
                            ],
                            [
                                'attribute' => 'ibd_call_count',
                                'header' => 'Ibd Call',
                                'enableSorting' => false,
                                'format' => 'html',
                                'value' => function ($model) {
                                    return $model->ibd_call_count;
                                },
                            ],
                        //'bc',
                        //'samuh_sakhi',
                        //'wada_sakhi',
                        //'accountant',
                        //'shg',
                        //'vo',
                        //'clf',
                        //'age',
                        //'cast',
                        //'rishta_app_last_access_time',
                        //'bc_no_of_transaction',
                        //'bc_transaction_amount',
                        //'ctc_call_count',
                        //'ibd_call_count',
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

