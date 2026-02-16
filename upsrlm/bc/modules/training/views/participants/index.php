<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = "Progress MIS";
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
                    <?php
                    $form = ActiveForm::begin([
                                'layout' => 'inline',
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'Searchform'
                                ],
                                'method' => 'get',
                    ]);
                    ?>

                    <?php
                    echo $this->render('_searchmis', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <div class="clearfix pt-3"></div>
                    <div class="col-xs-12 pt-3">
                        <div class="row">
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-info-100">
                                        1. Total GPs <br/>&nbsp;
                                    </div>

                                    <div class="card-body">

                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvidergp->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?php Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '1']) ?>   
                                            </div>

                                        </div>
                                    </div>  
                                </div>

                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-info-100">
                                        2. Total BCs shortlisted from GPS (Before PR election 2021)
                                    </div>

                                    <div class="card-body">

                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider1b->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?php Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '2']) ?>   
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-info-100">
                                        2a. Total BCs shortlisted from GPS (After PR election 2021)
                                    </div>

                                    <div class="card-body">

                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider1c->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?php Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '2']) ?>   
                                            </div>
                                        </div>     

                                    </div>
                                </div>
                            </div>
                            <?php //if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) { ?>
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-info-100">
                                        2b.First stand-by candidates approved against unqualified BCs
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider1d->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?php echo Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '1d']) ?>   
                                            </div>
                                        </div>     

                                    </div>
                                </div>
                            </div>
                            <?php //} ?>
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-info-100">
                                        3. BCs registered by RSETI for training
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider1->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?= Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '1']) ?>   
                                            </div>
                                        </div>     
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-info-100">
                                        4. Total BCs appeared for IIBF exam
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider2->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?= Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '2']) ?>   
                                            </div>
                                        </div>     
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-success-100">
                                        5. Total BCs certified by IIBF
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider3->query->count());
//echo ($dataProvider2->getTotalCount());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?= Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-success', 'style' => '', 'name' => 'button_type', 'value' => '3']) ?>   
                                            </div>
                                        </div>     

                                    </div>

                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-danger-300">
                                        6. List of unqualified BCs as on Sept. 2, 2021
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider4->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?= Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-danger', 'style' => '', 'name' => 'button_type', 'value' => '4']) ?>   
                                            </div>
                                        </div>     
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-danger-300">
                                        7.2 Ineligible
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider5->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?= Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-danger', 'style' => '', 'name' => 'button_type', 'value' => '5']) ?>   
                                            </div>
                                        </div>     
                                    </div>
                                </div>
                            </div>



                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-danger-300">
                                        7.3 Absent in IIBF exam
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider6->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?= Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-danger', 'style' => '', 'name' => 'button_type', 'value' => '6']) ?>   
                                            </div>
                                        </div>     
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-danger-300">
                                        7.4 Unwilling
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider7->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?= Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-danger', 'style' => '', 'name' => 'button_type', 'value' => '7']) ?>   
                                            </div>
                                        </div>     
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-danger-300">
                                        7.5 Certified Unwilling
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider8->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?= Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-danger', 'style' => '', 'name' => 'button_type', 'value' => '8']) ?>   
                                            </div>
                                        </div>     
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-danger-300">
                                        7.6 Certified Mismatch GP
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider9->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?= Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-danger', 'style' => '', 'name' => 'button_type', 'value' => '9']) ?>   
                                            </div>
                                        </div>     
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 pt-3">
                        <div class="card ">    
                            <div class="card-header <?= \Yii::$app->params['class'] ?>"><i class="fal fa-user"> </i> <?= \Yii::$app->params['title'] ?></div>
                        </div>
                        <div class="card-body">
                            <?php
                            if ($button_type == "1") {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'name',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                                $html = '';
                                                if (isset($arr[$model->participant->blocked])) {
                                                    $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                                }

                                                return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'member',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return isset($model->participant->agm) ? $model->participant->agm->name_eng : '';
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
                                            'attribute' => 'exam_appeared',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->exam_score != null ? 'Yes' : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'exam_score',
                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'header' => 'Certified by IIBF ',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->exam_score >= 40 ? 'Yes' : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'certificate_code',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->certificate_code != null ? $model->certificate_code : '';
                                            }
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Download PVR Form',
                                            'visible' => isset(Yii::$app->user->identity->role) and $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DC_NRLM]),
                                            'template' => '{download}',
                                            'buttons' => [
                                                'download' => function ($url, $model) {
                                                    return (($model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) and $model->participant->isallphoto == 1 and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0') ? Html::a('<i class="fal fa-download"></i> PVR', ['/training/participants/pdf/?id=' . $model->bc_application_id], [
                                                        'data-pjax' => "0",
                                                        'class' => 'btn  btn-info',
                                                    ]) : '';
                                                },
                                            ]
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Upload PVR',
                                            'visible' => isset(Yii::$app->user->identity->role) and $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DC_NRLM]),
                                            'template' => '{uploadpvr}',
                                            'buttons' => [
                                                'uploadpvr' => function ($url, $model) {
                                                    $html = '';
                                                    if ($model->participant->blocked == '0') {
                                                        if ((($model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) and $model->pvr_status == 0 and $model->participant->isallphoto == 1 and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0')) {
                                                            $html .= yii\helpers\Html::button('<i class="fal fa-upload"></i> Upload PVR', ['id' => 'call' . $model->id, 'class' => 'btn  btn-info popb mb-2', 'value' => '/training/participants/uploadpvr?participantid=' . $model->id, 'name' => 'uploadpvr', 'title' => 'Upload PVR: ']);
                                                        }
                                                        if (($model->pvr_status == 1)) {
                                                            $html .= yii\helpers\Html::button('<i class="fal fa-yes"></i> Uploaded', ['id' => 'call' . $model->id, 'class' => 'btn  btn-success mb-2', 'name' => 'uploadpvr', 'title' => 'Uploaded: ']);
                                                        }
                                                        if (($model->pvr_status == 1 and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) {
                                                            $html .= Html::a('<i class="fal fa fa-times"></i> Delete PVR Upload', ['/training/participants/delpvr', 'participantid' => $model->id], [
                                                                        'title' => 'Delete PVR Upload ',
                                                                        'data-pjax' => "0",
                                                                        'class' => 'btn  btn-danger ',
                                                                        'data-confirm' => 'Are you sure to Delete PVR Upload? This action can not be undone.',
                                                                        'data-method' => 'POST',
                                                            ]);
                                                        }
                                                    }
                                                    return $html;
                                                },
                                            ],
                                        ],
                                    ],
                                ]);
                            } elseif ($button_type == "2") {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'name',
//                        'contentOptions' => ['style' => 'width: 18%'],
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                                $html = '';
                                                if (isset($arr[$model->participant->blocked])) {
                                                    $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                                }
                                                // $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> View Data', ['id' => 'call' . $model->id, 'class' => 'btn  btn-warning btn-block popb', 'value' => '/selection/data/application/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                                                return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'member',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return isset($model->participant->agm) ? $model->participant->agm->name_eng : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'training_status',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->trainingstatus;
                                            }
                                        ],
                                        [
                                            'attribute' => 'exam_appeared',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->exam_score != null ? 'Yes' : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'exam_score',
                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'header' => 'Certified by IIBF ',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->exam_score >= 40 ? 'Yes' : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'certificate_code',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->certificate_code != null ? $model->certificate_code : '';
                                            }
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Download PVR Form',
                                            'visible' => isset(Yii::$app->user->identity->role) and $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DC_NRLM]),
                                            'template' => '{download}',
                                            'buttons' => [
                                                'download' => function ($url, $model) {
                                                    return (($model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) and $model->participant->isallphoto == 1 and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0') ? Html::a('<i class="fal fa-download"></i> PVR', ['/training/participants/pdf/?id=' . $model->bc_application_id], [
                                                        'data-pjax' => "0",
                                                        'class' => 'btn  btn-info',
                                                    ]) : '';
                                                },
                                            ]
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Upload PVR',
                                            'visible' => isset(Yii::$app->user->identity->role) and $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DC_NRLM]),
                                            'template' => '{uploadpvr}',
                                            'buttons' => [
                                                'uploadpvr' => function ($url, $model) {
                                                    $html = '';
                                                    if ($model->participant->blocked == '0') {
                                                        if ((($model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) and $model->pvr_status == 0 and $model->participant->isallphoto == 1 and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0')) {
                                                            $html .= yii\helpers\Html::button('<i class="fal fa-upload"></i> Upload PVR', ['id' => 'call' . $model->id, 'class' => 'btn  btn-info popb', 'value' => '/training/participants/uploadpvr?participantid=' . $model->id, 'name' => 'uploadpvr', 'title' => 'Upload PVR: ']);
                                                        }
                                                        if (($model->pvr_status == 1)) {
                                                            $html .= yii\helpers\Html::button('<i class="fal fa-yes"></i> Uploaded', ['id' => 'call' . $model->id, 'class' => 'btn  btn-success', 'name' => 'uploadpvr', 'title' => 'Uploaded: ']);
                                                        }
                                                        if (($model->pvr_status == 1 and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) {
                                                            $html .= Html::a('<i class="fal fa fa-times"> </i>Delete PVR Upload', ['/training/participants/delpvr', 'participantid' => $model->id], [
                                                                        'title' => 'Delete PVR Upload',
                                                                        'data-pjax' => "0",
                                                                        'class' => 'btn  btn-danger ',
                                                                        'data-confirm' => 'Are you sure to Delete PVR Upload? This action can not be undone.',
                                                                        'data-method' => 'POST',
                                                            ]);
                                                        }
                                                    }
                                                    return $html;
                                                },
                                            ],
                                        ],
                                    ],
                                ]);
                            } elseif ($button_type == "3" or ($searchModel->custum_training_status == SrlmBcApplication::TRAINING_STATUS_PASS or $searchModel->custum_training_status == '31')) {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'name',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                                $html = '';
                                                if (isset($arr[$model->participant->blocked])) {
                                                    $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                                }

                                                return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'member',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return isset($model->participant->agm) ? $model->participant->agm->name_eng : '';
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
                                            'attribute' => 'exam_appeared',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->exam_score != null ? 'Yes' : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'exam_score',
                                            'header' => 'Certified by IIBF ',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->exam_score >= 40 ? 'Yes' : '';
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
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Download PVR Form',
                                            'visible' => isset(Yii::$app->user->identity->role) and $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DC_NRLM]),
                                            'template' => '{download}',
                                            'buttons' => [
                                                'download' => function ($url, $model) {
                                                    return (($model->participant->blocked == '0' and $model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) and $model->participant->isallphoto == 1 and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0') ? Html::a('<i class="fal fa-download"> </i> PVR', ['/training/participants/pdf/?id=' . $model->bc_application_id], [
                                                        'data-pjax' => "0",
                                                        'class' => 'btn  btn-info',
                                                    ]) : '';
                                                },
                                            ]
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Upload PVR',
                                            'visible' => isset(Yii::$app->user->identity->role) and $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DC_NRLM]),
                                            'template' => '{uploadpvr}',
                                            'buttons' => [
                                                'uploadpvr' => function ($url, $model) {
                                                    $html = '';
                                                    if ($model->participant->blocked == '0') {
                                                        if ((($model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) and $model->pvr_status == 0 and $model->participant->isallphoto == 1 and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0')) {
                                                            $html .= yii\helpers\Html::button('<i class="fal fa-upload"></i> Upload PVR', ['id' => 'call' . $model->id, 'class' => 'btn  btn-info popb', 'value' => '/training/participants/uploadpvr?participantid=' . $model->id, 'name' => 'uploadpvr', 'title' => 'Upload PVR: ']);
                                                        }
                                                        if (($model->pvr_status == 1)) {
                                                            $html .= yii\helpers\Html::button('<i class="fal fa-yes"></i> Uploaded', ['id' => 'call' . $model->id, 'class' => 'btn  btn-success', 'name' => 'uploadpvr', 'title' => 'Uploaded: ']);
                                                        }
                                                        if (($model->pvr_status == 1 and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) {
                                                            $html .= Html::a('<i class="fal fa fa-times"></i> Delete PVR Upload', ['/training/participants/delpvr', 'participantid' => $model->id], [
                                                                        'title' => 'Delete PVR Upload',
                                                                        'data-pjax' => "0",
                                                                        'class' => 'btn  btn-danger ',
                                                                        'data-confirm' => 'Are you sure to Delete PVR Upload? This action can not be undone.',
                                                                        'data-method' => 'POST',
                                                            ]);
                                                        }
                                                    }
                                                    return $html;
                                                },
                                            ],
                                        ],
                                    ],
                                ]);
                            } elseif ($button_type == "4" or $searchModel->custum_training_status == SrlmBcApplication::TRAINING_STATUS_FAIL) {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'name',
//                        'contentOptions' => ['style' => 'width: 18%'],
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                                $html = '';
                                                if (isset($arr[$model->participant->blocked])) {
                                                    $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                                }
                                                // $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> View Data', ['id' => 'call' . $model->id, 'class' => 'btn  btn-warning btn-block popb', 'value' => '/selection/data/application/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                                                return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'member',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return isset($model->participant->agm) ? $model->participant->agm->name_eng : '';
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
                                            'attribute' => 'exam_appeared',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->exam_score != null ? 'Yes' : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'exam_score',
                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'header' => 'Certified by IIBF ',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->exam_score >= 40 ? 'Yes' : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'certificate_code',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->certificate_code != null ? $model->certificate_code : '';
                                            }
                                        ],
                                    ],
                                ]);
                            } elseif ($button_type == "5" or $searchModel->custum_training_status == SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE) {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'name',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                                $html = '';
                                                if (isset($arr[$model->participant->blocked])) {
                                                    $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                                }

                                                return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'member',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return isset($model->participant->agm) ? $model->participant->agm->name_eng : '';
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
                                            'attribute' => 'ineligible_reason',
                                            'format' => 'raw',
                                            'value' => function ($model) {

                                                return $model->participant->ineligible;
                                            }
                                        ],
                                    ],
                                ]);
                            } elseif ($button_type == "6" or $searchModel->custum_training_status == SrlmBcApplication::TRAINING_STATUS_ABSENT) {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'name',
//                        'contentOptions' => ['style' => 'width: 18%'],
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                                $html = '';
                                                if (isset($arr[$model->participant->blocked])) {
                                                    $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                                }

                                                return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'member',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return isset($model->participant->agm) ? $model->participant->agm->name_eng : '';
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
                                            'header' => 'Revert',
                                            'visible' => 0, //isset(Yii::$app->user->identity->role) and $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                            'template' => '{revert}',
                                            'buttons' => [
                                                'revert' => function ($url, $model) {
                                                    $html = '';
                                                    if ($model->participant->blocked == '0') {
                                                        if (($model->training_status == SrlmBcApplication::TRAINING_STATUS_ABSENT and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) {
                                                            $html .= Html::a('<span class="fal fa fa-remove">Revert</span>', ['/training/participants/remove', 'participantid' => $model->id], [
                                                                        'title' => 'revert',
                                                                        'data-pjax' => "0",
                                                                        'class' => 'btn  btn-danger ',
                                                                        'data-confirm' => 'Are you absolutely sure remove this partcipant to training.',
                                                                        'data-method' => 'POST',
                                                            ]);
                                                        }
                                                    }
                                                    return $html;
                                                },
                                            ],
                                        ],
                                    ],
                                ]);
                            } elseif ($button_type == "7") {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'name',
//                        'contentOptions' => ['style' => 'width: 18%'],
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                                $html = '';
                                                if (isset($arr[$model->participant->blocked])) {
                                                    $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                                }

                                                return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'member',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return isset($model->participant->agm) ? $model->participant->agm->name_eng : '';
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
                                            'attribute' => 'unwlling_reason_rsetis',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                if ($model->training_status == -2)
                                                    return $model->participant->rsethiunwilling;
                                                if ($model->training_status == 32)
                                                    return $model->participant->bankunwilling;
                                            }
                                        ],
                                        [
                                            'attribute' => 'unwlling_reason_call_center',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                             if ($model->training_status == -2)
                                                    return $model->participant->callcenterunwilling;
                                                if ($model->training_status == 32)
                                                    return $model->participant->callcenterbankunwilling;
                                                //return $model->participant->callcenterunwilling;
                                            }
                                        ],
     ],
                                ]);
                            }elseif ($button_type == "8") {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'name',
//                        'contentOptions' => ['style' => 'width: 18%'],
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                                $html = '';
                                                if (isset($arr[$model->participant->blocked])) {
                                                    $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                                }

                                                return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'member',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return isset($model->participant->agm) ? $model->participant->agm->name_eng : '';
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
                                            'attribute' => 'unwlling_reason_partner_bank',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                if ($model->training_status == -2)
                                                    return $model->participant->rsethiunwilling;
                                                if ($model->training_status == 32)
                                                    return $model->participant->bankunwilling;
                                            }
                                        ],
                                        [
                                            'attribute' => 'unwlling_reason_call_center',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                             if ($model->training_status == -2)
                                                    return $model->participant->callcenterunwilling;
                                                if ($model->training_status == 32)
                                                    return $model->participant->callcenterbankunwilling;
                                                //return $model->participant->callcenterunwilling;
                                            }
                                        ],

                                    ],
                                ]);
                            }elseif ($button_type == "9") {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'name',
//                        'contentOptions' => ['style' => 'width: 18%'],
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                                $html = '';
                                                if (isset($arr[$model->participant->blocked])) {
                                                    $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                                }

                                                return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
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
                                            'attribute' => 'exam_appeared',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->exam_score != null ? 'Yes' : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'exam_score',
                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'header' => 'Certified by IIBF ',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->exam_score >= 40 ? 'Yes' : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'certificate_code',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->certificate_code != null ? $model->certificate_code : '';
                                            }
                                        ],
                                    ],
                                ]);
                            } elseif ($button_type == "1d") {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'name',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'header' => ' Stand-by 1 Name',
                                            'headerOptions' => ['style' => 'color:blue'],
                                            'contentOptions' => ['style' => 'color:blue'],
                                            'value' => function ($model) {
                                                return $model->name;
                                                ;
                                            }
                                        ],
                                        [
                                            'attribute' => 'guardian_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->guardian_name != null ? $model->guardian_name : '';
                                            },
                                        ],
                                        [
                                            'attribute' => 'mobile_number',
                                            'enableSorting' => false,
                                            'format' => 'html',
                                            'value' => function ($model) {
                                                return common\helpers\Utility::mask($model->mobile_number) . '<br/>' . common\helpers\Utility::mask($model->mobile_no);
                                            },
                                        ],
                                        [
                                            'attribute' => 'age',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {

                                                return $model->age != null ? $model->age : '';
                                            },
                                        ],
                                        [
                                            'attribute' => 'Social Category',
                                            'enableSorting' => false,
                                            'format' => 'html',
                                            'value' => function ($model) {
                                                return $model->castrel != null ? $model->castrel->name_eng : '';
                                            },
                                        ],
                                        [
                                            'attribute' => 'reading_skills',
                                            'enableSorting' => false,
                                            'label' => 'Education',
                                            'format' => 'html',
                                            'value' => function ($model) {

                                                return $model->readingskills != null ? $model->readingskills->name_eng : '';
                                            },
                                        ],
                                        [
                                            'attribute' => 'address',
                                            'enableSorting' => false,
                                            'format' => 'html',
                                            'value' => function ($model) {
                                                return $model->fulladdress;
                                            },
                                        ],
