<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use common\models\master\MasterRole;
use common\helpers\Utility;

$this->title = 'BC Sakhi list';
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
                    echo $this->render('_listsearch', [
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
                        'beforeHeader' => [
                            [
                                'columns' => [
                                    ['content' => '', 'options' => ['colspan' => 4, 'class' => 'text-center warning']],
                                    ['content' => 'Details of BC Sackhi', 'options' => ['colspan' => 4, 'class' => 'text-center warning']],
                                    ['content' => 'Phone no. of other member of SHG ', 'options' => ['colspan' => 5, 'class' => 'text-center warning']],
                                ],
                            ]
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'district_name',
                                'header' => 'District',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 10%'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->district_name;
                                },
                            ],
                            [
                                'attribute' => 'block_name',
                                'header' => 'Block',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 10%'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->block_name;
                                },
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'header' => 'GP',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 12%'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->gram_panchayat_name;
                                },
                            ],
                            [
                                'attribute' => 'name',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 12%'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $status = '';
                                    //return $model->name;
                                    return Html::a($model->name, "/selection/phase6/application/view?id=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]) . $status;
                                    ///return $model->name_of_head_of_household;
                                },
                            ],
                            [
                                'attribute' => 'guardian_name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 12%'],
                                'value' => function ($model) {
                                    return $model->guardian_name != null ? $model->guardian_name : '';
                                },
                            ],
                            [
                                'attribute' => 'mobile_number',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->mobile_number != null ? Utility::mask($model->mobile_number) : '';
                                },
                            ],
                            [
                                'attribute' => 'OTP Verified mobile no',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'value' => function ($model) {
                                    return $model->user != null ? $model->user->mobile_no : '';
                                },
                            ],
                            [
                                'attribute' => '1',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'value' => function ($model) {
                                    return isset($model->family[0]) ? $model->family[0]->mobile_no : '';
                                },
                            ],
                            [
                                'attribute' => '2',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'value' => function ($model) {
                                    return isset($model->family[1]) ? $model->family[1]->mobile_no : '';
                                },
                            ],
                            [
                                'attribute' => '3',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'value' => function ($model) {
                                    return isset($model->family[2]) ? $model->family[2]->mobile_no : '';
                                },
                            ],
                            [
                                'attribute' => '4',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'value' => function ($model) {
                                    return isset($model->family[3]) ? $model->family[3]->mobile_no : '';
                                },
                            ],
                            [
                                'attribute' => '5',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'value' => function ($model) {
                                    return isset($model->family[4]) ? $model->family[4]->mobile_no : '';
                                },
                            ],
//            [
//                'attribute' => 'over_all',
//                'enableSorting' => false,
//                'value' => function ($model) {
//                    return $model->over_all;
//                },
//            ],
//            [
//                'attribute' => 'Selection Status',
//                'format' => 'raw',
//                // 'visible' => 0,
//                'contentOptions' => ['style' => 'width: 5%'],
//                'value' => function ($model) {
//                    $status = '';
//
//
//                    $html = '<span id="' . $model->id . '">';
//                    if ($model->status == \app\models\srlm\SrlmBcApplication::STATUS_RECIEVED) {
//                         $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> Pending', ['id' => 'call' . $model->id, 'class' => 'btn  btn-info btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
//                    }
//                    if ($model->status == \app\models\srlm\SrlmBcApplication::STATUS_SELECTED) {
//                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> Selected', ['id' => 'call' . $model->id, 'class' => 'btn  btn-success btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
//                    }
//                    if ($model->status == \app\models\srlm\SrlmBcApplication::STATUS_STAND_BY_1) {
//                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> First standby', ['id' => 'call' . $model->id, 'class' => 'btn  btn-danger btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
//                    }
//                    if ($model->status == \app\models\srlm\SrlmBcApplication::STATUS_STAND_BY_2) {
//                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> Second standby', ['id' => 'call' . $model->id, 'class' => 'btn  btn-danger btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
//                    }
//                    $html .='</span>';
//                    return $html;
//                }
//            ],
                        ],
                    ]);
                    ?>


                </div>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/selection/phase2/application/list"});
     $("#Searchform").attr("data-pjax", "True");    
    $(this).closest('form').submit();
});               
JS;
$this->registerJs($script);
?>      


<?php Pjax::end(); ?>    


