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
                    Total CST Member
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
                                'attribute' => 'pin_sms_status',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->pinsms;
                                }
                            ],
                            [
                                'attribute' => 'Action',
                                'format' => 'raw',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN]),
                                'value' => function ($model) {
                                    $html = '';
                                    if ($model->app_sms_status != 3) {
                                        $html .= Html::a('<i class="fal fa-sms" style="color:red"> </i> Send SMS', ['/rishta/sms/sendapplink', 'id' => $model->id], [
                                                    'title' => 'Send App link SMS',
                                                    'data-pjax' => "0",
                                                    'class' => 'btn btn-sm btn-info',
                                                    'data-confirm' => 'Are you sure you want to Send App link SMS?',
                                                    'data-method' => 'POST',
                                                ]) . ' ';
                                    }
                                    return $html;
                                },
                            ],
                        ],
                    ]);
                    ?>

                </div>       
            </div>
        </div>
    </div>
</div>