//                        [
//                            'attribute' => 'Form submit On',
//                            'enableSorting' => false,
//                            'value' => function ($model) {
//                                return $model->form6_date_time != null ? $model->form6_date_time : '';
//                            },
//                        ],
//                        [
//                            'attribute' => 'OTP Verified mobile no',
//                            'enableSorting' => false,
//                            'format' => 'html',
//                            'value' => function ($model) {
//                                return $model->user != null ? $model->user->mobile_no : '';
//                            },
//                        ],
                                        [
                                            'attribute' => 'name',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'header' => 'Vacant Candidate Name',
                                            'headerOptions' => ['style' => 'color:red'],
                                            'contentOptions' => ['style' => 'color:red'],
                                            'value' => function ($model) {
                                                $p_model = \bc\modules\training\models\RsetisBatchParticipants::findOne(['bc_application_id' => $model->bc1->id]);
                                                return isset($model->bc1) ? Html::a($model->bc1->name, '#', ['value' => '/training/participants/view?participantid=' . $p_model->id, 'data-pjax' => "0", 'title' => $p_model->participant->name, 'class' => 'popb', 'style' => 'color:red']) : '';
                                            },
                                        ],
                                        [
                                            'attribute' => 'Vacant Reason',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'header' => 'Vacant Reason',
                                            'value' => function ($model) {
                                                $arr = ['4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent', '-2' => 'Unwilling', '3' => 'Certified Unwilling'];
                                                return isset($arr[$model->bc1->training_status]) ? $arr[$model->bc1->training_status] : '';
                                            },
                                        ],
