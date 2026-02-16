<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use cbo\models\CboClf;

$this->title = "Report";
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
                        'clientOptions' => ['method' => 'GET'],
                    ]);
                    ?>
                    <?php
                    $form = ActiveForm::begin([
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'search-form'
                                ],
                                'id' => 'search-form',
                                'layout' => 'inline',
                                'method' => 'get',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_search', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <div class="row mb-3"></div>
                    <div class="col-xl-12 mt-3">
                        <div class="demo-v-spacing p-2">
                            <h3><span class="badge badge-danger p-2 mr-2">UPSRLM</span><span class="badge badge-success p-2 mr-2">Partner Bank</span><span class="badge badge-info p-2">BC Sakhi</span></h3>
                            
                        </div>
                        <div class="row">

                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-danger-100 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider1))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider1->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Total GPs</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '1']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider3))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider3->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">BCs unblocked certified by IIBF</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '3']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            echo common\helpers\Utility::numberIndiaStyle($dataProvider5a->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">BCs with uploaded PAN photo</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '5a']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider4))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider4->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">SHGs with Certified BC-support fund</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '4']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            echo common\helpers\Utility::numberIndiaStyle($dataProvider8->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">BC Acknowledgement for BC-support funds received</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '8']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>

                        </div> 
                        <div class="row">

                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            echo common\helpers\Utility::numberIndiaStyle($dataProvider7->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Equipment provided to BCs</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '7']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            echo common\helpers\Utility::numberIndiaStyle($dataProvider9->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">BC Acknowledgement for equipment received</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '9']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            echo common\helpers\Utility::numberIndiaStyle($dataProvider6->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">BCs Onboarded</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '6']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider11bc))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider11bc->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">No. of Active BCs started bank transactions</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '11bc']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            
                        </div> 
                        
                     <div class="col-sm-6 col-xl-3 float-right">
                                <div class="p-3 bg-primary-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider4b))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider4b->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">BC Sakhi declared unwilling; BC Support fund NOT repaid</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '4b']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                        <div class="clearfix"></div>  
                    </div>
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $(this).closest('form').submit();
});            
   
JS;
                    $this->registerJs($script);
                    ?>
                    <div class="col-lg-12" ">
                        <?php
                        if (isset($button_type) and $button_type != '') {
                            ?>

                            <?php
                            if ($button_type == "1") {
                                echo $this->render('total_gp', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            } elseif ($button_type == "2") {
                                echo $this->render('bc_shartlisted', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            } elseif ($button_type == "3") {
                                echo $this->render('bc_certified', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            } elseif ($button_type == "3a") {
                                echo $this->render('bc_blocked_certified', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            } elseif ($button_type == "4") {
                                echo $this->render('bc_extended_support_fund', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            }elseif ($button_type == "4b") {
                                echo $this->render('bc_extended_support_fund_not_repaid', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            } elseif ($button_type == "5") {
                                echo $this->render('bc_with_pan', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            } elseif ($button_type == "5a") {
                                echo $this->render('bc_with_pan_upload', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            } elseif ($button_type == "6") {
                                echo $this->render('bc_onboard', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            } elseif ($button_type == "7") {
                                echo $this->render('bd_equipment _provided', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            }
                            ?>

                        <?php }
                        ?>
                    </div> 
                    <?php ActiveForm::end(); ?>
                    <?php Pjax::end(); ?> 
                </div>
                
                <div class="clearfix"></div>  
            </div>
        </div> 
    </div>
</div>

<?php
//$js = <<<JS
//$(function () { 
//    jQuery.noConflict();
//   $('.popb').click(function(){
//        $('#imagecontent').html('');
//        $('#modal').modal('show')
//         .find('#imagecontent')
//         .load($(this).attr('value'));
//         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
//        });
//});  
//        
//JS;
//$this->registerJs($js);
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
$script = <<< JS
    $(function(){
        jQuery.noConflict();
        function init_click_handlers(){
         $('form select').on('change', function(){
    $(this).closest('form').submit();
});    
            $('.popb').click( function () {
                $('#modal').modal('show')
                .find('#imagecontent')
                .load($(this).attr('value'));

            $('#modal').on('shown.bs.modal', function (e) {
                var form =jQuery('#can-form');
                form.on('beforeSubmit', function(e) {
//          alert('rahman');
                    e.preventDefault();
                    jQuery.ajax({
                        url: form.attr('action'),
                            type: form.attr('method'),
                            data: new FormData(form[0]),
                            mimeType: 'multipart/form-data',
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: 'json',
                            success: function (data) {
                                if(data.success === true){
                                    $("#search-form").attr("data-pjax", "True"); 
                                    $('#search-form').submit();
                                    $('#modal').modal('hide');
                                }
                            },
                            error  : function (e)
                            {
                                console.log(e);
                            }   
                    });
                    return false;        
                });
            });
        });
        }

        init_click_handlers(); //first run
       $(document).on('ready pjax:success', function(){
            init_click_handlers(); //reactivate links in grid after pjax update
        });
//        $("#grid-data").on("pjax:success", function() {
//            init_click_handlers(); //reactivate links in grid after pjax update
//        });


        
    });
JS;
$this->registerJs($script);
?>