<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = "Verification";
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

                    <?php echo $this->render('_searchverification', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-3"></div>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover table-responsive'],
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
//                        'contentOptions' => ['style' => 'width: 18%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $html = '';
                                    if ($model->participant->urban_shg == '1') {
                                        $html .= '<div class="text-danger">GP Convert Urban</div>';
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
                            [
                                'attribute' => 'district_name',
                                'header' => 'BC District /<br/> BC Block/<br/> BC GP',
                                'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district_name . '/<br/>' . $model->block_name . '/<br/>' . $model->gram_panchayat_name;
                                }
                            ],
//                            [
//                                'attribute' => 'district_name',
//                                'header' => 'BC District /<br/> BC Block',
//                                'format' => 'html',
////                        'contentOptions' => ['style' => 'width: 10%'],
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->district_name . '/<br/>' . $model->block_name;
//                                }
//                            ],
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
//                            [
//                                'attribute' => 'gram_panchayat_name',
//                                'header' => 'BC GP',
//                                'format' => 'html',
////                        'contentOptions' => ['style' => 'width: 10%'],
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->gram_panchayat_name;
//                                }
//                            ],
//                    [
//                        'attribute' => 'member',
////                        'contentOptions' => ['style' => 'width: 10%'],
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function($model) {
//                            return isset($model->participant->agm) ? $model->participant->agm->name_eng : '';
//                        }
//                    ],
//                    [
//                        'attribute' => 'BC bank a/c',
//                        'header' => 'BC bank a/c',
////                        'contentOptions' => ['style' => 'width: 10%'],
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function ($model) {
//                            return isset($model->participant->bank_account_no_of_the_bc) ? $model->participant->bank_account_no_of_the_bc : '';
//                        }
//                    ],
                            [
                                'attribute' => 'iibf_date',
                                'format' => 'html',
                                'header' => 'Certified Date',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return \Yii::$app->formatter->asDatetime($model->participant->iibf_date, "php:Y-m-d");
                                }
                            ],
                            [
                                'attribute' => 'Passbook image',
                                'header' => 'BC Passbook image',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->participant->passbook_photo != null ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'bc_bank',
                                'header' => 'बी0सी0 सखी बैंक विवरण',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $arr = [0 => 'बैंक विवरण अपलोड नहीं ', 1 => 'बैंक विवरण अपलोड किया गया', 2 => 'बैंक विवरण सत्यापित', 3 => 'बैंक विवरण वापसी'];
                                    return $model->participant->bcbanks;
                                }
                            ],
                            [
                                'attribute' => 'SHG Name',
                                'header' => 'BC SHG Name',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_SPM_FI_MF]),
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->participant->your_group_name) ? $model->participant->your_group_name : '';
                                }
                            ],
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
//                    [
//                        'attribute' => 'SHG bank a/c',
//                        'header' => 'SHG bank a/c',
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function ($model) {
//                            $shg = cbo\models\Shg::findOne($model->participant->cbo_shg_id);
//                            return ($model->participant->bank_account_no_of_the_shg != null) ? $model->participant->bank_account_no_of_the_shg : '';
//                        }
//                    ],
                            [
                                'attribute' => 'Passbook image',
                                'header' => 'SHG Passbook image',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return in_array($model->participant->shg_bank, [1, 2, 3]) ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'shg_bank',
                                'header' => 'बी0सी0 सखी स्वयं सहायता समूह बैंक विवरण',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $arr = [0 => 'बैंक विवरण अपलोड नहीं ', 1 => 'बैंक विवरण अपलोड किया गया', 2 => 'बैंक विवरण सत्यापित', 3 => 'बैंक विवरण वापसी'];
                                    return $model->participant->shgbanks;
                                }
                            ],
