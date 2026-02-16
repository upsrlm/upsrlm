<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use common\models\User;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\helpers\Utility;

$this->title = 'SRLM BC Selection report';
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
                    echo $this->render('_rsearch', [
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
//                        'floatHeader' => true,
//                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 12%'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $status = '';
                                    //return $model->name;
                                    return Html::a($model->name, "/selection/phase3/application/view?id=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]) . $status;
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
                                'attribute' => 'age',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 5%'],
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return $model->age != null ? $model->age : '';
                                },
                            ],
                            [
                                'attribute' => 'Social Category',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'value' => function ($model) {
                                    return $model->castrel != null ? $model->castrel->name_eng : '';
                                },
                            ],
                            [
                                'attribute' => 'address',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 20%'],
                                'value' => function ($model) {
                                    return $model->fulladdress;
                                },
                            ],
                            [
                                'attribute' => 'OTP Verified mobile no',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'value' => function ($model) {
                                    return $model->user != null ? Utility::mask($model->user->mobile_no) : '';
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



<?php
$script = <<< JS
    $('form select').on('change', function(){
    
     $("#Searchform").attr("data-pjax", "True");    
    $(this).closest('form').submit();
});            
var loader = $(".ajax");
    $(document).on({
        ajaxStart: function () {
            loader.addClass("lmask");
        },
        ajaxStop: function () {
            loader.removeClass("lmask");
        }
    });         
JS;
$this->registerJs($script);
?>      


<?php Pjax::end(); ?>    


