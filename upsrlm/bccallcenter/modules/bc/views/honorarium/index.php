<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = "Honorarium payment to BCs";
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
                        'enablePushState' => true,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                    ]);
                    ?>

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
                    echo $this->render('_search', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    //echo $button_type;
                    ?>
                    <div class="col-xl-12 mt-3">
                        <div class="row">
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider1))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider1->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Ist Month Payment</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '1', 'id' => 'searchbtn1']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider2))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider2->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">2nd Month Payment</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '2', 'id' => 'searchbtn2']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa fa-volume-up position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider3))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider3->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">3rd Month Payment</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '3', 'id' => 'searchbtn3']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider4))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider4->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">4rt Month Payment</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '4', 'id' => 'searchbtn4']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider5))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider5->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">5th Month Payment</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '5', 'id' => 'searchbtn5']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider6))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider6->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">6th Month Payment</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '6', 'id' => 'searchbtn6']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider7))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider7->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Ist Month not ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '7', 'id' => 'searchbtn7']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider8))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider8->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">2nd Month not ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '8', 'id' => 'searchbtn8']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider9))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider9->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">3rd Month not ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '9', 'id' => 'searchbtn9']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider10))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider10->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">4th Month not ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '10', 'id' => 'searchbtn10']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider11))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider11->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">5th Month not ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '11', 'id' => 'searchbtn11']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider12))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider12->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">6th Month not ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '12', 'id' => 'searchbtn12']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>


                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-warning-400 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider13))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider13->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Ist Month ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '13', 'id' => 'searchbtn13']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-warning-400 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider14))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider14->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">2nd Month ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '14', 'id' => 'searchbtn14']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-warning-400 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider15))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider15->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">3rd Month ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '15', 'id' => 'searchbtn15']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-warning-400 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider16))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider16->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">4th Month ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '17', 'id' => 'searchbtn16']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-warning-400 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider17))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider17->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">5th Month ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '17', 'id' => 'searchbtn17']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-2 bg-warning-400 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider18))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider18->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">6th Month ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '18', 'id' => 'searchbtn18']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="clearfix pt-3"></div>
                    <div class="col-xl-12">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                            'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                            'id' => 'grid-data',
                            'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                            'beforeHeader' => [
                                [
                                    'columns' => [
                                        ['content' => '', 'options' => ['class' => 'text-center warning']],
                                        ['content' => '', 'options' => ['class' => 'text-center warning']],
                                        ['content' => 'Month 1', 'options' => ['colspan' => 3, 'class' => 'text-center bg-danger-50']],
                                        ['content' => 'Month 2', 'options' => ['colspan' => 3, 'class' => 'text-center bg-warning-50']],
                                        ['content' => 'Month 3', 'options' => ['colspan' => 3, 'class' => 'text-center bg-info-50']],
                                        ['content' => 'Month 4', 'options' => ['colspan' => 3, 'class' => 'text-center bg-primary-50']],
                                        ['content' => 'Month 5', 'options' => ['colspan' => 3, 'class' => 'text-center bg-secondary-50']],
                                        ['content' => 'Month 6', 'options' => ['colspan' => 3, 'class' => 'text-center bg-success-50']],
                                    ],
                                ]
                            ],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                                [
                                    'attribute' => 'name',
                                    'header' => 'BC Name / Mobile No<br/>BC District / BC Block/ BC GP',
                                    'enableSorting' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                        $html = '';
                                        if (isset($arr[$model->bc->blocked])) {
                                            $html .= '<div class="text-danger">' . $arr[$model->bc->blocked] . '</div>';
                                        }
                                        return $model->bc->name . ' / ' . $model->bc->mobile_no . $html . '<br/>' . $model->bc->district_name . ' /' . $model->bc->block_name . ' /' . $model->bc->gram_panchayat_name;
                                    }
                                ],
                                [
                                    'attribute' => 'month1',
                                    'header' => 'Name',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-danger-50'],
                                    'value' => function ($model) {
                                        return isset($model->month1) ? date("F Y", strtotime($model->month1)) : '';
                                    }
                                ],
                                [
                                    'attribute' => 'month1_payment_date',
                                    'header' => 'Date',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-danger-50'],
                                    'value' => function ($model) {
                                        return isset($model->month1_payment_date) ? $model->month1_payment_date : '';
                                    }
                                ],
                                [
                                    'attribute' => 'month1_acknowledge_amount',
                                    'header' => 'Ack.',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-danger-50'],
                                    'value' => function ($model) {
                                        $month1_acknowledge = '';
                                        if (isset($model->month1)) {
                                            if (isset($model->month1_acknowledge_amount)) {
                                                $month1_acknowledge = 'Yes';
                                            } else {
                                                $month1_acknowledge = 'No';
                                            }
                                        }
                                        return $month1_acknowledge;
                                    }
                                ],
                                [
                                    'attribute' => 'month2',
                                    'header' => 'Name',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-warning-50'],
                                    'value' => function ($model) {
                                        return isset($model->month2) ? date("F Y", strtotime($model->month2)) : '';
                                    }
                                ],
                                [
                                    'attribute' => 'month2_payment_date',
                                    'header' => 'Date',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-warning-50'],
                                    'value' => function ($model) {
                                        return isset($model->month2_payment_date) ? $model->month2_payment_date : '';
                                    }
                                ],
                                [
                                    'attribute' => 'month2_acknowledge_amount',
                                    'header' => 'Ack.',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-warning-50'],
                                    'value' => function ($model) {
                                        $month2_acknowledge = '';
                                        if (isset($model->month2)) {
                                            if (isset($model->month2_acknowledge_amount)) {
                                                $month2_acknowledge = 'Yes';
                                            } else {
                                                $month2_acknowledge = 'No';
                                            }
                                        }
                                        return $month2_acknowledge;
                                    }
                                ],
                                [
                                    'attribute' => 'month3',
                                    'header' => 'Name',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-info-50'],
                                    'value' => function ($model) {
                                        return isset($model->month3) ? date("F Y", strtotime($model->month3)) : '';
                                    }
                                ],
                                [
                                    'attribute' => 'month3_payment_date',
                                    'header' => 'Date',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-info-50'],
                                    'value' => function ($model) {
                                        return isset($model->month3_payment_date) ? $model->month3_payment_date : '';
                                    }
                                ],
                                [
                                    'attribute' => 'month3_acknowledge_amount',
                                    'header' => 'Ack.',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-info-50'],
                                    'value' => function ($model) {
                                        $month3_acknowledge = '';
                                        if (isset($model->month3)) {
                                            if (isset($model->month3_acknowledge_amount)) {
                                                $month3_acknowledge = 'Yes';
                                            } else {
                                                $month3_acknowledge = 'No';
                                            }
                                        }
                                        return $month3_acknowledge;
                                    }
                                ],
                                [
                                    'attribute' => 'month4',
                                    'header' => 'Name',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-primary-50'],
                                    'value' => function ($model) {
                                        return isset($model->month4) ? date("F Y", strtotime($model->month4)) : '';
                                    }
                                ],
                                [
                                    'attribute' => 'month4_payment_date',
                                    'header' => 'Date',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-primary-50'],
                                    'value' => function ($model) {
                                        return isset($model->month4_payment_date) ? $model->month4_payment_date : '';
                                    }
                                ],
                                [
                                    'attribute' => 'month4_acknowledge_amount',
                                    'header' => 'Ack.',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-primary-50'],
                                    'value' => function ($model) {
                                        $month4_acknowledge = '';
                                        if (isset($model->month4)) {
                                            if (isset($model->month4_acknowledge_amount)) {
                                                $month4_acknowledge = 'Yes';
                                            } else {
                                                $month4_acknowledge = 'No';
                                            }
                                        }
                                        return $month4_acknowledge;
                                    }
                                ],
                                [
                                    'attribute' => 'month5',
                                    'header' => 'Name',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-secondary-50'],
                                    'value' => function ($model) {
                                        return isset($model->month5) ? date("F Y", strtotime($model->month5)) : '';
                                    }
                                ],
                                [
                                    'attribute' => 'month5_payment_date',
                                    'header' => 'Date',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-secondary-50'],
                                    'value' => function ($model) {
                                        return isset($model->month5_payment_date) ? $model->month5_payment_date : '';
                                    }
                                ],
                                [
                                    'attribute' => 'month5_acknowledge_amount',
                                    'header' => 'Ack.',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-secondary-50'],
                                    'value' => function ($model) {
                                        $month5_acknowledge = '';
                                        if (isset($model->month5)) {
                                            if (isset($model->month5_acknowledge_amount)) {
                                                $month5_acknowledge = 'Yes';
                                            } else {
                                                $month5_acknowledge = 'No';
                                            }
                                        }
                                        return $month5_acknowledge;
                                    }
                                ],
                                [
                                    'attribute' => 'month6',
                                    'header' => 'Name',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-success-50'],
                                    'value' => function ($model) {
                                        return isset($model->month6) ? date("F Y", strtotime($model->month6)) : '';
                                    }
                                ],
                                [
                                    'attribute' => 'month6_payment_date',
                                    'header' => 'Date',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-success-50'],
                                    'value' => function ($model) {
                                        return isset($model->month6_payment_date) ? $model->month6_payment_date : '';
                                    }
                                ],
                                [
                                    'attribute' => 'month6_acknowledge_amount',
                                    'header' => 'Ack.',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-success-50'],
                                    'value' => function ($model) {
                                        $month6_acknowledge = '';
                                        if (isset($model->month6)) {
                                            if (isset($model->month6_acknowledge_amount)) {
                                                $month6_acknowledge = 'Yes';
                                            } else {
                                                $month6_acknowledge = 'No';
                                            }
                                        }
                                        return $month6_acknowledge;
                                    }
                                ],
                                [
                                    'attribute' => 'Action',
                                    'label' => 'ऐक्शन 1',
                                    'format' => 'raw',
                                    'enableSorting' => false,
                                    'visible' => \Yii::$app->params['airphone_call'] and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE]),
                                    'value' => function ($model) {

                                        return $model->bc->callaction;
                                    }
                                ],
