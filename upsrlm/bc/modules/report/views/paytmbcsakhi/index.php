<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel bc\modules\selection\models\PaytmBcSakhiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Paytm BC Sakhi';
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
                        'enablePushState' => true,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                    ]);
                    ?>

                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-3"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                            [
                                'attribute' => 'application_no',
                               
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return $model->application_no;
                                }
                            ],
                            [
                                'attribute' => 'name',
                                'header' => 'BC Name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return $model->bc->name;
                                }
                            ],
                            [
                                'attribute' => 'mobile_no',
                                'header' => 'Mobile No.',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return common\helpers\Utility::mask($model->otp_mobile_no) . '<br/>' . common\helpers\Utility::mask($model->mobile_number);
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'header' => 'BC District',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district;
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'header' => 'BC Block',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->block;
                                }
                            ],        
                            [
                                'attribute' => 'gram_panchayat_name',
                                'header' => 'BC GP',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->gp;
                                }
                            ],
                            [
                                'attribute' => 'onboarding_status',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->onboarding_status;
                                }
                            ],
                           [
                                'attribute' => 'bmd_1650',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bmd_1650;
                                }
                            ],
                            
                           [
                                'attribute' => 'sarthi_device_25000',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->sarthi_device_25000;
                                }
                            ],
//                           [
//                                'attribute' => 'both_devices',
//                                'format' => 'html',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->both_devices;
//                                }
//                            ],          
//                            [
//                                'attribute' => 'device_not_purchased',
//                                'format' => 'html',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->device_not_purchased;
//                                }
//                            ],
//                             [
//                                'attribute' => 'bankidofbc',
//                                'format' => 'html',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->bankidofbc?$model->bankidofbc:'';
//                                }
//                            ],       
                        //'sarthi_device_25000',
                        //'both_devices',
                        //'device_not_purchased',
                        //'bc_operational',
                        //'district',
                        //'block',
                        //'gp',
                        //'district_code',
                        //'block_code',
                        //'gram_panchayat_code',
                        //'bc_shg_payment_status',
                        //'acknowledge_support_funds_received',
                        //'bankidofbc',
                        //'upsrlm_onboarding_status',
                        //'upsrlm_handheld_machine_status',
                        //'upsrlm_bc_handheld_machine_recived',
                        //'upsrlm_pan_card_status',
                        //'upsrlm_bc_shg_funds_status',
                        //'upsrlm_bc_support_funds_received',
                        //'upsrlm_bankidbc',
                        //'upsrlm_master_partner_bank_id',
                        //'upsrlm_training_status',
                        //'upsrlm_bc_operational',
                        ],
                    ]);
                    ?>
                    <?php
                    $js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/report/paytmbcsakhi"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
         $("#downloadbc").click(function(event){
              $("#Searchform").attr({ "action":"/report/paytmbcsakhi"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            }); 
        $("#downloadbcs").click(function(event){
              $("#Searchform").attr({ "action":"/report/paytmbcsakhi"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });         
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/report/paytmbcsakhi"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

                    $this->registerJs($js);
                    ?>     
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/report/paytmbcsakhi"});
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



                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div>    
    </div>
