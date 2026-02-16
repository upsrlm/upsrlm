<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

//$this->title = "Dashboard";
//$this->params['breadcrumbs'][] = $this->title;
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
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-3"></div>
                    <div class="row">
                        <div class="col-sm-6 col-xl-3">
                            <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                        <?php
                                        if (isset($dataProvidergp))
                                            echo common\helpers\Utility::numberIndiaStyle($dataProvidergp->query->count());
                                        ?>
                                        <small class="m-0 l-h-n"> 1. Total no. of GPs</small>
                                        <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '1']) ?>   
                                    </h3>
                                </div>
                                <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                        <?php
                                        if (isset($dataProvider))
                                            echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->count());
                                        ?>
                                        <small class="m-0 l-h-n"> 2. No. of BCs shortlisted</small>
                                        <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '2']) ?>   
                                    </h3>
                                </div>
                                <i class="fal fa-users position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                        <?php
                                        if (isset($dataProvidera))
                                            echo common\helpers\Utility::numberIndiaStyle($dataProvidera->query->count());
                                        ?>
                                        <small class="m-0 l-h-n"> 2a. No. of BCs shortlisted after GP update</small>
                                        <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '2a']) ?>   
                                    </h3>
                                </div>
                                <i class="fal fa-users position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                        <?php
                                        if (isset($dataProvidera))
                                            echo \common\helpers\Utility::numberIndiaStyle($dataProvider->query->count() - $dataProvidera->query->count());
                                        ?>
                                        <small class="m-0 l-h-n"> 2b. No. of BCs shortlisted difference</small>
                                        <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '2b']) ?>   
                                    </h3>
                                </div>
                                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-white mb-g">
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                        <?php
                                        if (isset($dataProvider3))
                                            echo common\helpers\Utility::numberIndiaStyle($dataProvider3->query->count()) . ' / ' . round($batch_size);
                                        ?>
                                        <small class="m-0 l-h-n">3. Batches formed/ batch size</small>
                                        <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger', 'name' => 'button_type', 'value' => '3']) ?>
                                    </h3>
                                </div>

                                <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-white mb-g">
                            
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                        <?php
                                        if (isset($dataProvider1))
                                            echo \common\helpers\Utility::numberIndiaStyle($dataProvider1->query->count());
                                        ?>
                                        <small class="m-0 l-h-n"> 4. Appeared IIBF exam</small>
                                        <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '2b']) ?>   
                                    </h3>
                                </div>
                                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-white mb-g">
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                        <?php
                                        if (isset($dataProvider2))
                                            echo \common\helpers\Utility::numberIndiaStyle($dataProvider2->query->count());
                                        ?>
                                        <small class="m-0 l-h-n"> 5. IIBF certified</small>
                                        <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '2b']) ?>   
                                    </h3>
                                </div>
                                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-white mb-g">
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                        <?php
                                        if (isset($dataProvideribf))
                                            echo common\helpers\Utility::numberIndiaStyle($dataProvideribf->query->count());
                                        ?>
                                        <small class="m-0 l-h-n">6. IIBF Photo Uploaded</small>
                                        <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger', 'name' => 'button_type', 'value' => '7']) ?>
                                    </h3>
                                </div>
                                <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-sm-6 col-xl-3">
                            <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                                <div class="">
                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                        <?php
                                        if (isset($dataProviderpen))
                                            echo common\helpers\Utility::numberIndiaStyle($dataProviderpen->query->count());
                                        ?>
                                        <small class="m-0 l-h-n">Total participants left to be trained</small>
                                        <?php // Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger', 'name' => 'button_type', 'value' => '1']) ?>   
                                    </h3>
                                </div>
                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger', 'name' => 'button_type', 'value' => '1']) ?>   
                                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr("data-pjax", "True");                
    $(this).closest('form').submit();
});            
    
JS;
                    $this->registerJs($script);
                    ?>

                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div>    
    </div>
</div> 