//                                [
//                                    'class' => 'yii\grid\ActionColumn',
//                                    'header' => 'Action',
//                                    'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_SPM_FINANCE]),
//                                    'template' => '{bcpayment}',
//                                    'buttons' => [
//                                        'bcpayment' => function ($url, $model) {
//                                            return ( in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FINANCE])) ? Html::button('Payment', [
//                                                'data-pjax' => "0",
//                                                'class' => 'btn   btn-info popb',
//                                                'value' => '/bc/honorarium/view?bcid=' . $model->bc->id,
//                                                'title' => 'Honorarium payment to  : ' . $model->bc->name
//                                            ]) . ' ' : '';
//                                        },
//                                    ]
//                                ],
                            ],
                        ]);
                        ?> 
                    </div>      
                    <?php
                    $js = <<<js
        
        $(document).ready(function(){           
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/bc/honorarium"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

                    $this->registerJs($js);
                    ?>     
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/bc/honorarium"});
    $("#Searchform").attr("data-pjax", "True");                
    $(this).closest('form').submit();
});            
    
JS;
                    $this->registerJs($script);
                    ?>
                    <?php
                    $js = <<< JS
$(document).on('ready pjax:success', function() {
        function updateURLParameter(url, param, paramVal)
        {
        var TheAnchor = null;
        var newAdditionalURL = "";
        var tempArray = url.split("?");
        var baseURL = tempArray[0];
        var additionalURL = tempArray[1];
        var temp ="";                       
                                                              
        if (additionalURL)                                    
        {                                                     
            var tmpAnchor = additionalURL.split("#");         
            var TheParams = tmpAnchor[0];                     
            TheAnchor = tmpAnchor[1];                         
            if(TheAnchor)                                     
                additionalURL = TheParams;                    
                                                              
            tempArray = additionalURL.split("&");             
                                                              
            for (var i=0; i<tempArray.length; i++)            
            {                                                 
                if(tempArray[i].split('=')[0] != param)       
                {                                             
                    newAdditionalURL += temp + tempArray[i];  
                    temp = "&";                               
                }                                             
            }                                                 
        }                                                     
        else                                                  
        {                                                     
            var tmpAnchor = baseURL.split("#");               
            var TheParams = tmpAnchor[0];                     
            TheAnchor  = tmpAnchor[1];                        
                                                              
            if(TheParams)
                baseURL = TheParams;     
        }                                                                      
                                                                               
        if(TheAnchor)                                                          
            paramVal += "#" + TheAnchor;                                       
                                                                               
        var rows_txt = temp + "" + param + "=" + paramVal;                     
        return baseURL + "?" + newAdditionalURL + rows_txt;                    
    }

    $('.pagination li a').click(function(event){
            event.preventDefault(); 
            var page = $(this).data('page') + 1;
            var href = updateURLParameter(this.href, 'page', page); 
            $('#Searchform').prop('action', href);
            $('#Searchform').submit();
        });  
});
JS;
                    $this->registerJs($js)
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
//    'options' => ['data-backdrop' => 'true',],
                        'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
                        ],
                    ]);
                    echo "<div id='imagecontent'></div>";
                    Modal::end();
                    ?>
                    <?php ActiveForm::end(); ?> 
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
