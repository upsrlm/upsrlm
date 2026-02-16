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
                    <?= 'Participants mobilised (received consent for trg.)' ?>
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
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 9%'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $status = '';
                                    return $model->name;
                                    //return Html::a($model->name, "/selection/data/application/view?id=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]) . $status;
                                    ///return $model->name_of_head_of_household;
                                },
                            ],
                            [
                                'attribute' => 'guardian_name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 9%'],
                                'value' => function ($model) {
                                    return $model->guardian_name != null ? $model->guardian_name : '';
                                },
                            ],
                            [
                                'attribute' => 'mobile_number',
                                'contentOptions' => ['style' => 'width: 7%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->mobile_number != null ? common\helpers\Utility::mask($model->mobile_number) : '';
                                },
                            ],
                            [
                                'attribute' => 'age',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 3%'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->age != null ? $model->age : '';
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
                                'contentOptions' => ['style' => 'width: 15%'],
                                'value' => function ($model) {
                                    return $model->fulladdress;
                                },
                            ],
                            [
                                'attribute' => 'OTP Verified mobile no',
                                'enableSorting' => false,
                                'format' => 'html',
                                'contentOptions' => ['style' => 'width: 7%'],
                                'value' => function ($model) {
                                    return $model->user != null ? common\helpers\Utility::mask($model->user->mobile_no) : '';
                                },
                            ],
//            [
//                'attribute' => 'Call Status',
//                'header'=>'UPSRLM Call Status',
//                'enableSorting' => false,
//                'format' => 'html',
//                'visible' => 1,
//                'contentOptions' => ['style' => 'width:7%'],
//                'value' => function ($model) {
//                    return $model->call1 == "1" ? "Done" : '';
//                },
//            ],            
                            [
                                'attribute' => 'Aadhar photo',
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width: 26%'],
                                'value' => function ($model) {
                                    $status = '';
                                    $html = '<span id="' . $model->id . '">';
//                    $html .= $model->user->profile_photo != null ? '<span class="profile-picture">
//                                        <img width="200px" height="200px" src="' . $model->profile_photo_url . '" data-src="' . $model->profile_photo_url . '"  class="lozad" title="profile_photo" style="cursor : pointer"/>
//                                        </span> ' : '';
                                    $html .= $model->user->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img width="150px" height="150px"  data-src="' . $model->aadhar_front_photo_url . '"  class="lozad" title="aadhar_front_photo" style="cursor : pointer"/>
                                        </span> ' : '';
                                    $html .= $model->user->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img width="150px" height="150px" data-src="' . $model->aadhar_back_photo_url . '"  class="lozad" title="aadhar_back_photo" style="cursor : pointer"/>
                                        </span> ' : '';

                                    $html .= '</span>';
                                    return $html;
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
