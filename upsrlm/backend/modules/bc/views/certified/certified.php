<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = 'Certified BC';
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
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
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
                                    // $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> View Data', ['id' => 'call' . $model->id, 'class' => 'btn btn-sm btn-warning btn-block popb', 'value' => '/selection/data/application/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                                    return $model->participant->name;
                                }
                            ],
//                    [
//                        'attribute' => 'mobile_no',
//                        'header' => 'Mobile No.',
//                        'enableSorting' => false,
//                        'format' => 'raw',
//                        'value' => function ($model) {
//                            return $model->otp_mobile_no . '<br/>' . $model->mobile_number;
//                        }
//                    ],
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
//                            return isset($model->participant->aadhar_number) ? $model->participant->aadhar_number : '';
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
                                    if (in_array($model->participant->bc_bank, [2])) {
                                        $html .= '<br/> Verified';
                                    }
                                    return isset($model->participant->bank_account_no_of_the_bc) ? 'Yes' . $html : 'No';
                                }
                            ],
                            [
                                'attribute' => 'Passbook image',
                                'header' => 'BC Passbook image',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->participant->passbook_photo != null ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'SHG Name',
                                'header' => 'BC SHG Name as per application',
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
                            [
                                'attribute' => 'SHG bank a/c',
                                'header' => 'SHG bank a/c',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $html = '';
                                    if (in_array($model->participant->shg_bank, [2])) {
                                        $html .= '<br/> Verified';
                                    }
                                    $shg = cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                                    return (isset($shg) and $shg->bank_account_no_of_the_shg != null) ? 'Yes' . $html : 'No';
                                }
                            ],
                            [
                                'attribute' => 'Passbook image',
                                'header' => 'SHG Passbook image',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return in_array($model->participant->shg_bank, [1, 2, 3]) ? 'Yes' : 'No';
//                            $shg = cbo\models\Shg::findOne($model->participant->cbo_shg_id);
//                            return isset($shg->passbook_photo)?'<span class="profile-picture">
//                                        <img width="150px" height="150px" src="' . $shg->passbookUrl . '" data-src="' . $shg->passbookUrl . '"  class="lozad" title="profile_photo" style="cursor : pointer"/>
//                                        </span> ':'';
                                }
                            ],
                            [
                                'attribute' => 'BC as Samuh Sakhi',
                                'header' => 'BC as Samuh Sakhi',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->participant->already_group_member == 5 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'pfms_maped_status',
                                'header' => 'PFMS STATUS',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS]),
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $status = '';
                                    if ($model->participant->pfms_maped_status == 1) {
                                        $status = 'Yes';
                                    }
                                    if ($model->participant->pfms_maped_status == 0) {
                                        $status = 'No';
                                    }
                                    return $status;
                                }
                            ],
//                            [
//                                'attribute' => 'beneficiaries_code',
//                                'header' => 'Beneficiaries code',
//                                'enableSorting' => false,
//                                'format' => 'raw',
//                                'value' => function ($model) {
//                                    return $model->participant->beneficiaries_code != null ? 'Yes' : 'No';
//                                }
//                            ],
                            [
                                'attribute' => 'bc_shg_funds_status',
                                'header' => 'BC-SHG payment status',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS]),
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
                            [
                                'attribute' => 'pan_photo_upload',
                                'header' => 'PAN photo',
                                'visible' => 1,
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->participant->pan_photo_upload == 1 ? 'Yes' : 'No';
                                }
                            ],
//                            [
//                                'attribute' => 'Return to BMMU',
//                                'header' => 'Return to BMMU',
//                                'enableSorting' => false,
//                                'format' => 'raw',
//                                'value' => function ($model) {
//                                    return $model->participant->return_for_shg == 1 ? 'Yes' : 'No';
//                                }
//                            ],
                            [
                                'header' => 'Upload PVR',
                                'value' => function ($model) {
                                    return $model->participant->pvr_status == 1 ? 'Yes' : 'No';
                                },
                            ],
//                            [
//                                'class' => 'yii\grid\ActionColumn',
//                                'header' => 'Action',
//                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
//                                'template' => '{revert}',
//                                'buttons' => [
//                                    'revert' => function ($url, $model) {
//                                        return (in_array($model->participant->bc_bank, [2, 3]) or in_array($model->participant->shg_bank, [2, 3])) ? Html::button('<span class="">Revert Bank verification</span>', [
//                                            'data-pjax' => "0",
//                                            'class' => 'btn btn-sm btn-info popb',
//                                            'value' => '/bc/certified/revert?bcid=' . $model->participant->id,
//                                            'title' => 'Revert Bank verification of ' . $model->participant->name
//                                        ]) : '';
//                                    },
//                                    'assignshg' => function ($url, $model) {
//                                        if (Yii::$app->user->identity->username = '7838275272')
//                                            return $model->participant->cbo_shg_id == null ? yii\helpers\Html::button('<i class="fa fa-task"></i> Assign SHG', ['id' => 'take-action-' . $model->participant->id, 'class' => 'btn btn-sm btn-warning btn-block popb', 'value' => '/bc/certified/assignshg?bcid=' . $model->participant->id, 'name' => 'takeaction', 'title' => 'Assign SHG']) : yii\helpers\Html::button('<i class="fa fa-task"></i> Update SHG', ['id' => 'take-action-' . $model->participant->id, 'class' => 'btn btn-sm btn-warning btn-block popb', 'value' => '/bc/certified/assignshg?bcid=' . $model->participant->id, 'name' => 'takeaction', 'title' => 'Update SHG']);
//                                        else
//                                            return '';
//                                    },
//                                ]
//                            ],
                        ],
                    ]);
                    ?>
                    <?php
                    $js = <<<js
        
        $(document).ready(function(){
             
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
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right fal fa-times pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
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
