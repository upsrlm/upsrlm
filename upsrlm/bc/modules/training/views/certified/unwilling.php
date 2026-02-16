<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = "Unwilling/ migrated / demise";
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
                    <?php
                    $form = ActiveForm::begin([
                                'layout' => 'inline',
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'Searchform'
                                ],
                                'method' => 'get',
                    ]);
                    ?>

                    <?php
                    echo $this->render('_search', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <div class="clearfix pt-3"></div>


                    <div class="col-lg-12 pt-3">

                        <div class="card-body">
                            <?php
                            echo GridView::widget([
                                'dataProvider' => $dataProvider,
                                'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                'id' => 'grid-data',
                                'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                'pjax' => TRUE,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                    [
                                        'attribute' => 'name',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                            $html = '';
//                                            if (isset($arr[$model->blocked])) {
//                                                $html .= '<div class="text-danger">' . $arr[$model->blocked] . '</div>';
//                                            }

                                            return Html::a($model->name, '#', ['value' => '/training/participants/view?participantid=' . $model->tparticipant->id, 'data-pjax' => "0", 'title' => $model->name, 'class' => 'popb']) . $html;
                                        }
                                    ],
                                    [
                                        'attribute' => 'mobile_no',
                                        'header' => 'Mobile No.',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return common\helpers\Utility::mask($model->mobile_no) . '<br/>' . common\helpers\Utility::mask($model->mobile_number);
                                        }
                                    ],
                                    [
                                        'attribute' => 'district_name',
                                        'header' => 'BC District /<br/> BC Block/<br/> BC GP',
                                        'format' => 'html',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->district_name . '/<br/>' . $model->block_name . '/<br/>' . $model->gram_panchayat_name;
                                        }
                                    ],
//                                    [
//                                        'attribute' => 'unwlling_reason_bank',
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            return $model->bankunwilling;
//                                        }
//                                    ],
//                                    [
//                                        'attribute' => 'unwlling_reason_call_center',
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            return $model->callcenterbankunwilling;
//                                        }
//                                    ],
                                    [
                                        'header' => 'Upload PVR',
                                        'format' => 'html',
                                        'enableSorting' => false,
                                        'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                        'value' => function ($model) {
                                            return $model->pvr_status == 1 ? '<span class="text-success">Yes</span>'.'<br/>'.\Yii::$app->formatter->asDatetime($model->pvr_upload_date, "php:Y-m-d") : '<span class="text-danger">No</span>';
                                        },
                                    ],
//                                    [
//                                        'attribute' => 'BC bank a/c',
//                                        'header' => 'BC bank a/c',
//                                        'enableSorting' => false,
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            $html = '';
//                                            if (in_array($model->bc_bank, [2])) {
//                                                $html .= '<br/> Verified';
//                                            }
//                                            return isset($model->bank_account_no_of_the_bc) ? 'Yes' . $model->bcbanks : 'No' . $model->bcbanks;
//                                        }
//                                    ],
//                                    [
//                                        'attribute' => 'SHG bank a/c',
//                                        'header' => 'SHG bank a/c',
//                                        'enableSorting' => false,
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            $html = '';
//                                            if (in_array($model->shg_bank, [2])) {
//                                                $html .= '<br/> Verified';
//                                            }
//
//                                            return ($model->bank_account_no_of_the_shg != null) ? 'Yes' . $model->shgbanks : 'No' . $model->shgbanks;
//                                        }
//                                    ],
                                     [
                                        'attribute' => 'pfms_maped_status',
                                        'header' => 'SHG PFMS mapping',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->pfms_maped_status == 1 ? '<span class="text-success">Yes</span>'.'<br/>'.\Yii::$app->formatter->asDatetime($model->beneficiaries_code_date, "php:Y-m-d") : '<span class="text-danger">No</span>';
                                        }
                                    ],            
                                    [
                                        'attribute' => 'bc_shg_funds_status',
                                        'header' => 'BC-SHG payment status',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $status = '';
                                            if ($model->bc_shg_funds_status == 1) {
                                                $status = '<span class="text-success">Yes</span>'.'<br/>'.\Yii::$app->formatter->asDatetime($model->bc_shg_funds_date, "php:Y-m-d");
                                            }
                                            if ($model->bc_shg_funds_status == 0) {
                                                $status = '<span class="text-danger">No</span>';
                                            }
                                            return $status;
                                        }
                                    ],
//                                    [
//                                        'attribute' => 'bc_support_funds_received',
//                                        'header' => 'Acknowledge support funds received',
//                                        'enableSorting' => false,
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            return $model->bc_support_funds_received == 1 ? 'Yes' : 'No';
//                                        }
//                                    ],
                                    [
                                        'attribute' => 'handheld_machine_status',
                                        'header' => 'Handheld machine provided',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->handheld_machine_status == 1 ? '<span class="text-success">Yes</span>'.'<br/>'.\Yii::$app->formatter->asDatetime($model->handheld_machine_date, "php:Y-m-d") : '<span class="text-danger">No</span>';
                                        }
                                    ],
                                    [
                                        'attribute' => 'onboard',
                                        'header' => 'Onboard',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->onboarding == 1 ? '<span class="text-success">Yes</span>'.'<br/>'.\Yii::$app->formatter->asDatetime($model->onboarding_date_time, "php:Y-m-d") : '<span class="text-danger">No</span>';
                                        }
                                    ],
                                    [
                                        'attribute' => 'operational',
                                        'header' => 'Operational',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                         $html='';
                                         if(isset($model->trans)){
                                            $html=\Yii::$app->formatter->asDatetime($model->trans->transaction_start_date, "php:Y-m-d"); 
                                         }
                                            return \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->where(['bc_application_id' => $model->id])->exists() ? '<span class="text-success">Yes</span>'.'<br/>'.$html : '<span class="text-danger">No</span>';
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_payment_count',
//                                        'header' => 'Honorarium',                          
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->bc_payment_count;
                                        }
                                    ],
                                ],
                            ]);
                            ?>
                        </div> 
                    </div>   
                    <?php ActiveForm::end(); ?>
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $("#search-form").attr({ "action":"//training/certified/unwilling"});
    $("#search-form").attr("data-pjax", "True");                
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
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
        });
});  
        
JS;
                    $this->registerJs($js);
                    ?> 
                    <?php
                    $js = <<<JS
$(function () {
   $('.popnelig').click(function(){
        $('#fcontent').html('');
        $('#modal1').modal('show')
         .find('#fcontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader1').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
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
