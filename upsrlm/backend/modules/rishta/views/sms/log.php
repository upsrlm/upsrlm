<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel bc\models\NotificationLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SMS Logs';
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
                    <?php echo $this->render('_searchlog', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-3"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-sm-6 col-xl-6">
                                <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo '<i class="fal fa-sms"></i> ' . common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('sms_count'));
                                            ?>
                                            <small class="m-0 l-h-n">Actual Total SMS</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-sms fa-spin position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'bsVersion' => '4.x',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'mobile_number',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->mobile_number;
                                }
                            ],
                            [
                                'attribute' => 'sms_content',
                                'label' => 'SMS',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->sms_content;
                                },
                            ],
                            [
                                'attribute' => 'sms_send_time',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->sms_send_time != null ? $model->sms_send_time : '';
                                }
                            ],
                            [
                                'attribute' => 'sms_length',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->sms_length;
                                }
                            ],
                            [
                                'attribute' => 'sms_provider_code',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->sms_provider_code;
                                }
                            ],
                            [
                                'attribute' => 'sms_provider_msg',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->sms_provider_msg;
                                }
                            ],
                            [
                                'attribute' => 'sms_provider_msg_text',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->sms_provider_msg_text;
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