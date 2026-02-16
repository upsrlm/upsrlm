<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
                    <?= 'Trainees appeared' ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
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
//                    [
//                        'attribute' => 'batch',
//                        'contentOptions' => ['style' => 'width: 10%'],
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function($model) {
//                            return $model->batch->batch_name;
//                        }
//                    ],
//                    [
//                        'label' => 'Training',
//                        'attribute' => 'start_date',
//                        'contentOptions' => ['style' => 'width: 13%;'],
//                        'format' => 'raw',
//                        'value' => function($model) {
//                            return isset($model->training) ? $model->training->date : '';
//                        }
//                    ],
//                    [
//                        'attribute' => 'schedule_date_of_exam',
//                        'contentOptions' => ['style' => 'width: 12%'],
//                        'enableSorting' => false,
//                        'value' => function($model) {
//                            return isset($model->training) ? \Yii::$app->formatter->asDatetime($model->training->schedule_date_of_exam, "php:d-m-Y") : "";
//                        }
//                    ],
                            [
                                'attribute' => 'exam_appeared',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'format' => 'raw',
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
                                'value' => function ($model) {
                                    return $model->exam_score >= 40 ? 'Yes' : '';
                                }
                            ],
//                    [
//                        'attribute' => 'exam_score',
//                        'contentOptions' => ['style' => 'width: 6%'],
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function($model) {
//                            return $model->exam_score != null ? $model->exam_score : '';
//                        }
//                    ],
                            [
                                'attribute' => 'certificate_code',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->certificate_code != null ? $model->certificate_code : '';
                                }
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
$js = <<<JS
$(function () {      
   $('.popb').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
        });
});  
        
JS;
$this->registerJs($js);
?> 

<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
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
    'size' => 'modal-md',
//    'options' => ['data-backdrop' => 'true',],
    'clientOptions' => [
//      'backdrop' => 'static',
//      'keyboard' => false,  
    ],
]);
echo "<div id='fcontent'></div>";
Modal::end();
?>  


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
