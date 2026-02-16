<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
use yii\bootstrap4\Modal;
use bc\modules\selection\models\SrlmBcApplication;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'Training participant' ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <div class="clearfix"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'floatHeader' => true,
                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                            [
                                'attribute' => 'name',
//           
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $html = '';
                                    if ($model->participant->urban_shg == '1') {
                                        $html .= '<div class="text-danger">GP Convert Urban</div>';
                                    }
                                    return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'title' => $model->name, 'data-pjax' => "0", 'class' => 'popb']) . $html;
                                }
                            ],
                            [
                                //    'attribute' => 'phone_no',
                                'label' => "Mobile Number",
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return common\helpers\Utility::mask($model->participant->user->mobile_no) . "<br/>" . common\helpers\Utility::mask($model->participant->mobile_number);
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'format' => 'html',
                                'header' => 'District/ Block',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district_name . '<br/>' . $model->block_name;
                                }
                            ],
//                            [
//                                'attribute' => 'block_name',
//                                'format' => 'html',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->block_name;
//                                }
//                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->gram_panchayat_name;
                                }
                            ],
//                            [
//                                'attribute' => 'mobile_number',
//                                'format' => 'html',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->mobile_number.'<br/>'.$model->otp_mobile_no;
//                                }
//                            ],
                            [
                                'attribute' => 'batch',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->batch->batch_name;
                                }
                            ],
                            [
                                'attribute' => 'schedule_date_of_exam',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->training) ? \Yii::$app->formatter->asDatetime($model->training->schedule_date_of_exam, "php:d-m-Y") : "";
                                }
                            ],
                            [
                                'attribute' => 'exam_score',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->exam_score != null ? $model->exam_score : '';
                                }
                            ],
                            [
                                'attribute' => 'certificate_code',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->certificate_code != null ? $model->certificate_code : '';
                                }
                            ],
                            [
                                'attribute' => 'training_status',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->trainingstatus;
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT]),
                                'template' => '{addscore}{uploadiibf}{changebatch}{delete}',
                                'buttons' => [
                                    'addscore' => function ($url, $model) {
                                        return ($model->participant->urban_shg == '0' and $model->participant->blocked == '0' and $model->training->status == 1 and in_array($model->participant->training_status, [2,4,6])) ? yii\helpers\Html::button('<i class="fal fa-plus"></i> Add Score/Update Status', ['id' => 'add-score-' . $model->id, 'class' => 'btn  btn-info popb', 'value' => '/training/participants/addscore?participantid=' . $model->id, 'name' => 'takeaction', 'title' => 'Add Score/Update Status of ' . $model->name]) . ' ' : '';
                                    },
                                    'uploadiibf' => function ($url, $model) {
                                        return ($model->participant->urban_shg == '0' and $model->participant->blocked == '0' and $model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) ? yii\helpers\Html::button('<i class="fal fa-upload"></i>Upload IIBF Certificate photo', ['id' => 'upload-iibf-certificate-photo-' . $model->id, 'class' => 'btn  btn-info popb', 'value' => '/training/participants/uploadiibf?participantid=' . $model->id, 'name' => 'takeaction', 'title' => 'Upload IIBF Certificate photo of ' . $model->name]) . ' ' : '';
                                    },
                                    'delete' => function ($url, $model) {
                                        return ($model->training->status == 1 and in_array($model->training_status, [2])) ? Html::a('<span class="fal fa-times"></span>', ['/training/participants/remove/?participantid=' . $model->id], [
                                            'data-pjax' => "0",
                                            'class' => 'btn  btn-danger',
                                            'data' => [
                                                'confirm' => 'Are you absolutely sure remove this partcipant to this training ?',
                                                'method' => 'post',
                                            ],
                                        ]) : '';
                                    },
                                    'changebatch' => function ($url, $model) {
                                        return ($model->training->status == 1 and $model->participant->urban_shg == '0' and $model->participant->blocked == '0' and in_array($model->training_status, [2]) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) ? ' ' . yii\helpers\Html::button('<i class="fal fa-refresh"></i> Change Batch', ['id' => 'change-batch-' . $model->id, 'class' => 'btn  btn-info popb', 'value' => '/training/participants/changebatch?participantid=' . $model->id, 'name' => 'takeaction', 'title' => 'Change Batch of ' . $model->name]) . ' ' : '';
                                    },
                                    
                                ]
                            ],
                        ],
                    ]);
                    ?>

                    <?php
                    $js = <<<JS
$(function () {
         
    $('.popb').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
                           
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
        });
});  
        
JS;
                    $this->registerJs($js);
                    ?> 

                    <?php
                    Modal::begin([
                        'headerOptions' => ['id' => 'modalHeader'],
                        'id' => 'modal',
                        'size' => 'modal-xl',
                        'options' => ['tabindex' => false,],
                        'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
                        ],
                    ]);
                    echo "<div id='imagecontent'></div>";
                    Modal::end();
                    ?>      

                </div>
            </div>
        </div>    
    </div>
</div>    