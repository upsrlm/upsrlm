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
                    <?= 'User' ?>
                </h2>
                <div class="panel-toolbar">

                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
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

                    <div class="mb-3"></div>
                    <div class="col-xl-12 mt-3">
                        <div class="row">
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider1))
                                            //echo common\helpers\Utility::numberIndiaStyle($dataProvider1->query->count());
                                                echo common\helpers\Utility::numberIndiaStyle(22053);
                                            ?>
                                            <small class="m-0 l-h-n">Supply side users</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '1']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider2))
                                            //echo common\helpers\Utility::numberIndiaStyle($dataProvider2->query->count());
                                                echo common\helpers\Utility::numberIndiaStyle(418051);
//                                                echo common\helpers\Utility::numberIndiaStyle(359367);
                                            ?>
                                            <small class="m-0 l-h-n">Demand side users</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '2']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <!--                            <div class="col-sm-6 col-xl-3">
                                                            <div class="p-3 bg-info-300 rounded overflow-hidden position-relative text-white mb-g">
                                                                <div class="">
                                                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <?php
                            if (isset($dataProvider3))
                                echo common\helpers\Utility::numberIndiaStyle($dataProvider3->query->count());
                            ?>
                                                                        <small class="m-0 l-h-n">No. of page reviews</small>
                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '3']) ?>   
                                                                    </h3>
                                                                </div>
                                                                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-xl-3">
                                                            <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                                                <div class="">
                                                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <?php
                            if (isset($dataProvider4))
                                echo common\helpers\Utility::numberIndiaStyle($dataProvider4->query->count());
                            ?>
                                                                        <small class="m-0 l-h-n">page 1</small>
                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '4']) ?>   
                                                                    </h3>
                                                                </div>
                                                                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-xl-2">
                                                            <div class="p-3 bg-info-500 rounded overflow-hidden position-relative text-white mb-g">
                                                                <div class="">
                                                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <?php
                            if (isset($dataProvider5))
                                echo common\helpers\Utility::numberIndiaStyle($dataProvider5->query->count());
                            ?>
                                                                        <small class="m-0 l-h-n">page 2</small>
                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '5']) ?>   
                                                                    </h3>
                                                                </div>
                                                                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                            </div>
                                                        </div>-->
                        </div>

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
//                            if ($button_type == "1") {
//                                echo $this->render('total_mission_cadre', ['searchModel' => $searchModel,
//                                    'dataProvider' => $dataProvider,
//                                    'button_type' => $button_type,
//                                    'form' => $form
//                                ]);
//                            } elseif ($button_type == "2") {
//                                echo $this->render('complete_profile', ['searchModel' => $searchModel,
//                                    'dataProvider' => $dataProvider,
//                                    'button_type' => $button_type,
//                                    'form' => $form
//                                ]);
//                            } elseif ($button_type == "3") {
//                                echo $this->render('incomplete_profile', ['searchModel' => $searchModel,
//                                    'dataProvider' => $dataProvider,
//                                    'button_type' => $button_type,
//                                    'form' => $form
//                                ]);
//                            } elseif ($button_type == "4") {
//                                echo $this->render('verified_profile', ['searchModel' => $searchModel,
//                                    'dataProvider' => $dataProvider,
//                                    'button_type' => $button_type,
//                                    'form' => $form
//                                ]);
//                            } elseif ($button_type == "5") {
//                                echo $this->render('unverified_profile', ['searchModel' => $searchModel,
//                                    'dataProvider' => $dataProvider,
//                                    'button_type' => $button_type,
//                                    'form' => $form
//                                ]);
//                            }
                            ?>

                        <?php }
                        ?>
                    </div> 
                    <?php ActiveForm::end(); ?>
                </div>
                <?php Pjax::end(); ?> 
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-2" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'BC' ?>
                </h2>
                <div class="panel-toolbar">

                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="col-xl-12 mt-3">
                        <div class="row">
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            2,54,710                                            <small class="m-0 l-h-n">BC Identified</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            83,829                                            <small class="m-0 l-h-n">No. of BCs shortlisted</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            82,920                                            <small class="m-0 l-h-n">No. of BCs shortlisted after GP update</small>
                                           
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            45,501                                            <small class="m-0 l-h-n">BCs certified by IIBF</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-500 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            42,309                                            <small class="m-0 l-h-n">BCs with uploaded PAN photo</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-600 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            38,765                                            <small class="m-0 l-h-n">SHGs with BC-support fund</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-700 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            35,279                                            <small class="m-0 l-h-n">BC Acknowledgement for BC-support funds received</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-700 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            32,610                                            <small class="m-0 l-h-n">Equipment provided to BCs</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-700 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            31,921                                            <small class="m-0 l-h-n">BC Acknowledgement for equipment received</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            24,147                                            <small class="m-0 l-h-n">1st instance of Honorarium payment to BCs</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            23,855                                            <small class="m-0 l-h-n">2nd instance of Honorarium payment to BCs</small>
                                           
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            23,852                                            <small class="m-0 l-h-n">3rd instance of Honorarium payment to BCs</small>
                                            
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            18,652                                            <small class="m-0 l-h-n">4rth instance of Honorarium payment to BCs</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            17,831                                            <small class="m-0 l-h-n">5th instance of Honorarium payment to BCs</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            17,291                                            <small class="m-0 l-h-n">6th instance of Honorarium payment to BCs</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            0                                            <small class="m-0 l-h-n">Provided Ist Saree to BCs</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-800 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            0                                            <small class="m-0 l-h-n">Provided 2nd Saree  to BCs</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-900 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            32,499                                            <small class="m-0 l-h-n">BCs Onboarded</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-900 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            32,543                                            <small class="m-0 l-h-n">Mapping of BC with Bank/FI</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-900 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            28,690                                            <small class="m-0 l-h-n">BCs operational</small>

                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                        </div> 
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>