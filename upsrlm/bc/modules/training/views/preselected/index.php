<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = 'SRLM BC Selection : Pre Selected';
$this->params['icon'] = 'fa fa-pie-chart';
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
                    echo $this->render('_searchpre', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <?php ActiveForm::end(); ?>
                    <div class="clearfix pt-3"></div>
                    <?php if ($searchModel->district_code) { ?>
                        <div class="col-xs-6 col-sm-3">
                            <div class="card">
                                <div class="card-header bg-info-200">
                                    Total applicant agree for training
                                </div>

                                <div class="card-body">

                                    <div class="row">
                                        <div class="price col-sm-4">
                                            <?php
                                            $agree_participant_count = $dataProvideragree->query->count();
                                            echo common\helpers\Utility::numberIndiaStyle($dataProvideragree->query->count());
                                            ?>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_RSETIS_BATCH_CREATOR, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                                                if ($agree_participant_count > 0) {
                                                    echo Html::a('<span class="fal fa-times"> Reset</span>', ['/training/preselected/reset/?district_code=' . $searchModel->district_code], [
                                                        'class' => '',
                                                        'data-pjax' => "0",
                                                        'class' => 'btn  btn-danger',
                                                        'data' => [
                                                            'confirm' => 'Are you absolutely sure reset?',
                                                            'method' => 'post',
                                                        ],
                                                    ]) . ' ';
                                                    echo yii\helpers\Html::button('<i class="fal fa-plus"></i> Add batch', ['id' => 'add-bacth-' . $searchModel->district_code, 'class' => 'btn  btn-info popb', 'value' => '/training/preselected/addbatch?district_code=' . $searchModel->district_code, 'name' => 'takeaction', 'title' => 'Add Batch']);
                                                }
                                            }
                                            ?> 
                                        </div>     
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
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
                                'header' => 'Name / Guardian Name / Mobile No',
                                'enableSorting' => false,
//                                'contentOptions' => ['style' => 'width: 9%'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $status = '';
                                    if ($model->bc_unwilling_rsetis == 1) {
                                        $status .= '<div class="text-danger">Unwilling</div>';
                                    }
                                    $status .= $model->callcenterunwilling;
                                    $html = '';
                                    if ($model->urban_shg == '1') {
                                        $html .= '<div class="text-danger">GP Convert Urban</div>';
                                    }
                                    return $model->name . '<br/>' . $model->guardian_name . '<br/>' . common\helpers\Utility::mask($model->mobile_number) . $status . $html;
                                    //return Html::a($model->name, "/selection/data/application/view?id=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]) . $status;
                                    ///return $model->name_of_head_of_household;
                                },
                            ],
//                            [
//                                'attribute' => 'guardian_name',
//                                'format' => 'html',
//                                'enableSorting' => false,
////                                'contentOptions' => ['style' => 'width: 9%'],
//                                'value' => function ($model) {
//                                    return $model->guardian_name != null ? $model->guardian_name : '';
//                                },
//                            ],
//                            [
//                                'attribute' => 'mobile_number',
////                                'contentOptions' => ['style' => 'width: 7%'],
//                                'enableSorting' => false,
//                            ],
                            [
                                'attribute' => 'age',
                                'enableSorting' => false,
//                                'contentOptions' => ['style' => 'width: 3%'],
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return $model->age != null ? $model->age : '';
                                },
                            ],
