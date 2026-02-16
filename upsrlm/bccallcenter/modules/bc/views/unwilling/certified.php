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
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = 'Certified BC Unwiling (Call centre verification pending)';
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

                    <?php echo $this->render('_searchcertified', ['model' => $searchModel]); ?>
                    <div class="clearfix"></div>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}{items}\n{pager}\n{summary}",
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
                                'format' => 'html',
                                'value' => function ($model) {
                                    return $model->mobile_number . '<br/>' . $model->mobile_no;
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
                            [
                                'attribute' => 'address',
                                'enableSorting' => false,
                                'format' => 'html',
                                'value' => function ($model) {
                                    return $model->fulladdressdbgp;
                                },
                            ],
                            [
                                'attribute' => 'Status',
                                'enableSorting' => false,
                                'format' => 'html',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SUPPORT_UNIT]),
                                'value' => function ($model) {
                                    return $model->tstatus;
                                },
                            ],
                            [
                                'attribute' => 'unwlling_reason_resetis',
                                'format' => 'raw',
                                'header' => 'Unwilling Reason by Partner agency',
                                'value' => function ($model) {
                                    return $model->bankunwilling;
                                }
                            ],
                            [
                                'attribute' => 'unwlling_reason_call_center',
                                'format' => 'raw',
                                'header' => 'Unwilling reason by Call Center',
                                'value' => function ($model) {

                                    return $model->callcenterbankunwilling;
                                }
                            ],
                            [
                                'attribute' => 'Action',
                                'format' => 'raw',
                                'visible' => 0,//isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE]),
                                'contentOptions' => ['style' => 'width: 5%'],
                                'value' => function ($model) {
                                    $html = '<span id="' . $model->id . '">';
                                    if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                                        if (in_array($model->training_status, [3])) {

                                            if ($model->bc_unwilling_bank == 1 and $model->bc_unwilling_bank_call_center != 1 and $model->bc_unwilling_bank_call_center != '0') {
                                                $html .= yii\helpers\Html::button('Unwilling', ['id' => 'take-unwilling-' . $model->id, 'class' => 'btn btn-sm btn-block btn-info btn-block popb', 'value' => '/bc/unwilling/callcertified?id=' . $model->id, 'name' => 'takeaction', 'title' => 'Unwilling']) . '<br/>';
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
                                'enableSorting' => false,
                                'label' => 'ऐक्शन 1',
                                'visible' => \Yii::$app->params['airphone_call'] and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE]),
                                'value' => function ($model) {
                                    $html = '';
                                    if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                                        if (in_array($model->training_status, [3])) {

                                            if ($model->bc_unwilling_bank == 1 and $model->bc_unwilling_bank_call_center != 1 and $model->bc_unwilling_bank_call_center != '0') {
                                                $html .= \yii\helpers\Html::a('<i class="fal fa-phone"></i>कॉल करें', ['/platform/call/scenarioatend?bcid=' . $model->id . '&scenario=518'], ['target' => '_blank', 'data-pjax' => 0, 'class' => 'btn btn-info']);
                                            }
                                        }
                                    }
                                    return $html;
                                }
                            ],
                        ],
                    ]);
                    ?>

                    <?php Pjax::end(); ?>   
                </div>
            </div>
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
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right fal fa-times" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
        });
});  
        
JS;
            $this->registerJs($js);
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
