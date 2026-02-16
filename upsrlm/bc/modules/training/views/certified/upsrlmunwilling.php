<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = "Certified BC Unwiling (UPSRLM verification pending)";
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
                    echo $this->render('_searchupsrlm', [
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
//                        'contentOptions' => ['style' => 'width: 18%'],
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
                                        'attribute' => 'district_name',
                                        'header' => 'BC District /<br/> BC Block/<br/> BC GP',
                                        'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->district_name . '/<br/>' . $model->block_name . '/<br/>' . $model->gram_panchayat_name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'unwlling_reason_bank',
                                        'header' => 'Unwilling Reason Bank',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->bankunwilling;
                                        }
                                    ],
                                    [
                                        'attribute' => 'bc_unwilling_bank_date',
                                        'header' => 'Unwilling Datetime Bank',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->bc_unwilling_bank_date;
                                        }
                                    ],        
                                    [
                                        'attribute' => 'unwlling_reason_bc',
                                         'header' => 'Unwilling Reason BC',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->bcunwilling;
                                        }
                                    ],        
                                   [
                                        'attribute' => 'bc_unwilling_bc_date',
                                        'header' => 'Unwilling Datetime BC',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->bc_unwilling_bc_date;
                                        }
                                    ],
                                   [
                                        'attribute' => 'unwlling_reason_cdo',
                                         'header' => 'Unwilling Reason CDO',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->cdounwilling;
                                        }
                                    ],        
                                   [
                                        'attribute' => 'bc_unwilling_cdo_date',
                                        'header' => 'Unwilling Datetime CDO',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->bc_unwilling_cdo_date;
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
                                                $status = 'Yes';
                                            }
                                            if ($model->bc_shg_funds_status == 0) {
                                                $status = 'No';
                                            }
                                            return $status;
                                        }
                                    ],
                                    
                                    [
                                        'attribute' => 'onboard',
                                        'header' => 'Onboard',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->onboarding == 1 ? 'Yes' : 'No';
                                        }
                                    ],
                                    [
                                        'attribute' => 'operational',
                                        'header' => 'Operational',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->where(['bc_application_id' => $model->id])->exists() ? 'Yes' : 'No';
                                        }
                                    ],
                                   [
                                        'attribute' => 'bc_payment_count',
                                        'enableSorting' => false,                       
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->bc_payment_count;
                                        }
                                    ],
                                     [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD]),
                                'template' => '{unwilling}',
                                'buttons' => [
                                    'unwilling' => function ($url, $model) {
                                        return (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD]) and $model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS and $model->bc_unwilling_bank == 1 and $model->bc_unwilling_bc == 1) ? Html::button('<span class="fa "> Unwilling BC</span>', [
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-danger  btn-block popb',
                                            'value' => '/training/participants/upsrlmunwilling?bcid=' . $model->id,
                                            'title' => 'Unwilling BC  : ' . $model->name
                                        ]) . ' ' : '';
                                    },        
                                ]
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
    $("#search-form").attr({ "action":"/training/certified/cdounwilling"});
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