//                            [
//                                'attribute' => 'reading_skills',
//                                'enableSorting' => false,
//                                'label' => 'Education',
//                                'format' => 'html',
//                                'value' => function ($model) {
//
//                                    return $model->readingskills != null ? $model->readingskills->name_eng : '';
//                                },
//                            ],
                            [
                                'attribute' => 'address',
                                'enableSorting' => false,
                                'format' => 'html',
//                                'contentOptions' => ['style' => 'width: 15%'],
                                'value' => function ($model) {
                                    return $model->fulladdress;
                                },
                            ],
                            [
                                'attribute' => 'OTP Verified mobile no',
                                'enableSorting' => false,
                                'format' => 'html',
//                                'contentOptions' => ['style' => 'width: 7%'],
                                'value' => function ($model) {
                                    return $model->user != null ? common\helpers\Utility::mask($model->user->mobile_no) : '';
                                },
                            ],
                            [
                                'attribute' => 'Call Status',
                                'header' => 'UPSRLM Call Status',
                                'enableSorting' => false,
                                'format' => 'html',
                                'visible' => 1,
//                                'contentOptions' => ['style' => 'width:7%'],
                                'value' => function ($model) {
                                    return $model->call1 == "1" ? "Done" : '';
                                },
                            ],
                            [
                                'attribute' => 'selection_round',
                                'enableSorting' => false,
                                'format' => 'html',
                                'value' => function ($model) {
                                    return '' . $model->selection_by;
                                },
                            ],
                            [
                                'attribute' => 'Aadhar photo',
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width: 25%'],
                                'value' => function ($model) {
                                    $status = '';
                                    $html = '<span id="' . $model->id . '">';
//                    $html .= $model->user->profile_photo != null ? '<span class="profile-picture">
//                                        <img width="200px" height="200px" src="' . $model->profile_photo_url . '" data-src="' . $model->profile_photo_url . '"  class="lozad" title="profile_photo" style="cursor : pointer"/>
//                                        </span> ' : '';
                                    $html .= $model->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img width="150px" height="150px" src="' . $model->aadhar_front_photo_url . '"  data-src="' . $model->aadhar_front_photo_url . '"  class="lozad" title="aadhar_front_photo" style="cursor : pointer"/>
                                        </span> ' : '';
                                    $html .= $model->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img width="150px" height="150px" src="' . $model->aadhar_back_photo_url . '" data-src="' . $model->aadhar_back_photo_url . '"  class="lozad" title="aadhar_back_photo" style="cursor : pointer"/>
                                        </span> ' : '';

                                    $html .= '</span>';
                                    return $html;
                                }
                            ],
                            [
                                'attribute' => 'Action',
                                'format' => 'raw',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR]),
                                'contentOptions' => ['style' => 'width: 16%'],
                                'value' => function ($model) {
                                    $html = '<span id="' . $model->id . '">';
                                    if ($model->blocked == 0) {
                                        if (!(in_array($model->bc_unwilling_rsetis, [1]) and in_array($model->bc_unwilling_call_center, [1]))) {
                                            //$html .= yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Call trainees; get consent for training', ['id' => 'take-verify-' . $model->id, 'class' => 'btn  btn-warning btn-block popb', 'value' => '/training/preselected/agree?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Call trainees; get consent for training']) . '<br/>';
                                            if (in_array($model->training_status, [0]) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                                                $html .= yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Call', ['id' => 'take2-verify-' . $model->id, 'bckey' => $model->id, 'actiontype' => 1, 'class' => 'btn  btn-success btn-block callbc', 'value' => '/training/preselected/call?bcid=' . $model->id, 'name' => 'takeaction', 'title' => 'Call', 'style' => "margin-top:5px;"]) . '';
                                            }
                                            if (in_array($model->training_status, [0, 1, 2]) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {

//                                                $html .= yii\helpers\Html::button('<i class="fa fa-thumb-down"></i> Ineligible candidate', ['id' => 'take-Ineligible-' . $model->id, 'style' => 'margin-top:5px', 'class' => 'btn  btn-block btn-info btn-block popb', 'value' => '/training/preselected/ineligible?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Ineligible candidate', 'style' => "margin-top:5px;"]) . '<br/>';
                                            }
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                                                
                                                if ($model->status == 2 and $model->training_status == 0 and $model->bc_unwilling_rsetis != 1) {
//                                                    $html .= yii\helpers\Html::button('<i class="fa fa-thumb-down"></i> Unwilling candidate', ['id' => 'take-unwilling-' . $model->id, 'style' => 'margin-top:5px', 'class' => 'btn  btn-block btn-info btn-block popb', 'value' => '/training/preselected/unwilling?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Unwilling candidate', 'style' => "margin-top:5px;"]) . '<br/>';
                                                }
                                            }
                                            
                                        }
                                    }
                                   
                                    $html .= "</span>";
                                    return $html;
                                }
                            ],        
                            [
                                'attribute' => 'Action',
                                'format' => 'raw',
                                'visible' => (MasterRole::ROLE_RSETIS_DISTRICT_UNIT == Yii::$app->user->identity->role || MasterRole::ROLE_ADMIN == Yii::$app->user->identity->role),
                                'contentOptions' => ['style' => 'width: 16%'],
                                'value' => function ($model) {
                                    $html = '<span id="' . $model->id . '">';
                                    if ($model->blocked == 0) {
                                        $html .= yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Update BC Name', ['id' => 'take-verify-' . $model->id, 'class' => 'btn  btn-warning btn-block popb', 'value' => '/training/preselected/bcnameupdate?bcid=' . $model->id, 'name' => 'takeaction', 'title' => 'Update BC Name']);
                                        if (!(in_array($model->bc_unwilling_rsetis, [1]) and in_array($model->bc_unwilling_call_center, [1]))) {
                                            $html .= yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Call trainees; get consent for training', ['id' => 'take-verify-' . $model->id, 'class' => 'btn  btn-warning btn-block popb', 'value' => '/training/preselected/agree?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Call trainees; get consent for training']) . '<br/>';
                                            if (in_array($model->training_status, [0]) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN])) {
                                                $html .= yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Call', ['id' => 'take2-verify-' . $model->id, 'bckey' => $model->id, 'actiontype' => 1, 'class' => 'btn  btn-success btn-block callbc', 'value' => '/training/preselected/call?bcid=' . $model->id, 'name' => 'takeaction', 'title' => 'Call', 'style' => "margin-top:5px;"]) . '';
                                            }
                                            if (in_array($model->training_status, [0, 1, 2]) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {

                                                $html .= yii\helpers\Html::button('<i class="fa fa-thumb-down"></i> Ineligible candidate', ['id' => 'take-Ineligible-' . $model->id, 'style' => 'margin-top:5px', 'class' => 'btn  btn-block btn-info btn-block popb', 'value' => '/training/preselected/ineligible?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Ineligible candidate', 'style' => "margin-top:5px;"]) . '<br/>';
                                            }
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                                                //if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
                                                if ($model->status == 2 and $model->training_status == 0 and $model->bc_unwilling_rsetis != 1) {
                                                    $html .= yii\helpers\Html::button('<i class="fa fa-thumb-down"></i> Unwilling candidate', ['id' => 'take-unwilling-' . $model->id, 'style' => 'margin-top:5px', 'class' => 'btn  btn-block btn-info btn-block popb', 'value' => '/training/preselected/unwilling?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Unwilling candidate', 'style' => "margin-top:5px;"]) . '<br/>';
                                                }
                                            }
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                                                if ($model->status == 2 and $model->training_status == 0) {
                                                    $html .= yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Mark Already Certified', ['id' => 'take-already-' . $model->id, 'style' => 'margin-top:5px', 'class' => 'btn  btn-block btn-danger btn-block popb', 'value' => '/training/preselected/alreadycertified?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Already Certified', 'style' => "margin-top:5px;"]) . '<br/>';
                                                }
                                            }
                                        }
                                    }
                                    if ($model->blocked == 6) {
                                        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                                            $html .= yii\helpers\Html::button('<i class="fa fa-thumb-down"></i> Ineligible candidate', ['id' => 'take-Ineligible-' . $model->id, 'style' => 'margin-top:5px', 'class' => 'btn  btn-block btn-info btn-block popb', 'value' => '/training/preselected/ineligible?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Ineligible candidate', 'style' => "margin-top:5px;"]) . '<br/>';
                                            if ($model->status == 2 and $model->training_status == 0 and $model->bc_unwilling_rsetis != 1) {
                                                $html .= yii\helpers\Html::button('<i class="fa fa-thumb-down"></i> Unwilling candidate', ['id' => 'take-unwilling-' . $model->id, 'style' => 'margin-top:5px', 'class' => 'btn  btn-block btn-info btn-block popb', 'value' => '/training/preselected/unwilling?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Unwilling candidate', 'style' => "margin-top:5px;"]) . '<br/>';
                                            }
                                        }
                                    }
                                    $html .= "</span>";
                                    return $html;
                                }
                            ],
                        ],
                    ]);
                    ?>


                    <?php
                    $js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/bc/training/preselected/downloadcsv"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
                 
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/bc/training/preselected"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

                    $this->registerJs($js);
                    ?>     
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/bc/training/preselected"});
    $("#Searchform").attr("data-pjax", "True");                
    $(this).closest('form').submit();
});            
    
