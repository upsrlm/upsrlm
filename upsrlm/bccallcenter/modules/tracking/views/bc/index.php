<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = "BC Tracking";
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

                    <?php echo $this->render('_searcht', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-3"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
//                'floatHeader' => true,
//                'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'header' => 'BC Name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", 21 => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                    $html = '';
                                    if (isset($arr[$model->blocked])) {
                                        $html .= '<div class="text-danger">' . $arr[$model->blocked] . '</div>';
                                    }
                                    return Html::a($model->name, '#', ['value' => '/bc/tracking/view?bdid=' . $model->id, 'data-pjax' => "0", 'title' => $model->name, 'class' => 'popb']) . $html;
                                }
                            ],
                            [
                                'attribute' => 'mobile_no',
                                'header' => 'Mobile No.',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->mobile_no . '<br/>' . $model->mobile_number;
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'header' => 'BC District /<br/> BC Block',
                                'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district_name . '/<br/>' . $model->block_name;
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'header' => 'BC GP',
                                'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->gram_panchayat_name;
                                }
                            ],
                            [
                                'attribute' => 'BC bank a/c',
                                'header' => 'BC bank a/c',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->bank_account_no_of_the_bc) ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'bc_bank',
                                'header' => 'बी0सी0 सखी बैंक विवरण',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $arr = [0 => 'बैंक विवरण अपलोड नहीं ', 1 => 'बैंक विवरण अपलोड किया गया', 2 => 'बैंक विवरण सत्यापित', 3 => 'बैंक विवरण वापसी'];
                                    //return Html::a($model->bcbanks, '#', ['value' => '/bc/certified/bankstatus?bcid=' . $model->participant->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']);
                                    return $model->bcbanks;
                                }
                            ],
                            [
                                'attribute' => 'upsrlm_shg_name',
                                'header' => 'UPSRLM SHG Name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $shg = cbo\models\Shg::findOne($model->cbo_shg_id);
                                    return isset($shg->name_of_shg) ? $shg->name_of_shg : '';
                                }
                            ],
                            [
                                'attribute' => 'SHG bank a/c',
                                'header' => 'SHG bank a/c',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return ($model->bank_account_no_of_the_shg != null) ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'shg_bank',
                                'header' => 'बी0सी0 सखी स्वयं सहायता समूह बैंक विवरण',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $arr = [0 => 'बैंक विवरण अपलोड नहीं ', 1 => 'बैंक विवरण अपलोड किया गया', 2 => 'बैंक विवरण सत्यापित', 3 => 'बैंक विवरण वापसी'];
                                    //return Html::a($model->participant->shgbanks, '#', ['value' => '/bc/certified/bankstatus?bcid=' . $model->participant->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']);
                                    return $model->shgbanks;
                                }
                            ],
                            [
                                'attribute' => 'bc_shg_funds_status',
                                'header' => 'BC-SHG payment status',
                                'visible' => 1,
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
                                'attribute' => 'pan_photo_upload',
                                'header' => 'PAN photo',
                                'visible' => 1,
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->pan_photo_upload == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'bc_photo_status',
                                'header' => 'BC photo',
                                'visible' => 1,
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->bc_photo_status == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'pin',
                                'header' => 'PIN',
                                'visible' => 1,
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return (isset($model->user->pin) and $model->blocked == '0') ? $model->user->pin : '';
                                }
                            ],
                            [
                                'attribute' => 'pin',
                                'header' => 'Got PIN',
                                'visible' => 1,
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return ($model->pin_used == 1) ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'Action',
                                'label' => 'ऐक्शन 1',
                                'format' => 'raw',
                                'enableSorting' => false,
                                //'contentOptions' => ['style' => 'width: 7%'],
                                'visible' => \Yii::$app->params['airphone_call'] and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE]),
                                'value' => function ($model) {
                                    return $model->callaction;
                                }
                            ],
                        ],
                    ]);
                    ?>
                    <?php
                    $css = <<<cs
 
 .modal-xl {
    width: 100% !important;
    max-width: 90% !important; 
       
} 
.form-group {
  margin-bottom: 0px !important;                           
}
   
cs;
                    $this->registerCss($css);
                    ?>
                    <?php
                    $js = <<<js
        
        $(document).ready(function(){
        
        $("#downloadbcs").click(function(event){
              $("#Searchform").attr({ "action":"/bc/certified/csvdownload"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });         
         $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/bc/certified"});
                $("#Searchform").attr("data-pjax", "True");
            })                   
       }) 
js;

                    $this->registerJs($js);
                    ?>     
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/bc/certified"});                        
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
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right ml-auto float-right" data-dismiss="modal" style="cursor : pointer;color:red;float:right"></i>';    
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
