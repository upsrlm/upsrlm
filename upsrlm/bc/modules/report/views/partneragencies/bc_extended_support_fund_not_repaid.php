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
                    <?= 'BC Sakhi declared unwilling; BC Support fund NOT repaid' ?>
                </h2>

            </div>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                'id' => 'grid-data',
                'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                'pjax' => TRUE,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
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
                            $html = '';
                            if (in_array($model->participant->bc_bank, [2])) {
                                $html .= '<br/> Verified';
                            }
                            return isset($model->participant->bank_account_no_of_the_bc) ? 'Yes' . $model->participant->bcbanks : 'No' . $model->participant->bcbanks;
                        }
                    ],
                    [
                        'attribute' => 'pfms_maped_status',
                        'header' => 'SHG PFMS mapping',
                        'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS]),
                        'enableSorting' => false,
                        'format' => 'raw',
                        'value' => function ($model) {
                            $status = '';
                            if ($model->participant->pfms_maped_status == 1) {
                                $status = '<span class="text-success">Yes</span>';
                            }
                            if ($model->participant->pfms_maped_status == 0) {
                                $status = '<span class="text-danger">No</span>';
                            }
                            return $status;
                        }
                    ],
                    [
                        'attribute' => 'bc_shg_funds_status',
                        'header' => 'BC-SHG payment status',
                        'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS]),
                        'enableSorting' => false,
                        'format' => 'raw',
                        'value' => function ($model) {
                            $status = '';
                            if ($model->participant->bc_shg_funds_status == 1) {
                                $status = '<span class="text-success">Yes</span>';
                            }
                            if ($model->participant->bc_shg_funds_status == 0) {
                                $status = '<span class="text-danger">No</span>';
                            }
                            return $status;
                        }
                    ],
                    [
                        'attribute' => 'bc_support_funds_received',
                        'header' => 'Acknowledge support funds received',
                        'enableSorting' => false,
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->participant->bc_support_funds_received == 1 ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';
                        }
                    ],
                    [
                        'attribute' => 'handheld_machine_status',
                        'header' => 'Handheld machine provided',
                        'enableSorting' => false,
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->participant->handheld_machine_status == 1 ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';
                        }
                    ],
                    [
                        'attribute' => 'onboard',
                        'header' => 'Onboard',
                        'enableSorting' => false,
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->participant->onboarding == 1 ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';
                        }
                    ],
                    [
                        'attribute' => 'operational',
                        'header' => 'Operational',
                        'enableSorting' => false,
                        'format' => 'raw',
                        'value' => function ($model) {
                            return \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->where(['bc_application_id' => $model->participant->id])->exists() ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';
                        }
                    ],
                    [
                        'header' => 'Upload PVR',
                        'format' => 'raw',
                        'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                        'value' => function ($model) {
                            return $model->participant->pvr_status == 1 ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';
                        },
                    ],
                ],
            ]);
            ?>
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