JS;
                    $this->registerJs($script);
                    ?>
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
     $("#Searchform").attr("data-pjax", "True");    
    $(this).closest('form').submit();
});            
        
JS;
                    $this->registerJs($script);
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
    $('#modalform').on('hidden.bs.modal', function () {                        
     $("#Searchform").attr("data-pjax", "True");    
     $("#Searchform").submit();
});   
    $('.callbc').click(function(){
        $('#formcontent').html('');
        var button = $(this);
       button.html('<span class="fal fa-spin fa-spinner"></span> Wait...');
       button.prop('disabled', true);                    
        var url='/call/request?server_id=' + $(this).attr('bckey')+'&actiontype='+$(this).attr('actiontype'); 
                   $.ajax({
                        url: url,
                        type: 'post',
                        data: '',
                        mimeType: 'multipart/form-data',
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        context: this,    
                        success: function (data) {
                                if(data.success === true){
                                 var request_url=$(this).attr('value')+'&log_id='+data.log_id;
//                                $(this).html('');
//                                $(this).prop('disabled', false);   
                                    $('#modalform').modal('show')
                                     .find('#formcontent')
                                    .load(request_url);
                                    document.getElementById('modalHeaderform').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
                                 
                                }
                            },
                            error  : function (e)
                            {
                                console.log(e);
                            }
                           });
                    });                     
       
});  
        
