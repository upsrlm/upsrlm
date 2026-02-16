<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'Darpan' ?>
                </h2>

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
                    <div class="clearfix pt-3"></div>

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
                    <div class="col-xl-12 mt-3">
                        <div class="row">
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-warning-700 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                           
                                                echo $searchModel->getFirstpushdate();
                                            ?>
                                            <small class="m-0 l-h-n">Data Push Start Date</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-calendar position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            
                                                echo $searchModel->getLastpushdate();
                                            ?>
                                            <small class="m-0 l-h-n">Data Push Last Date</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa fa-calendar position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            
                                                echo '<i class="fal fa-date"></i> ' . ($searchModel->getTotalpushday()+$searchModel->getRemainpushday());
                                            ?>
                                            <small class="m-0 l-h-n">No of days</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-calendar fa-spin position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            
                                                echo '<i class="fal fa-date"></i> ' . $searchModel->getTotalpushday();
                                            ?>
                                            <small class="m-0 l-h-n">No of days data push</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-calendar fa-spin position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                           
                                                echo '<i class="fal fa-rupe"></i> ' . $searchModel->getRemainpushday();
                                            ?>
                                            <small class="m-0 l-h-n">Not Push Data days</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-calendar fa-spin position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>

                        </div>

                    </div>
                    <?php
                    echo $this->render('_search', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <?php ActiveForm::end(); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "\n{summary}\n{items}",
    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
    'id' => 'grid-data',
    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
    'pjax' => true,

    'afterHeader' => [
        [
            'columns' => [
                [
                    'content' => '0',
                    'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100'],
                ],
                [
                    'content' => 'Total',
                    'options' => ['colspan' => 4, 'class' => 'font-weight-bold bg-warning-100 text-right'],
                ],
                [
                    'content' => $searchModel->getTotaltc() . ' ' . $searchModel->getTcontc(),
                    'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100'],
                ],
                [
                    'content' => $searchModel->getTotaloperational() . ' ' . $searchModel->getTconop(),
                    'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-warning-100'],
                ],
            ],
        ],
    ],

    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'header' => 'Srl.No.',
            'contentOptions' => ['width' => '4px'],
        ],

        [
            'attribute' => 'state_name',
            'enableSorting' => false,
            'value' => fn($model) => $model->state_name ?? '',
        ],

        [
            'attribute' => 'division_name',
            'enableSorting' => false,
            'value' => fn($model) => $model->div->lgd_division_name ?? '',
        ],

        [
            'attribute' => 'district_name',
            'enableSorting' => false,
            'value' => fn($model) => $model->district_name ?? '',
        ],

        [
            'attribute' => 'block_name',
            'enableSorting' => false,
            'value' => fn($model) => $model->block_name ?? '',
        ],

        [
            'attribute' => 'trained_and_certified',
            'enableSorting' => false,
            'format' => 'raw',
            'value' => fn($model) => isset($model->trained_and_certified)
                ? $model->trained_and_certified . ' ' . $model->iconts
                : '',
        ],

        [
            'attribute' => 'operational',
            'enableSorting' => false,
            'format' => 'raw',
            'value' => fn($model) => isset($model->operational)
                ? $model->operational . ' ' . $model->iconop
                : '',
        ],
    ],
]); ?>

<?php
$js = <<<JS
$(document).ready(function () {
    $("#download").click(function () {
        $("#Searchform").attr("action", "/bc/darpan/downloadmonthli");
        $("#Searchform").removeAttr("data-pjax");
        $("#Searchform").submit();
    });

    $("#searchbtn").click(function () {
        $("#Searchform").attr("action", "/bc/darpan");
        $("#Searchform").attr("data-pjax", "true");
    });
});
JS;

$this->registerJs($js);

$script = <<<JS
$('form select').on('change', function () {
    $("#Searchform").attr("action", "/bc/darpan");
    $("#Searchform").attr("data-pjax", "true");
    $(this).closest('form').submit();
});
JS;

$this->registerJs($script);
?>

<?php Pjax::end(); ?>
