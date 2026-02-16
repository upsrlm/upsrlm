<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
use yii\bootstrap4\ActiveForm;

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
                    <?php if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DC_NRLM])) { ?>
                        <?= Html::a('Upload Saree distribution CSV file', ['upload'], ['class' => 'btn btn-success']) ?>
                    <?php } ?>
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
                                        ['content' => 'Second Saree', 'options' => ['colspan' => 4, 'class' => 'text-center bg-info-50']],
                                        ['content' => '', 'options' => ['class' => 'text-center warning']],
                                    ],
                                ]
                            ],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                                [
                                    'attribute' => 'name',
                                    'header' => 'BC Name / Mobile No <br/>BC District / BC Block/ BC GP',
                                    'enableSorting' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        $arr = [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH => "SHG GP change", SrlmBcApplication::BLOCKED_STATUS_URBAN => "GP Convert Urban", SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY => "Education eligibility", SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED => "Mobile No. inused", SrlmBcApplication::BLOCKED_STATUS_BC_GP => "GP Mismatch", SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY => "Age eligibility", SrlmBcApplication::BLOCKED_STATUS_PFMS => "PFMS without bank verification", SrlmBcApplication::BLOCKED_STATUS_AADHAR => "Aadhar duplicacy"];
                                        $html = '';
                                        if (isset($arr[$model->blocked])) {
                                            $html .= '<div class="text-danger">' . $arr[$model->blocked] . '</div>';
                                        }
                                        return $model->name . ' / ' . common\helpers\Utility::mask($model->mobile_no) . $html . '<br/>' . $model->district_name . ' /' . $model->block_name . ' /' . $model->gram_panchayat_name;
                                    }
                                ],
                                [
                                    'attribute' => 'saree1_provided',
                                    'header' => 'Provided',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-warning-50'],
                                    'value' => function ($model) {
                                        return isset($model->bcsaree->saree1_provided) ? 'Yes' : '';
                                    }
                                ],
                                [
                                    'attribute' => 'saree1_provided_date',
                                    'header' => 'Provided date',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-warning-50'],
                                    'value' => function ($model) {
                                        return isset($model->bcsaree->saree1_provided_date) ? $model->bcsaree->saree1_provided_date : '';
                                    }
                                ],
                                [
                                    'attribute' => 'saree1_ack',
                                    'header' => 'Ack',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-warning-50'],
                                    'value' => function ($model) {
                                        return isset($model->bcsaree->saree1_acknowledge) ? 'Yes' : '';
                                    }
                                ],
                                [
                                    'attribute' => 'saree1_ack',
                                    'header' => 'प्राप्त की',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-warning-50'],
                                    'value' => function ($model) {
                                        $html = '';
                                        if (isset($model->bcsaree->saree1_acknowledge) and $model->bcsaree->saree1_acknowledge == 1) {
                                            $html = 'Yes';
                                        }
                                        if (isset($model->bcsaree->saree1_acknowledge) and $model->bcsaree->saree1_acknowledge == 2) {
                                            $html = '<span class="color-danger-900">No</span>';
                                        }
                                        return $html;
                                    }
                                ],
                                [
                                    'attribute' => 'saree2_provided',
                                    'header' => 'Provided',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-info-50'],
                                    'value' => function ($model) {
                                        return isset($model->bcsaree->saree2_provided) ? 'Yes' : '';
                                    }
                                ],
                                [
                                    'attribute' => 'saree2_provided_date',
                                    'header' => 'Provided date',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-info-50'],
                                    'value' => function ($model) {
                                        return isset($model->bcsaree->saree2_provided_date) ? $model->bcsaree->saree2_provided_date : '';
                                    }
                                ],
                                [
                                    'attribute' => 'saree2_ack',
                                    'header' => 'Ack',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-info-50'],
                                    'value' => function ($model) {
                                        return isset($model->bcsaree->saree2_acknowledge) ? 'Yes' : '';
                                    }
                                ],
                                [
                                    'attribute' => 'saree2_ack',
                                    'header' => 'प्राप्त की',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'headerOptions' => ['class' => 'bg-info-50'],
                                    'value' => function ($model) {
                                        $html = '';
                                        if (isset($model->bcsaree->saree2_acknowledge) and $model->bcsaree->saree2_acknowledge == 1) {
                                            $html = 'Yes';
                                        }
                                        if (isset($model->bcsaree->saree2_acknowledge) and $model->bcsaree->saree2_acknowledge == 2) {
                                            $html = '<span class="color-danger-900">No</span>';
                                        }
                                        return $html;
                                    }
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Action',
                                    'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM]),
                                    'template' => '{bcsaree}',
                                    'buttons' => [
                                        'bcsaree' => function ($url, $model) {
                                            return ($model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS and $model->urban_shg == '0' and $model->blocked == '0' and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DC_NRLM])) ? Html::a('<span class="fal fa fa-exchange"></span> Reset', ['/training/saree/resetmenu', 'userid' => $model->user_id], [
                                                'title' => 'Reset',
                                                'data-pjax' => "0",
                                                'class' => 'btn btn-sm btn-info',
                                                'data-confirm' => 'Are you sure you want to reset App of this user?',
                                                'data-method' => 'POST',
                                            ]) . ' ' : '';
                                        },
                                    ]
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Action',
                                    'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DC_NRLM]),
                                    'template' => '{bcsaree}',
                                    'buttons' => [
                                        'bcsaree' => function ($url, $model) {
                                            return ($model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS and $model->urban_shg == '0' and $model->blocked == '0' and $model->user_id and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DC_NRLM])) ? Html::button('BC Saree', [
                                                'data-pjax' => "0",
                                                'class' => 'btn   btn-info popb',
                                                'value' => '/training/saree/provided?bcid=' . $model->id,
                                                'title' => 'Provided Saree to  : ' . $model->name
                                            ]) . ' ' : '';
                                        },
                                    ]
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Action',
                                    'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]),
                                    'template' => '{bcsareeview}',
                                    'buttons' => [
                                        'bcsareeview' => function ($url, $model) {
                                            return (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_SUPPORT_UNIT, MasterRole::ROLE_MD])) ? Html::button('View', [
                                                'data-pjax' => "0",
                                                'class' => 'btn btn-info popb',
                                                'value' => '/training/saree/view?bcid=' . $model->id,
                                                'title' => 'Provided Saree to  : ' . $model->name
                                            ]) . ' ' : '';
                                        },
                                    ]
                                ],
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
