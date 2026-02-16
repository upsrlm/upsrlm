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

$this->title = 'BC Sakhi';
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
                                'header' => 'Name / Guardian Name / Mobile No',
                                'enableSorting' => false,
//                                'contentOptions' => ['style' => 'width: 9%'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $status = '';

                                    $html = '';
                                    if ($model->urban_shg == '1') {
                                        $html .= '<div class="text-danger">GP Convert Urban</div>';
                                    }
                                    return $model->name . '<br/>' . $model->guardian_name . '<br/>' . $model->mobile_number . $status . $html;
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
                                    return $model->fulladdress;
                                },
                            ],
                            [
                                'attribute' => 'OTP Verified mobile no',
                                'enableSorting' => false,
                                'format' => 'html',
                                'value' => function ($model) {
                                    return $model->mobile_no;
                                },
                            ],
                            [
                                'attribute' => 'pin',
                                'header' => 'PIN',
                                'enableSorting' => false,
                                'format' => 'html',
                                'value' => function ($model) {
                                     return (isset($model->user) and $model->blocked==0) ? $model->user->pin : '';
                                },
                            ],
                            [
                                'attribute' => 'no_of_transaction',
                                'header' => 'No. of transaction',
                                'enableSorting' => false,
                                'format' => 'html',
                                'value' => function ($model) {
                                    return $model->no_of_transaction;
                                },
                            ],
                            [
                                'attribute' => 'rishta_app_last_access_time',
                                'header' => 'Rishta Last Used Time',
                                'enableSorting' => false,
                                'format' => 'html',
                                'value' => function ($model) {
                                    return isset($model->rishta_app_last_access_time) ? $model->rishta_app_last_access_time : '';
                                },
                            ],
                            [
                                'attribute' => 'rishta_access_page_count',
                                'header' => 'Access Page ',
                                'enableSorting' => false,
                                'format' => 'html',
                                'value' => function ($model) {
                                    return $model->rishta_access_page_count;
                                },
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


