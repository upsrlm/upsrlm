<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
use yii\bootstrap4\Modal;

$this->title = "BCs Saree";
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

                    <?php
                    $form = ActiveForm::begin([
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'Searchform'
                                ],
                                'id' => 'Searchform',
                                'layout' => 'inline',
                                'method' => 'get',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_search', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    //echo $button_type;
                    ?>
                    <div class="col-xl-12 mt-3">
                        <div class="row">
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider1))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider1->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">1st Provided</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '1', 'id' => 'searchbtn1']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider3))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider3->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">1st Ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '3', 'id' => 'searchbtn3']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-danger-200 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider5))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider5->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Ist Not Ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '5', 'id' => 'searchbtn5']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider7))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider7->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Ist प्राप्त की</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '7', 'id' => 'searchbtn7']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider8))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider8->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Ist प्राप्त नहीं की</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '8', 'id' => 'searchbtn8']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider2))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider2->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">2nd Provided</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '2', 'id' => 'searchbtn2']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa fa-volume-up position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>-->
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider4))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider4->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">2nd Ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '4', 'id' => 'searchbtn4']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-danger-200 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider6))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider6->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">2nd Not Ack</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '6', 'id' => 'searchbtn6']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>


                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider9))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider9->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">2nd प्राप्त की</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '9', 'id' => 'searchbtn9']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider10))
                                                echo '' . common\helpers\Utility::numberIndiaStyle($dataProvider10->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">2nd प्राप्त नहीं की</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '10', 'id' => 'searchbtn10']) ?>   
                                        </h3>
                                    </div>
<!--                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>-->
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="clearfix pt-3"></div>
                    <div class="col-xl-12">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                            'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                            'id' => 'grid-data',
                            'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                            'beforeHeader' => [
                                [
                                    'columns' => [
                                        ['content' => '', 'options' => ['class' => 'text-center warning']],
                                        ['content' => '', 'options' => ['class' => 'text-center warning']],
                                        ['content' => 'First Saree', 'options' => ['colspan' => 4, 'class' => 'text-center bg-warning-50']],
                                        ['content' => 'Second Saree', 'options' => ['colspan' => 4, 'class' => 'text-center bg-warning-100']],
                                        ['content' => '', 'options' => ['class' => 'text-center warning']],
                                    ],
                                ]
                            ],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                                [
                                    'attribute' => 'name',
                                    'header' => 'BC Name / Mobile No<br/>BC District / BC Block/ BC GP',
                                    'enableSorting' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                        $html = '';
                                        if (isset($arr[$model->bc->blocked])) {
                                            $html .= '<div class="text-danger">' . $arr[$model->bc->blocked] . '</div>';
                                        }
                                        return $model->bc->name . ' / ' . $model->bc->mobile_no . $html . '<br/>' . $model->bc->district_name . ' /' . $model->bc->block_name . ' /' . $model->bc->gram_panchayat_name;
                                    }
                                ],
                                [
                                    'attribute' => 'saree1_provided',
                                    'header' => 'First Saree Provided',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return isset($model->saree1_provided) ? 'Yes' : '';
                                    }
                                ],
                                [
                                    'attribute' => 'saree1_provided_date',
                                    'header' => 'First Saree Provided date',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return isset($model->saree1_provided_date) ? $model->saree1_provided_date : '';
                                    }
                                ],
                                [
                                    'attribute' => 'saree1_ack',
                                    'header' => 'Ack',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return isset($model->saree1_acknowledge) ? 'Yes' : '';
                                    }
                                ],
                                [
                                    'attribute' => 'saree1_ack',
                                    'header' => 'प्राप्त की',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        $html = '';
                                        if (isset($model->saree1_acknowledge) and $model->saree1_acknowledge == 1) {
                                            $html = 'Yes';
                                        }
                                        if (isset($model->saree1_acknowledge) and $model->saree1_acknowledge == 2) {
                                            $html = 'No';
                                        }
                                        return $html;
                                    }
                                ],
                                [
                                    'attribute' => 'saree2_provided',
                                    'header' => 'Second Saree Provided',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return isset($model->saree2_provided) ? 'Yes' : '';
                                    }
                                ],
                                [
                                    'attribute' => 'saree2_provided_date',
                                    'header' => 'Second Saree Provided date',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return isset($model->saree2_provided_date) ? $model->saree2_provided_date : '';
                                    }
                                ],
                                [
                                    'attribute' => 'saree2_ack',
                                    'header' => 'Ack',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return isset($model->saree2_acknowledge) ? 'Yes' : '';
                                    }
                                ],
                                [
                                    'attribute' => 'saree2_ack',
                                    'header' => 'प्राप्त की',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        $html = '';
                                        if (isset($model->saree2_acknowledge) and $model->saree2_acknowledge == 1) {
                                            $html = 'Yes';
                                        }
                                        if (isset($model->saree2_acknowledge) and $model->saree2_acknowledge == 2) {
                                            $html = 'No';
                                        }
                                        return $html;
                                    }
                                ],
                               [
                                    'attribute' => 'Action',
                                    'label' => 'ऐक्शन 1',
                                    'format' => 'raw',
                                    'enableSorting' => false,
                                    'visible' => \Yii::$app->params['airphone_call'] and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE]),
                                    'value' => function ($model) {

                                        return $model->bc->callaction;
                                    }
                                ],         
//                                [
//                                    'class' => 'yii\grid\ActionColumn',
//                                    'header' => 'Action',
//                                    'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
//                                    'template' => '{bcsaree}',
//                                    'buttons' => [
//                                        'bcsaree' => function ($url, $model) {
//                                            return (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_SUPPORT_UNIT, MasterRole::ROLE_MD])) ? Html::button('View', [
//                                                'data-pjax' => "0",
//                                                'class' => 'btn btn-info popb',
//                                                'value' => '/bc/saree/view?bcid=' . $model->bc->id,
//                                                'title' => 'Provided Saree to  : ' . $model->bc->name
//                                            ]) . ' ' : '';
//                                        },
//                                    ]
//                                ],
                            ],
                        ]);
                        ?>  
                    </div>     
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
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
                    <?php ActiveForm::end(); ?> 
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