<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

$this->title = "CST SMS Detail";
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
                    echo $this->render('_searchcst', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <div class="mb-3"></div>
                    <div class="col-xl-12 mt-3">
                        <div class="row">
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider1))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider1->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Total CST Member</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '1']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider2))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider2->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Total APP LINK SMS Send</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '2']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-sms position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider3))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider3->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Total CST Member Acknowledge</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '3']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider4))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider4->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Total PIN SMS Send</small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '4']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-sms position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider5))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider5->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Total CST Member Acknowledge Install App </small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '5']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-download position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider6))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider6->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">Total CST Member Install App </small>
                                            <?php echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '6']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-download position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>

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
                            if ($button_type == "1") {
                                echo $this->render('total_cst_member', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            }if ($button_type == "2") {
                                echo $this->render('total_cst_member_send_app', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            } elseif ($button_type == "3") {
                                echo $this->render('total_cst_member_ack', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            } elseif ($button_type == "4") {
                                echo $this->render('total_cst_member_send_pin', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            } elseif ($button_type == "5") {
                                echo $this->render('total_install', ['searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'button_type' => $button_type,
                                    'form' => $form
                                ]);
                            }elseif ($button_type == "6") {
                                echo $this->render('total_install_all', ['searchModel' => $searchModel,
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
            </div>
        </div> 
    </div>
</div>



