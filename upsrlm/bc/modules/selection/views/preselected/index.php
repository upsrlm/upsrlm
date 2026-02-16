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

$this->title = 'SRLM BC Selection : Pre Selected';
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
                                'method' => 'POST',
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
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $html = '';
                                    if ($model->urban_shg == '1') {
                                        $html .= '<div class="text-danger">GP Convert Urban</div>';
                                    }
                                    return $model->name . $html;
                                    //return Html::a($model->name, "/selection/data/application/view?id=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]) . $status;
                                    ///return $model->name_of_head_of_household;
                                },
                            ],
                            [
                                'attribute' => 'guardian_name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->guardian_name != null ? $model->guardian_name : '';
                                },
                            ],
                            [
                                'attribute' => 'mobile_number',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return common\helpers\Utility::mask($model->mobile_number);
                                },
                            ],
                            [
                                'attribute' => 'age',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return $model->age != null ? $model->age : '';
                                },
                            ],
//            [
//                'attribute' => 'Social Category',
//                'enableSorting' => false,
//                'format' => 'html',
//                'contentOptions' => ['style' => 'width: 8%'],
//                'value' => function ($model) {
//                    return $model->castrel != null ? $model->castrel->name_eng : '';
//                },
//            ],
                            [
                                'attribute' => 'address',
                                'enableSorting' => false,
                                'format' => 'html',
                                'value' => function ($model) {
                                    return $model->fulladdress;
                                },
                            ],
                            [
                                'attribute' => 'OTP Verified mobile no',
                                'enableSorting' => false,
                                'format' => 'html',
//                'contentOptions' => ['style' => 'width: 8%'],
                                'value' => function ($model) {
                                    return $model->user != null ? common\helpers\Utility::mask($model->user->mobile_no) : '';
                                },
                            ],
                            [
                                'attribute' => 'Selection Status',
                                'format' => 'raw',
                                'visible' => 0,
//                'contentOptions' => ['style' => 'width: 5%'],
                                'value' => function ($model) {
                                    $status = '';

                                    $html = '<span id="' . $model->id . '">';
                                    if ($model->status == SrlmBcApplication::STATUS_RECIEVED) {
                                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> Pending', ['id' => 'call' . $model->id, 'class' => 'btn  btn-info btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                                    }
                                    if ($model->status == SrlmBcApplication::STATUS_PROVISIONAL) {
                                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i>Shortlisted', ['id' => 'call' . $model->id, 'class' => 'btn  btn-success btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                                    }
                                    if ($model->status == SrlmBcApplication::STATUS_SELECTED) {
                                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> Selected', ['id' => 'call' . $model->id, 'class' => 'btn  btn-success btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                                    }
                                    if ($model->status == SrlmBcApplication::STATUS_STAND_BY_1) {
                                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> First standby', ['id' => 'call' . $model->id, 'class' => 'btn  btn-danger btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                                    }
                                    if ($model->status == SrlmBcApplication::STATUS_STAND_BY_2) {
                                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> Second standby', ['id' => 'call' . $model->id, 'class' => 'btn  btn-danger btn-block popb', 'value' => '/srlm/data/bcselection/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                                    }
                                    $html .= '</span>';
                                    return $html;
                                }
                            ],
                            [
                                'attribute' => 'Call Status',
                                'enableSorting' => false,
                                'format' => 'html',
                                'visible' => (MasterRole::ROLE_YOUNG_PROFESSIONAL == Yii::$app->user->identity->role || MasterRole::ROLE_ADMIN == Yii::$app->user->identity->role),
                                'value' => function ($model) {
                                    return $model->call1 == "1" ? "Done" : '';
                                },
                            ],
                            [
                                'attribute' => 'Status',
                                'enableSorting' => false,
                                'format' => 'html',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BACKEND_OPERATOR]),
                                'value' => function ($model) {
                                    return $model->tstatus;
                                },
                            ],
                            [
                                'attribute' => 'selection_round',
                                'enableSorting' => false,
                                'format' => 'html',
                                'value' => function ($model) {
                                    return 'Round '.$model->selection_by;
                                },
                            ],            
//                            [
//                                'attribute' => 'Action',
//                                'format' => 'raw',
//                                'visible' => MasterRole::ROLE_YOUNG_PROFESSIONAL == Yii::$app->user->identity->role,
//                                'value' => function ($model) {
//
//                                    $html = '<span id="' . $model->id . '">';
//                                    if ($model->urban_shg == '0') {
//                                        if ($model->call1 != 1) {
//                                            $html .= yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Call Status', ['id' => 'take-verify-' . $model->id, 'class' => 'btn  btn-warning btn-block popb', 'value' => '/selection/preselected/call1update?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Call Status']);
//                                        }
//                                    }
//                                    $html .= "</span>";
//                                    return $html;
//                                }
//                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_YOUNG_PROFESSIONAL]),
                                'template' => '{updatebcname}',
                                'buttons' => [
                                    'updatebcname' => function ($url, $model) {
                                        $html = '<span id="' . $model->id . '">';
                                        if ($model->urban_shg == '0' and $model->training_status != '-2') {
                                            $html .= yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Update BC Name', ['id' => 'take-verify-' . $model->id, 'class' => 'btn  btn-warning btn-block popb', 'value' => '/selection/preselected/bcnameupdate?bcid=' . $model->id, 'name' => 'takeaction', 'title' => 'Update BC Name Update']);
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
                                                $html .= yii\helpers\Html::button('<i class="fa fa-thumb-up"></i> Update BC Age', ['id' => 'age-verify-' . $model->id, 'class' => 'btn  btn-info btn-block popb', 'value' => '/selection/preselected/ageupdate?bcid=' . $model->id, 'name' => 'takeaction', 'title' => 'Update BC Age']);
                                            }
                                            if (in_array($model->training_status, [0]) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {

                                                $html .= yii\helpers\Html::button('<i class="fa fa-thumb-down"></i> Ineligible candidate', ['id' => 'take-Ineligible-' . $model->id, 'style' => 'margin-top:5px', 'class' => 'btn  btn-block btn-danger btn-block popb', 'value' => '/selection/preselected/ineligible?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Ineligible candidate']) . '<br/>';
                                            }
                                            if (in_array($model->bc_photo_status, [1]) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {

                                                $html .= yii\helpers\Html::button('<i class="fa fa-thumb-down"></i> Reset BC Profile Photo', ['id' => 'take-reset-photo-' . $model->id, 'style' => 'margin-top:5px', 'class' => 'btn  btn-block btn-danger btn-block popb', 'value' => '/selection/preselected/resetbcphoto?bcid=' . $model->id, 'name' => 'takeaction', 'title' => 'Reset candidate Profile Photo']) . '<br/>';
                                            }
                                        }
                                        $html .= "</span>";
                                        return $html;
                                    },
                                ]
                            ],
                        ],
                    ]);
                    ?>


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
        jQuery.noConflict();                
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
                $css = <<<cs
 .modal-xl {
    width: 80% !important;;
}       
cs;
                $this->registerCss($css);
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

            </div> 
        </div>
    </div>
</div> 
<?php Pjax::end(); ?>  



<?php
$this->registerJs(
        '
function init_click_handlers(){

  $(".popb").click(function(e) {
    jQuery.noConflict();
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


