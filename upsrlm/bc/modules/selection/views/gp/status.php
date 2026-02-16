<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = 'SRLM BC Selection : Vacant GP';
$this->params['icon'] = 'fa fa-pie-chart';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
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
                    echo $this->render('_search', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <?php ActiveForm::end(); ?>
                    <div class="clearfix pt-3"></div>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'district_name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'District',
                                'value' => function ($model) {
                                    return $model->district_name;
                                },
                            ],
                            [
                                'attribute' => 'block_name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'Block',
                                'value' => function ($model) {
                                    return $model->block_name;
                                },
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'GP',
                                'value' => function ($model) {
                                    return $model->gram_panchayat_name;
                                },
                            ],
                            [
                                'attribute' => 'no_of_application',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'No. of Available Application',
                                'value' => function ($model) {
                                    return $model->current_available;
                                },
                            ],
                            [
                                'attribute' => 'Current Status',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'Current Status',
                                'value' => function ($model) {
                                    $arr = ['-2' => 'Unwilling', '0' => 'Preselected', 1 => 'Agree for training', 2 => 'In batch', 3 => 'Certified', '4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent', '32' => 'Certified Unwilling'];
                                    return isset($arr[$model->current_status]) ? $arr[$model->current_status] : 'No Application';
                                },
                            ],
                        ],
                    ]);
                    ?>


                </div>
            </div>
        </div>
    </div>
    
    <?php
    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/selection/gp/status"});
    $("#Searchform").attr("data-pjax", "True");                
    $(this).closest('form').submit();
});            
    
JS;
    $this->registerJs($script);
    ?>
    <?php Pjax::end(); ?>   
   

