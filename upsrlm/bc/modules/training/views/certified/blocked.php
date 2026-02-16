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

$this->title = 'Certified Block BC List';
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
                                'method' => 'POST',
                    ]);
                    ?>


                    <?php
                    echo $this->render('_searchbc', [
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
                                'attribute' => 'name',
                                'enableSorting' => false,
                                'contentOptions' => ['style' => 'width: 9%'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $status = '';
                                    $html = '';
                                    return $model->name . $status . $html;
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
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->mobile_number . '<br/>' . $model->mobile_no;
                                },
                            ],
                            [
                                'attribute' => 'master_partner_bank_id',
                                'visible' => (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])),
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->pbank) ? $model->pbank->bank_short_name : '';
                                }
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
                                'header' => 'Upload PVR',
                                //'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                'value' => function ($model) {
                                    return $model->pvr_status == 1 ? 'Yes' : 'No';
                                },
                            ],
                            [
                                'attribute' => 'bc_shg_funds_status',
                                'header' => 'BC-SHG payment status',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $status = '';
                                    if ($model->bc_shg_funds_status == 1) {
                                        $status = 'Yes';
                                    }
                                    if ($model->bc_shg_funds_status == 0) {
                                        $status = 'No';
                                    }
                                    return $status;
                                }
                            ],
                            [
                                'attribute' => 'onboard',
                                'header' => 'Onboard',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->onboarding == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'operational',
                                'header' => 'Operational',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->bc_operational ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'blocked_reason',
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return $model->blockedr;
                                }
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
//                            [
//                                'class' => 'yii\grid\ActionColumn',
//                                'header' => 'Action',
//                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS]),
//                                'template' => '{unwilling}',
//                                'buttons' => [
//                                    'unwilling' => function ($url, $model) {
//                                        return (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS]) and $model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS and $model->bc_unwilling_bank != 1) ? Html::button('<span class="fa "> Unwilling BC</span>', [
//                                            'data-pjax' => "0",
//                                            'class' => 'btn   btn-danger popb',
//                                            'value' => '/training/participants/unwilling?bcid=' . $model->id,
//                                            'title' => 'Unwilling BC  : ' . $model->name
//                                        ]) . ' ' : '';
//                                    },
//                                ]
//                            ],
                        ],
                    ]);
                    ?>
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
     $("#Searchform").attr({ "action":"/training/certified/blocked"});                        
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

//                                            $(function () {
//                                                $('.popb').elevateZoom({
//                                                    scrollZoom: true,
//                                                    responsive: true,
//                                                    zoomWindowOffetx: -600
//                                                });
//                                                $('.popbc').click(function () {
//                                                    $('#imagecontent').html('');
//                                                    $('#modal').modal('show')
//                                                            .find('#imagecontent')
//                                                            .load($(this).attr('value'));
//                                                    document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';
//                                                });
//                                            });

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
                    $css = <<<cs
 .modal-xl {
    width: 90% !important;;
}       
cs;
                    $this->registerCss($css);
                    ?>
                    <?php
                    $js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/training/certified/blocked"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
                 
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/training/certified/blocked"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

                    $this->registerJs($js);
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