//                        [
//                            'attribute' => 'Aadhar photo',
//                            'format' => 'raw',
//                            'contentOptions' => ['style' => 'width: 26%'],
//                            'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK]),
//                            'value' => function ($model) {
//                                $status = '';
//                                $html = '<span id="' . $model->id . '">';
//                                $html .= $model->user->aadhar_front_photo != null ? '<span class="profile-picture">
//                                        <img width="150px" height="150px" src="' . $model->aadhar_front_photo_url . '" data-src="' . $model->aadhar_front_photo_url . '"  class="lozad" title="aadhar_front_photo" style="cursor : pointer"/>
//                                        </span> ' : '';
//                                $html .= $model->user->aadhar_back_photo != null ? '<span class="profile-picture">
//                                        <img width="150px" height="150px" src="' . $model->aadhar_back_photo_url . '" data-src="' . $model->aadhar_back_photo_url . '"  class="lozad" title="aadhar_back_photo" style="cursor : pointer"/>
//                                        </span> ' : '';
//
//                                $html .= '</span>';
//                                return $html;
//                            }
//                        ],
                                    ],
                                ]);
                            } else {

                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'name',
//                        'contentOptions' => ['style' => 'width: 18%'],
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                                $html = '';
                                                if (isset($arr[$model->participant->blocked])) {
                                                    $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                                }

                                                return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'member',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return isset($model->participant->agm) ? $model->participant->agm->name_eng : '';
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
                                            'attribute' => 'exam_appeared',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->exam_score != null ? 'Yes' : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'exam_score',
                                            'contentOptions' => ['style' => 'width: 10%'],
                                            'header' => 'Certified by IIBF ',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->exam_score >= 40 ? 'Yes' : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'certificate_code',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {
                                                return $model->certificate_code != null ? $model->certificate_code : '';
                                            }
                                        ],
                                        [
                                            'attribute' => 'ineligible_reason',
                                            'format' => 'raw',
                                            'visible' => $searchModel->custum_training_status == SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                                            'value' => function ($model) {

                                                return $model->participant->ineligible;
                                            }
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Download PVR Form',
                                            'visible' => isset(Yii::$app->user->identity->role) and $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DC_NRLM]),
                                            'template' => '{download}',
                                            'buttons' => [
                                                'download' => function ($url, $model) {
                                                    return (($model->participant->blocked == '0' and $model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) and $model->participant->isallphoto == 1 and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0') ? Html::a('<span class="fal fa-download"> PVR</span>', ['/training/participants/pdf/?id=' . $model->bc_application_id], [
                                                        'data-pjax' => "0",
                                                        'class' => 'btn  btn-info',
                                                    ]) : '';
                                                },
                                            ]
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Upload PVR',
                                            'visible' => isset(Yii::$app->user->identity->role) and $searchModel->custum_training_status != SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DC_NRLM]),
                                            'template' => '{uploadpvr}',
                                            'buttons' => [
                                                'uploadpvr' => function ($url, $model) {
                                                    $html = '';
                                                    if ((($model->participant->blocked == '0' and $model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) and $model->pvr_status == 0 and $model->participant->isallphoto == 1 and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0')) {
                                                        $html .= yii\helpers\Html::button('<i class="fal fa-upload"></i> Upload PVR', ['id' => 'call' . $model->id, 'class' => 'btn  btn-info popb mb-2', 'value' => '/training/participants/uploadpvr?participantid=' . $model->id, 'name' => 'uploadpvr', 'title' => 'Upload PVR: ']);
                                                    }
                                                    if (($model->pvr_status == 1)) {
                                                        $html .= yii\helpers\Html::button('<i class="fal fa-yes"></i> Uploaded', ['id' => 'call' . $model->id, 'class' => 'btn  btn-success mb-2', 'name' => 'uploadpvr', 'title' => 'Uploaded: ']);
                                                    }
                                                    if (($model->participant->blocked == '0' and $model->pvr_status == 1 and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]))) {
                                                        $html .= Html::a('<span class="fal fa fa-times">Delete PVR Upload</span>', ['/training/participants/delpvr', 'participantid' => $model->id], [
                                                                    'title' => 'Delete PVR Upload',
                                                                    'data-pjax' => "0",
                                                                    'class' => 'btn  btn-danger mb-2',
                                                                    'data-confirm' => 'Are you sure to Delete PVR Upload? This action can not be undone.',
                                                                    'data-method' => 'POST',
                                                        ]);
                                                    }

                                                    return $html;
                                                },
                                            ],
                                        ],
                                    ],
                                ]);
                            }
                            ?>
                        </div> 
                    </div>   
                    <?php ActiveForm::end(); ?>
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $("#search-form").attr({ "action":"/training/participants"});
    $("#search-form").attr("data-pjax", "True");                
    $(this).closest('form').submit();
});            
    