JS;
                    $this->registerJs($js);
                    ?>              
                    <?php
                    $js = <<<JS
                
        observer = lozad('.lozad', {
                                        load: function (el) {
                                            console.log('loading element');
                                            el.src = el.getAttribute('data-src');
                                            // Custom implementation to load an element
                                            // e.g. el.src = el.getAttribute('data-src');

                
                
                                                $(el).elevateZoom({
                                                    scrollZoom: true,
                                                    responsive: true,
                                                    zoomWindowOffetx: -600
                                                });
                                                $('.popbc').click(function () {
                                                    $('#imagecontent').html('');
                                                    $('#modal').modal('show')
                                                            .find('#imagecontent')
                                                            .load($(this).attr('value'));
                                                    document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';
                                                });


                                        }
                                    }); // lazy loads elements with default selector as '.lozad'
                                    observer.observe();     
        
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
                        'headerOptions' => ['id' => 'modalHeaderform'],
                        'id' => 'modalform',
                        'size' => 'modal-xl',
                        'clientOptions' => [
                            'backdrop' => 'static',
                            'keyboard' => false,
                        ],
                    ]);
                    echo "<div id='formcontent'></div>";
                    Modal::end();
                    ?> 
                    <?php
                    $css = <<<cs
 .modal-lg {
    width: 80% !important;;
}       
cs;
                    $this->registerCss($css);
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
