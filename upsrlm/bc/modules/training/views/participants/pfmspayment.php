<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = "PFMS & Payment";
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

                    <?php echo $this->render('_searchpfms', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-3"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
//                        'pjax' => TRUE,
//                        'floatHeader' => true,
//                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'header' => 'BC Name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                    $html = '';
                                    if (isset($arr[$model->participant->blocked])) {
                                        $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                    }
                                    return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
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
//                    [
//                        'attribute' => 'mobile_no',
//                        'header' => 'Mobile No.',
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function ($model) {
//                            return $model->mobile_number;
//                        }
//                    ],
//                    [
//                        'attribute' => 'aadhar_number',
//                        'header' => 'Aadhaar Number',
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function ($model) {
//                            return isset($model->participant->aadhar_number) ? common\helpers\Utility::maskaadhar($model->participant->aadhar_number) : '';
//                        }
//                    ],
//                    [
//                        'attribute' => 'certificate_code',
////                        'contentOptions' => ['style' => 'width: 10%'],
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function ($model) {
//                            return $model->certificate_code != null ? $model->certificate_code : '';
//                        }
//                    ],
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
//                    [
//                        'attribute' => 'block_name',
//                        'header' => 'BC Block',
//                        'format' => 'html',
////                        'contentOptions' => ['style' => 'width: 10%'],
//                        'enableSorting' => false,
//                        'value' => function ($model) {
//                            return $model->block_name;
//                        }
//                    ],
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
                                    $html = '';
                                    if (in_array($model->participant->bc_bank, [1, 3])) {
                                        $html .= 'Yes<br/>';
                                    }
                                    if (in_array($model->participant->bc_bank, [0])) {
                                        $html .= 'No<br/>';
                                    }
                                    return (isset($model->participant->bank_account_no_of_the_bc) and $model->participant->bc_bank == 2) ? $model->participant->bank_account_no_of_the_bc . '<br/>' . $model->participant->bcbanks : $html . $model->participant->bcbanks;
                                }
                            ],
//                    [
//                        'attribute' => 'SHG Name',
//                        'header' => 'BC SHG Name',
//                        'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function ($model) {
//                            return isset($model->participant->your_group_name) ? $model->participant->your_group_name : '';
//                        }
//                    ],
                            [
                                'attribute' => 'upsrlm_shg_name',
                                'header' => 'UPSRLM SHG Name',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $shg = cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                                    return isset($shg->name_of_shg) ? $shg->name_of_shg : '';
                                }
                            ],
                            [
                                'attribute' => 'SHG bank a/c',
                                'header' => 'SHG bank a/c',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $html = '';
                                    if (in_array($model->participant->shg_bank, [1, 3])) {
                                        $html .= 'Yes<br/>';
                                    }
                                    if (in_array($model->participant->shg_bank, [0])) {
                                        $html .= 'No<br/>';
                                    }
                                    $shg = cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                                    return ($model->participant->bank_account_no_of_the_shg != null and $model->participant->shg_bank == 2) ? $model->participant->bank_account_no_of_the_shg . '<br/>' . $model->participant->shgbanks : $html . $model->participant->shgbanks;
                                }
                            ],
//                    [
//                        'attribute' => 'pfms_maped_status',
//                        'header' => 'PFMS STATUS',
//                        //'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS]),
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function ($model) {
//                            $status = '';
//                            if ($model->participant->pfms_maped_status == 1) {
//                                $status = 'Yes';
//                            }
//                            if ($model->participant->pfms_maped_status == 0) {
//                                $status = 'No';
//                            }
//                            return $status;
//                        }
//                    ],
                            [
                                'attribute' => 'beneficiaries_code',
                                'header' => 'Beneficiaries code',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->participant->beneficiaries_code != null ? $model->participant->beneficiaries_code : '';
                                }
                            ],
                            [
                                'attribute' => 'bc_shg_funds_status',
                                'header' => 'BC-SHG payment status',
                                //'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS]),
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $status = '';
                                    if ($model->participant->bc_shg_funds_status == 1) {
                                        $status = 'Yes';
                                    }
                                    if ($model->participant->bc_shg_funds_status == 0) {
                                        $status = 'No';
                                    }
                                    return $status;
                                }
                            ],
//                    [
//                        'header' => 'Upload PVR',
//                        'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
//                        'value' => function ($model) {
//                            return $model->participant->pvr_status == 1 ? 'Yes' : 'No';
//                        },
//                    ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FINANCE]),
                                'template' => '{verification}',
                                'buttons' => [
                                    'verification' => function ($url, $model) {
                                        $shg_passbook_photo = null;
                                        $shg = cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                                        if ($shg != null) {
                                            $shg_passbook_photo = $shg->passbook_photo;
                                        }
                                        $html = '';
                                        if ($model->participant->blocked == 0) {
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FINANCE]) and $model->participant->shg_bank == 2 and $model->participant->bc_bank == 2 and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0' and $model->participant->bc_shg_funds_status == null and $model->participant->pfms_maped_status == 1) {
                                                $html .= Html::button('<span class="">Revert PFMS Beneficiaries code</span>', [
                                                            'data-pjax' => "0",
                                                            'class' => 'btn  btn-danger popb',
                                                            'value' => '/training/participants/beneficiariesrevert?bcid=' . $model->participant->id,
                                                            'title' => 'Revert PFMS Beneficiaries code ' . $model->participant->name
                                                ]);
                                            }
                                            if (($model->participant->shg_bank == 2 and $model->participant->bc_bank == 2 and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0' and $model->participant->pfms_maped_status == 1 and $model->participant->bc_shg_funds_status == null)) {
                                                $html .= yii\helpers\Html::button('<i class="fa fa-task"></i>BC SHG funds transfer', ['id' => 'pfms-maped-action-' . $model->participant->id, 'class' => 'btn  btn-info popb', 'value' => '/training/participants/mappfms?bcid=' . $model->participant->id, 'name' => 'takeaction', 'data-pjax' => "0", 'title' => 'BC SHG funds transfer']);
                                            }
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FINANCE]) and $model->participant->shg_bank == 2 and $model->participant->bc_bank == 2 and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0' and $model->participant->bc_shg_funds_status == 1 and $model->participant->bc_support_funds_received == null) {
                                                $html .= Html::button('<span class="">Revert BC SHG funds transfer</span>', [
                                                            'data-pjax' => "0",
                                                            'class' => 'btn  btn-danger popb',
                                                            'value' => '/training/participants/mappfmsrevert?bcid=' . $model->participant->id,
                                                            'title' => 'Revert BC SHG funds transfer ' . $model->participant->name
                                                ]);
                                            }
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE]) and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0') {
                                                $html .= yii\helpers\Html::button('<i class="fal fa-eye"></i> View BC GP SHG', ['id' => 'bc-gp-shg-' . $model->participant->id, 'style' => 'margin-top:5px;', 'class' => 'btn  btn-warning popb', 'value' => '/training/participants/shg?gram_panchayat_code=' . $model->gram_panchayat_code, 'name' => 'takeaction', 'title' => 'BC GP : ' . $model->gram_panchayat_name . ' SHG']) . ' ';
                                            }
                                        }
                                        return $html;
                                    },
                                ]
                            ],
                        ],
                    ]);
                    ?>
                    <?php
                    $js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/bc/training/participants/pfmspaymentcsv"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/bc/training/participants/pfmspayment"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

                    $this->registerJs($js);
                    ?>     
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/bc/training/participants/pfmspayment"});
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
                        'size' => 'modal-xl',
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
