<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'BCs certified by IIBF' ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
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
                                    return Html::a($model->participant->name, '#', ['value' => '/training/participants/view?participantid=' . $model->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']).$html;
                                }
                            ],
                            [
                                'attribute' => 'mobile_no',
                                'header' => 'Mobile No.',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return common\helpers\Utility::mask($model->otp_mobile_no);
                                }
                            ],
                            [
                                'attribute' => 'mobile_no',
                                'header' => 'Mobile No.',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return common\helpers\Utility::mask($model->mobile_number);
                                }
                            ],
                            [
                                'attribute' => 'aadhar_number',
                                'header' => 'Aadhaar Number',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->participant->aadhar_number) ? common\helpers\Utility::maskaadhar($model->participant->aadhar_number) : '';
                                }
                            ],
                            [
                                'attribute' => 'certificate_code',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->certificate_code != null ? $model->certificate_code : '';
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'header' => 'BC District <br/>Block',
                                'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district_name.'<br/>'.$model->block_name;
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
                                    return isset($model->participant->bank_account_no_of_the_bc) ? $model->participant->bank_account_no_of_the_bc : '';
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
                                'header' => 'BC SHG Name',
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
                                    $shg = cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                                    return (isset($shg) and $shg->bank_account_no_of_the_shg != null) ? $shg->bank_account_no_of_the_shg : '';
                                }
                            ],
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
                            
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>    
    </div>
</div>
<?php
$js = <<<JS
$(function () {      
   $('.popb').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
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
