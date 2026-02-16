<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = "Dashboard: Tagging 194N";
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
                    echo $this->render('_search194n', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <div class="clearfix pt-3"></div>
                    <div class="col-xs-12 pt-3">
                        <div class="row">
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-info-100">
                                        1. BC settlement a/c <b>NOT Tagged</b> for 194N
                                    </div>

                                    <div class="card-body">

                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider1->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?= Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '1']) ?>   
                                            </div>

                                        </div>
                                    </div>  
                                </div>

                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="card">
                                    <div class="card-header bg-info-100">
                                        2. BC settlement a/c <b>Tagged</b> for 194N 
                                    </div>

                                    <div class="card-body">

                                        <div class="row">
                                            <div class="price col-sm-5">
                                                <?php
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider2->query->count());
                                                ?>
                                            </div>
                                            <div class="col-sm-7">
                                                <?= Html::submitButton('More Info <i class="ace-icon fal fa-angle-right bigger-110"></i>', ['class' => 'btn  btn-block btn-info', 'style' => '', 'name' => 'button_type', 'value' => '2']) ?>   
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="col-lg-12 pt-3">
                        <div class="card ">    
                            <div class="card-header <?= \Yii::$app->params['class'] ?>"><i class="fal fa-user"> </i> <?= \Yii::$app->params['title'] ?></div>
                        </div>
                        <div class="card-body">
                            <?php
                            if ($button_type == "1") {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                        [
                                            'attribute' => 'name',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'value' => function ($model) {

                                                $html = '';

                                                return Html::a($model->participant->name, '#', ['value' => '/report/bc/setelmentac194n?bcid=' . $model->participant->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'name_of_bank',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->bc_settlement_account_bank_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'onboarding_date_time',
                                            'format' => 'html',
                                            'header' => 'Onboarding Date',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->onboarding_date_time;
                                            }
                                        ],
                                        [
                                            'attribute' => 'bc_settlement_ac_194n',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'header' => 'BC settlement a/c tagged for 194N',
                                            'value' => function ($model) {
                                                return $model->participant->bc_settlement_ac_194n == '1' ? 'Yes' : 'No';
                                            }
                                        ],
                                        [
                                            'attribute' => 'pendency',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'header' => 'Pendency',
                                            'contentOptions' => ['class' => 'text-danger'],
                                            'value' => function ($model) {
                                                return round((time() - strtotime($model->participant->onboarding_date_time)) / (60 * 60 * 24));
                                            }
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Action',
                                            'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_RBI]),
                                            'template' => '{bc194n}',
                                            'buttons' => [
                                                'bc194n' => function ($url, $model) {
                                                    $html = '';
                                                    if ($model->participant->bc_settlement_ac_194n == 0) {

                                                        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_RBI])) {
                                                            $html .= Html::button('<span class="">BC settlement a/c tagged for 194N</span>', [
                                                                        'data-pjax' => "0",
                                                                        'class' => 'btn  btn-danger popb',
                                                                        'value' => '/report/bc/setelmentac194n?bcid=' . $model->participant->id,
                                                                        'title' => 'BC settlement a/c tagged for 194N of ' . $model->participant->name
                                                            ]);
                                                        }
                                                    }
                                                    return $html;
                                                },
                                            ]
                                        ],
                                    ],
                                ]);
                            } elseif ($button_type == "2") {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
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
                                                if (isset($arr[$model->participant->blocked])) {
                                                    $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                                }
                                                // $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> View Data', ['id' => 'call' . $model->id, 'class' => 'btn  btn-warning btn-block popb', 'value' => '/selection/data/application/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                                                return Html::a($model->participant->name, '#', ['value' => '/report/bc/setelmentac194n?bcid=' . $model->participant->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'name_of_bank',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->bc_settlement_account_bank_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'onboarding_date_time',
                                            'format' => 'html',
                                            'header' => 'Onboarding Date',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->onboarding_date_time;
                                            }
                                        ],
                                        [
                                            'attribute' => 'bc_settlement_ac_194n',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'header' => 'BC settlement a/c tagged for 194N',
                                            'value' => function ($model) {
                                                return $model->participant->bc_settlement_ac_194n == '1' ? 'Yes' : 'No';
                                            }
                                        ],
                                        [
                                            'attribute' => 'pendency',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'header' => 'Pendency',
                                            'contentOptions' => ['class' => 'text-danger'],
                                            'value' => function ($model) {
                                                return round((time() - strtotime($model->participant->onboarding_date_time)) / (60 * 60 * 24));
                                            }
                                        ],
                                    ],
                                ]);
                            } else {

                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                    'id' => 'grid-data',
                                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                    'pjax' => TRUE,
//                                        'floatHeader' => true,
//                                        'floatHeaderOptions' => ['scrollingTop' => '50'],
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
                                                if (isset($arr[$model->participant->blocked])) {
                                                    $html .= '<div class="text-danger">' . $arr[$model->participant->blocked] . '</div>';
                                                }

                                                return Html::a($model->participant->name, '#', ['value' => '/report/bc/setelmentac194n?bcid=' . $model->participant->id, 'data-pjax' => "0", 'title' => $model->participant->name, 'class' => 'popb']) . $html;
                                            }
                                        ],
                                        [
                                            'attribute' => 'district_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->district_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'block_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->block_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'gram_panchayat_name',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->gram_panchayat_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'name_of_bank',
                                            'format' => 'html',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->bc_settlement_account_bank_name;
                                            }
                                        ],
                                        [
                                            'attribute' => 'onboarding_date_time',
                                            'format' => 'html',
                                            'header' => 'Onboarding Date',
                                            'enableSorting' => false,
                                            'value' => function ($model) {
                                                return $model->participant->onboarding_date_time;
                                            }
                                        ],
                                        [
                                            'attribute' => 'bc_settlement_ac_194n',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'header' => 'BC settlement a/c tagged for 194N',
                                            'value' => function ($model) {
                                                return $model->participant->bc_settlement_ac_194n == '1' ? 'Yes' : 'No';
                                            }
                                        ],
                                        [
                                            'attribute' => 'pendency',
                                            'enableSorting' => false,
                                            'format' => 'raw',
                                            'header' => 'Pendency',
                                            'contentOptions' => ['class' => 'text-danger'],
                                            'value' => function ($model) {
                                                return round((time() - strtotime($model->participant->onboarding_date_time)) / (60 * 60 * 24));
                                            }
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Action',
                                            'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_RBI]),
                                            'template' => '{bc194n}',
                                            'buttons' => [
                                                'bc194n' => function ($url, $model) {
                                                    $html = '';
                                                    if ($model->participant->bc_settlement_ac_194n == 0) {

                                                        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_RBI])) {
                                                            $html .= Html::button('<span class="">BC settlement a/c tagged for 194N</span>', [
                                                                        'data-pjax' => "0",
                                                                        'class' => 'btn  btn-danger popb',
                                                                        'value' => '/report/bc/setelmentac194n?bcid=' . $model->participant->id,
                                                                        'title' => 'BC settlement a/c tagged for 194N of ' . $model->participant->name
                                                            ]);
                                                        }
                                                    }
                                                    return $html;
                                                },
                                            ]
                                        ],
                                    ],
                                ]);
                            }
                            ?>
                        </div> 
                    </div>   
                    <?php ActiveForm::end(); ?>
    <?php
                    $js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/report/bc/downloadac194ncsv"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
               
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/report/bc/ac194n"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

                    $this->registerJs($js);
                    ?>                     
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
     $("#Searchform").attr({ "action":"/report/bc/ac194n"});
    $("#search-form").attr("data-pjax", "True");                
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
            $('#search-form').prop('action', href);
            $('#search-form').submit();
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
