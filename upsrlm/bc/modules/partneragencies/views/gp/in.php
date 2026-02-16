<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\User;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use kartik\editable\Editable;
use kartik\checkbox\CheckboxX;

\kartik\icons\FontAwesomeAsset::register($this);
$this->title = 'Gram Panchayats Open';
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


                    <?php echo $this->render('_insearch', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-3"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'pager' => [
                            'options' => ['class' => 'pagination'],
                            'prevPageLabel' => 'Previous',
                            'nextPageLabel' => 'Next',
                            'firstPageLabel' => 'First',
                            'lastPageLabel' => 'Last',
                            'nextPageCssClass' => 'paginate_button page-item',
                            'prevPageCssClass' => 'paginate_button page-item',
                            'firstPageCssClass' => 'paginate_button page-item',
                            'lastPageCssClass' => 'paginate_button page-item',
                            'maxButtonCount' => 10,
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%']],
                            [
                                'attribute' => 'District',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district != null ? $model->district->district_name : '';
                                },
                            ],
                            [
                                'attribute' => 'block_name',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->block_name;
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->gram_panchayat_name;
                                }
                            ],
                            
                            [
                                'attribute' => 'previous_master_partner_bank_id',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->pbank) ? $model->pbank->bank_name : '';
                                }
                            ],
                            [
                                'attribute' => 'bc_onboarded',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bc_status == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'bank_change_status',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->bankstatus) ? $model->bankstatus : '';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_SPM_FI_MF]),
                                'template' => '{onboarding}',
                                'buttons' => [
                                    'onboarding' => function ($url, $model) {
                                        return ($model->change_status == 1 and $model->bc_status == '1' and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) ? Html::button('Onboarding', [
                                            'data-pjax' => "0",
                                            'style' => 'margin-bottom:5px',
                                            'class' => 'btn btn-info btn-block popb',
                                            'value' => '/partneragencies/gp/onboarding?gram_panchayat_code=' . $model->gram_panchayat_code,
                                            'title' => 'Onboarding GP : ' . $model->gram_panchayat_name
                                        ]) . ' ' : '';
                                    },
                                ]
                            ],
//                            [
//                                'attribute' => 'action',
//                                'header' => 'Select GP',
//                                'format' => 'raw',
//                                'visible'=>0,
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return CheckboxX::widget([
//                                        'name' => 'change_status',
//                                        'value' => $model->change_status > 1 ? 1 : '',
//                                        'disabled' => $model->change_status > 1 ? true : false,
//                                        'initInputType' => CheckboxX::INPUT_CHECKBOX,
//                                        'options' => ['id' => 'change_status_1' . $model->id, 'confirm_text' => 'Are you sure selected this GP ' . $model->gram_panchayat_name . ' this action not undone ', 'change_status' => 2, 'gpcode' => $model->gram_panchayat_code, 'ajax_url' => Yii::$app->params['app_url']['bc'] . '/partneragencies/gp/ajaxupdate?change_status=2&gram_panchayat_code=' . $model->gram_panchayat_code],
//                                        'pluginOptions' => ['threeState' => false, 'size' => 'lg']
//                                    ]);
//                                }
//                            ]
                        ],
                    ]);
                    ?>
                    <?php
                    $js = <<<js
$(document).ready(function(){
    $('input[type=checkbox]').change(function(){
        var id= '#' + $(this).attr('id'); 
        var ajax_url = $(this).attr('ajax_url');
        var confirm_text=$(this).attr('confirm_text');
        if(this.checked) {
            if (confirm(confirm_text)) {
                $.ajax({
                url: ajax_url,
                type: "POST",
                success: function () {
                   history.go(0);
                }
            });
            } else { 
              history.go(0);
            }
        }
    });
});
js;

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
                    $script = <<< JS
    $('form select').on('change', function(){
    $(this).closest('form').submit();
});            
    var loader = $(".ajax");
    $(document).on({
        ajaxStart: function () {
            loader.addClass("loader");
        },
        ajaxStop: function () {
            loader.removeClass("loader");
        }
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
                    Modal::begin([
                        'headerOptions' => ['id' => 'modalHeader'],
                        'id' => 'modal',
                        'size' => 'modal-lg',
                        'clientOptions' => [
                        ],
                    ]);
                    echo "<div id='imagecontent'></div>";
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