//                    [
//                        'attribute' => 'BC as Samuh Sakhi',
//                        'header' => 'BC as Samuh Sakhi',
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function ($model) {
//                            return $model->participant->already_group_member == 5 ? 'Yes' : 'No';
//                        }
//                    ],
//                    [
//                        'attribute' => 'beneficiaries_code',
//                        'header' => 'Beneficiaries code',
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function ($model) {
//                            return $model->participant->beneficiaries_code != null ? $model->participant->beneficiaries_code : '';
//                        }
//                    ],
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
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE]),
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
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF]) and $model->participant->urban_shg == '0') {
                                                $html .= ($model->participant->cbo_shg_id == null and in_array($model->participant->reading_skills, [1, 2])) ? yii\helpers\Html::button('<i class="fa fa-task"></i> Assign SHG', ['id' => 'take-action-' . $model->participant->id, 'class' => 'btn btn-block btn-warning  popb', 'value' => '/training/participants/assignshg?bcid=' . $model->participant->id, 'name' => 'takeaction', 'title' => 'Assign SHG']) : '';
                                            }
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FINANCE]) and $model->participant->bc_shg_funds_status != 1 and $model->participant->cbo_shg_id and $model->participant->pfms_maped_status !=1 and $model->participant->urban_shg == '0') {
                                                $html .= Html::button('<span class="">Revert BC SHG Mappig</span>', [
                                                            'data-pjax' => "0",
                                                            'class' => 'btn btn-block btn-danger popb',
                                                            'value' => '/training/participants/shgrevert?bcid=' . $model->participant->id,
                                                            'title' => 'Revert BC SHG Mappig of ' . $model->participant->name
                                                        ]) . ' ';
                                            }
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF]) and ($model->participant->bank_account_no_of_the_bc != null and $model->participant->bank_account_no_of_the_shg != null) and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0' and (($model->participant->bc_bank == 1) or ($model->participant->shg_bank == 1))) {
                                                $html .= ' ' . yii\helpers\Html::a('<i class="fa fa-task"></i> Verify Bank Detail', ['/training/participants/veryfybcshgbank?bcid=' . $model->participant->id], ['id' => 'verify-action-' . $model->participant->id, 'class' => 'btn  btn-info', 'value' => '/training/participants/veryfybcshgbank?bcid=' . $model->participant->id, 'name' => 'takeaction', 'data-pjax' => "0", 'title' => 'BC/ SHG bank detail verification']);
                                            }
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FINANCE]) and $model->participant->urban_shg == '0' and $model->participant->bc_shg_funds_status == null and $model->participant->pfms_maped_status == '0' and (in_array($model->participant->bc_bank, [2]) and in_array($model->participant->shg_bank, [2]))) {
                                                $html .= Html::button('<span class="">Revert Bank verification</span>', [
                                                            'data-pjax' => "0",
                                                            'class' => 'btn btn-block btn-danger popb',
                                                            'value' => '/training/participants/revert?bcid=' . $model->participant->id,
                                                            'title' => 'Revert Bank verification of ' . $model->participant->name
                                                        ]) . ' ';
                                            }
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SPM_FINANCE]) and $model->participant->urban_shg == '0' and $model->participant->blocked == '0') {
                                                $html .= Html::button('<span class="">Blocked BC</span>', [
                                                            'data-pjax' => "0",
                                                            'class' => 'btn btn-block btn-danger popb',
                                                            'value' => '/training/participants/blocked?bcid=' . $model->participant->id,
                                                            'title' => 'Blocked BC ' . $model->participant->name
                                                        ]) . ' ';
                                            }
                                            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE]) and in_array($model->participant->reading_skills, [1, 2]) and $model->participant->urban_shg == '0') {
                                                $html .= yii\helpers\Html::button('<i class="fal fa-eye"></i> View BC GP SHG', ['id' => 'bc-gp-shg-' . $model->participant->id, 'style' => 'margin-top:5px;', 'class' => 'btn btn-block btn-warning popb', 'value' => '/training/participants/shg?gram_panchayat_code=' . $model->gram_panchayat_code, 'name' => 'takeaction', 'title' => 'BC GP : ' . $model->gram_panchayat_name . ' SHG']) . ' ';
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
              $("#Searchform").attr({ "action":"/bc/training/participants/verificationcsv"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/bc/training/participants/verification"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

                    $this->registerJs($js);
                    ?>     
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/bc/training/participants/verification"});
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



                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div>
    </div>
</div> 
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
