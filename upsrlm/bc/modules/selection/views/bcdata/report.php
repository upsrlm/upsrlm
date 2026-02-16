<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use common\models\master\MasterRole;

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
<div class="dashboard-index">


    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>

    <div class="row-fluid" style="padding-top:5px;padding-bottom:5px">
        <?php
        echo $this->render('_search', [
            'model' => $searchModel, 'form' => $form
        ]);
        ?>
    </div>
    <?php ActiveForm::end(); ?>


</div>

<div class="col-xs-12 applicant" id="printcontaineer">
    <div class="ajax"> </div>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
        'id' => 'grid-data',
        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
        'pjax' => TRUE,
//        'floatHeader' => true,
//        'floatHeaderOptions' => ['scrollingTop' => '50'],
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
                    return Html::a($model->name, "/srlm/data/bcselection/view?id=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]) . $status;
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
                    return $model->user != null ? $model->user->mobile_no : '';
                },
            ],
//            [
//                'attribute' => 'Started filling form on',
//                'enableSorting' => false,
//                'value' => function ($model) {
//                    return $model->form_start_date != null ? $model->form_start_date : '';
//                },
//            ],
//            [
//                'attribute' => 'over_all',
//                'enableSorting' => false,
//                'value' => function ($model) {
//                    return $model->over_all;
//                },
//            ],
            [
                'attribute' => 'Selection Status',
                'format' => 'raw',
                // 'visible' => 0,
                'contentOptions' => ['style' => 'width: 5%'],
                'value' => function ($model) {
                    $status = '';


                    $html = '<span id="' . $model->id . '">';
                    if ($model->status == \app\models\srlm\SrlmBcApplication::STATUS_RECIEVED) {
                         $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> Pending', ['id' => 'call' . $model->id, 'class' => 'btn  btn-info btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                    }
                    if ($model->status == \app\models\srlm\SrlmBcApplication::STATUS_SELECTED) {
                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> Selected', ['id' => 'call' . $model->id, 'class' => 'btn  btn-success btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                    }
                    if ($model->status == \app\models\srlm\SrlmBcApplication::STATUS_STAND_BY_1) {
                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> First standby', ['id' => 'call' . $model->id, 'class' => 'btn  btn-danger btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                    }
                    if ($model->status == \app\models\srlm\SrlmBcApplication::STATUS_STAND_BY_2) {
                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> Second standby', ['id' => 'call' . $model->id, 'class' => 'btn  btn-danger btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                    }
                    $html .='</span>';
                    return $html;
                }
            ],
        ],
    ]);
    ?>


</div>

<?php
$script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/srlm/data/bcselection/report"});
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