JS;
                    $this->registerJs($script);
                    ?>
                    <?php
//            $js = <<< JS
//$(document).on('ready pjax:success', function() {
//        function updateURLParameter(url, param, paramVal)
//        {
//        var TheAnchor = null;
//        var newAdditionalURL = "";
//        var tempArray = url.split("?");
//        var baseURL = tempArray[0];
//        var additionalURL = tempArray[1];
//        var temp ="";                       
//                                                              
//        if (additionalURL)                                    
//        {                                                     
//            var tmpAnchor = additionalURL.split("#");         
//            var TheParams = tmpAnchor[0];                     
//            TheAnchor = tmpAnchor[1];                         
//            if(TheAnchor)                                     
//                additionalURL = TheParams;                    
//                                                              
//            tempArray = additionalURL.split("&");             
//                                                              
//            for (var i=0; i<tempArray.length; i++)            
//            {                                                 
//                if(tempArray[i].split('=')[0] != param)       
//                {                                             
//                    newAdditionalURL += temp + tempArray[i];  
//                    temp = "&";                               
//                }                                             
//            }                                                 
//        }                                                     
//        else                                                  
//        {                                                     
//            var tmpAnchor = baseURL.split("#");               
//            var TheParams = tmpAnchor[0];                     
//            TheAnchor  = tmpAnchor[1];                        
//                                                              
//            if(TheParams)
//                baseURL = TheParams;     
//        }                                                                      
//                                                                               
//        if(TheAnchor)                                                          
//            paramVal += "#" + TheAnchor;                                       
//                                                                               
//        var rows_txt = temp + "" + param + "=" + paramVal;                     
//        return baseURL + "?" + newAdditionalURL + rows_txt;                    
//    }
//
//    $('.pagination li a').click(function(event){
//            event.preventDefault(); 
//            var page = $(this).data('page') + 1;
//            var href = updateURLParameter(this.href, 'page', page); 
//            $('#search-form').prop('action', href);
//            $('#search-form').submit();
//        });  
//});
//JS;
//            $this->registerJs($js)
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
                    $js = <<<JS
$(function () {
   $('.popnelig').click(function(){
        $('#fcontent').html('');
        $('#modal1').modal('show')
         .find('#fcontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader1').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
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
//    'options' => ['data-backdrop' => 'true',],
                        'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
                        ],
                    ]);
                    echo "<div id='imagecontent'></div>";
                    Modal::end();
                    ?>
                    <?php
                    Modal::begin([
                        'headerOptions' => ['id' => 'modalHeader1'],
                        'id' => 'modal1',
                        'size' => 'modal-xl',
//    'options' => ['data-backdrop' => 'true',],
                        'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
                        ],
                    ]);
                    echo "<div id='fcontent'></div>";
                    Modal::end();
                    ?>  
                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div> 
    </div>
</div>
<?php
$this->registerJs(
        '
function init_click_handlers(){

  $(".popb").click(function(e) {
            var fID = $(this).closest("tr").data("key");
            $("#modal").modal("show")
         .find("#imagecontent")
         .load($(this).attr("value"));
        });
       

}

init_click_handlers(); //first run
$("#grid-data").on("pjax:success", function() {
  init_click_handlers(); //reactivate links in grid after pjax update
});

');
?>
