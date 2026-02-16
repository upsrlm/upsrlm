<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Total APP LINK SMS Send
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">


                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-responsive table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'rowOptions' => function ($model) {

//                            if ($model->verification_status == '1' and $model->verify_mobile_no == '0') {
//                                return ['class' => 'color-warning-400'];
//                            } elseif ($model->verification_status == '1' and $model->verify_mobile_no == '1') {
//                                return ['class' => 'color-success-400'];
//                            } else {
//                                
//                            }
                        },
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'name_of_shg',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg->name_of_shg;
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District/ Block/Gram Panchayat',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->shg->district_name . '/ ' . $model->shg->block_name . '/ ' . $model->shg->gram_panchayat_name;
                                }
                            ],
                            [
                                'attribute' => 'role',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->mrole) ? $model->mrole->role : '';
                                }
                            ],
                            [
                                'attribute' => 'name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->name;
                                }
                            ],
                            [
                                'attribute' => 'mobile_no',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->mobile_no;
                                }
                            ],
                            [
                                'attribute' => 'app_sms_status',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->appsms;
                                }
                            ],
                            [
                                'attribute' => 'ack_time',
                                'format' => 'html',
                                'label' => 'SMS Send Time',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->app_sms_time;
                                }
                            ],
                        ],
                    ]);
                    ?>

                </div>       
            </div>
        </div>
    </div>
</div>
