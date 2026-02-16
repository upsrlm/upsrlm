<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use miloschuman\highcharts\Highcharts;

$this->title = "Feedback dashboard";
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
                    echo $this->render('_searchreport', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <div class="row mb-3"></div>
                    <div class="col-xl-12 mt-3">
                        <div class="row">
                            <div class="col-xl-12">
                                <div id="panel-6" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <?= ' 1. क्या अबतक मोबाइल ऐप को भरने/ एडिट करने में आपका अनुभव कैसा रहा? ' ?>
                                        </h2>

                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider11))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider11->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>बिलकुल ही आसान है </h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '11']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider12))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider12->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>काफ़ी आसान है </h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '12']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider13))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider13->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>एकबार करने के बाद आसान लगेगा  </h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '11']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider14))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider14->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>मुश्किल लगा </h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '12']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-xl-12">
                                <div id="panel-6" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <?= '2. क्या संकुल के पदाधिकारी एवं लेखाकार में से किसी या सभी के पास टचवाला फ़ोन है?' ?>
                                        </h2>

                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider21))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider21->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>सभी पदाधिकारी और लेखाकार के पास है</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '21']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider22))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider22->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>कुछ  पदाधिकारी और लेखाकार के पास है</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '22']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider23))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider23->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>सिर्फ़ लेखाकार के पास है</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '23']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-xl-12">
                                <div id="panel-6" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <?= '3. अगर किसी के पास टच वाला फ़ोन नहीं हैं तो मोबाइल ऐप का उपयोग कैसे करेंगे' ?>
                                        </h2>

                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-600 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider31))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider31->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>ये बहुत ज़रूरी है, नया फ़ोन ख़रीद लेंगे</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '31']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-600 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider32))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider32->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>संकुल में किसी ना किसी के फ़ोन से कर लेंगे</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '32']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-600 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider33))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider33->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>परिवार में किसी के फ़ोन का उपयोग कर लेंगे</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '33']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-600 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider34))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider34->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>मोबाइल ऐप का उपयोग नहीं कर पाएँगे</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '34']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div id="panel-6" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <?= ' 4. जब ये प्रश्नोत्तर आपके द्वारा भरा जा रहा है, उस समय संकुल के कितने पदाधिकारी/ सदस्य उपस्थित हैं? ' ?>
                                        </h2>

                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-700 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider41))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider41->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>सभी संकुल सदस्य उपस्थित हैं</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '41']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-700 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider42))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider42->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>सभी पदाधिकारी उपस्थित है</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-700 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider43))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider43->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>सभी/ कई पदाधिकारी व लेखाकार उपस्थित हैं</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '43']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-700 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider44))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider44->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>अकेली सदस्य/ पदाधिकारी ने भरा हैं</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '43']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div id="panel-6" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <?= ' 5 आप को संकुल के लेखा सम्बन्धी खाताबही के रखरखाव के लिए कौन सी व्यवस्था ज़्यादा आसान लगती है ? ' ?>
                                        </h2>

                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-sm-6 col-xl-5">
                                                    <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider51))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider51->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>मोबाइल ऐप-आधारित व्यवस्था</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '41']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-5">
                                                    <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider52))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider52->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>रेजिस्टर वाली खाता बही</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div>
                                    </div>
                                </div>
                            </div>                          
                            <div class="col-xl-12">
                                <div id="panel-6" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <?= '6. अगर मोबाइल-ऐप आधारित व्यवस्था हो तो क्यों? ' ?>
                                        </h2>

                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-sm-6 col-xl-2">
                                                    <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider61))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider61->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>मोबाइल-ऐप पर लिखने का कष्ट नहीं रहेगा – सिर्फ़ टच से सही उत्तर चुनना होगा – जैसा अभी हम संकुल के ऐप पर कर रहें हैं ।</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-2">
                                                    <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider62))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider62->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>मोबाइल पर खाता बही का सभी रिकार्ड रखना आसान होगा ।</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-2">
                                                    <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider63))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider63->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>मोबाइल पर कार्य करने सुविधा होने से संकुल के बैठक में लम्बे समय तक रहने की बाध्यता नहीं होगी; समय बचेगा  ।</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-2">
                                                    <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider64))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider64->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>मोबाइल पर खाता बही की सुविधा होने से मिशन मैनेजर/ मिशन के अधिकारियों पर निर्भरता कम होगी – हम स्वयं सक्षम होंगे – बिना किसी के हस्तक्षेप के काम कर पाएँगे ।</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-2">
                                                    <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider65))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider65->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>मोबाइल ऐप पर अंकगणित/ हिसाब करने सुविधाएँ उपलब्ध होंगी – ग़लतियाँ नहीं होगी ।</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-2">
                                                    <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider66))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider66->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>और भी कई सुविधाएँ हो सकती हैं ।</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-xl-12">
                                <div id="panel-6" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <?= ' 7. अगर इस तरह का मोबाइल ऐप लागू होता है तो क्या संकुल के कार्य में समय, ऊर्जा और खर्च बचेगा? ' ?>
                                        </h2>

                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-700 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider71))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider71->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>हाँ, बहुत ज़्यादा</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '41']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-700 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider72))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider72->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>हाँ, काफ़ी हद तक  </h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-700 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider73))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider73->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>कुछ हद तक</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '43']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-3">
                                                    <div class="p-3 bg-info-700 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider74))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider74->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>नहीं</h5>
                                                                    '
                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '43']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div id="panel-6" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <?= ' 8. क्या मोबाइल ऐप के लिए कोई शुल्क निर्धारित होना चाहिए? ' ?>
                                        </h2>

                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-sm-6 col-xl-5">
                                                    <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider81))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider81->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>हाँ </h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '41']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-5">
                                                    <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider82))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider82->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>नहीं </h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <?php if ($searchModel->ques_8 != 2) { ?>
                                <div class="col-xl-12">
                                    <div id="panel-9" class="panel">
                                        <div class="panel-hdr">
                                            <h2>
                                                <?= '9.1. मोबाइल ऐप पर ही इसके संचालन के लिए उपयुक्त दिशा-निर्देश/ गाइडलाइन मिले ।' ?>
                                            </h2>

                                        </div>
                                        <div class="panel-container show">
                                            <div class="panel-content">
                                                <div class="row">
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider91a1))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider91a1->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 5 to 10
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider91a2))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider91a2->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 11 to 25
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider91a3))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider91a3->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 26 to 50
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider91a4))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider91a4->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 51 to 99

                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>


                                                </div>     
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12">
                                    <div id="panel-9" class="panel">
                                        <div class="panel-hdr">
                                            <h2>
                                                <?= '9.2. राज्य मिशन से मिलने वाली सभी सुविधाओं की सूचना सरल हिंदी में मोबाइल ऐप पर ही प्राप्त हो ।' ?>
                                            </h2>

                                        </div>
                                        <div class="panel-container show">
                                            <div class="panel-content">
                                                <div class="row">
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider92a1))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider92a1->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 5 to 10
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider92a2))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider92a2->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 11 to 25
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider92a3))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider92a3->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 26 to 50
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider92a4))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider92a4->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 51 to 99

                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>


                                                </div>     
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12">
                                    <div id="panel-9" class="panel">
                                        <div class="panel-hdr">
                                            <h2>
                                                <?= '9.3. मोबाइल ऐप पर संकुल के खाता बही रखरखाव सम्बन्धी कार्य किया जा सके – रजिस्टर पर कार्य करने की आवश्यकता ना हो ।' ?>
                                            </h2>

                                        </div>
                                        <div class="panel-container show">
                                            <div class="panel-content">
                                                <div class="row">
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider93a1))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider93a1->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 5 to 10
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider93a2))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider93a2->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 11 to 25
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider93a3))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider93a3->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 26 to 50
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider93a4))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider93a4->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 51 to 99

                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>


                                                </div>     
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12">
                                    <div id="panel-9" class="panel">
                                        <div class="panel-hdr">
                                            <h2>
                                                <?= '9.4. संकुल (CLF), ग्राम संगठन (VO), एवं समूह (SHG) स्तर पर ऋण के लेनदेन की पूरी रिकार्ड रखा जा सके । माहवार मूलधन व ब्याज सहित ऋण वापसी (EMI) की जानकारी मिले ।' ?>
                                            </h2>

                                        </div>
                                        <div class="panel-container show">
                                            <div class="panel-content">
                                                <div class="row">
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider94a1))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider94a1->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 5 to 10
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider94a2))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider94a2->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 11 to 25
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider94a3))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider94a3->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 26 to 50
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider94a4))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider94a4->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 51 to 99

                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>


                                                </div>     
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12">
                                    <div id="panel-9" class="panel">
                                        <div class="panel-hdr">
                                            <h2>
                                                <?= '9.5. ऋण का भुगतान एवं ऋण वापसी की जानकारी का मैसज, ऋण देने व ऋण प्राप्त करने वाले दोनो को, मोबाइल ऐप पर ही मिले ।' ?>
                                            </h2>

                                        </div>
                                        <div class="panel-container show">
                                            <div class="panel-content">
                                                <div class="row">
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider95a1))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider95a1->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 5 to 10
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider95a2))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider95a2->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 11 to 25
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider95a3))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider95a3->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 26 to 50
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider95a4))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider95a4->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 51 to 99

                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>


                                                </div>     
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12">
                                    <div id="panel-9" class="panel">
                                        <div class="panel-hdr">
                                            <h2>
                                                <?= '9.6. संकुल के खाताबही एवं अन्य सभी रिकार्ड का प्रिंट निकालने की सुविधा हो ।' ?>
                                            </h2>

                                        </div>
                                        <div class="panel-container show">
                                            <div class="panel-content">
                                                <div class="row">
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider96a1))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider96a1->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 5 to 10
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider96a2))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider96a2->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 11 to 25
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider96a3))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider96a3->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 26 to 50
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider96a4))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider96a4->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 51 to 99

                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>


                                                </div>     
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12">
                                    <div id="panel-9" class="panel">
                                        <div class="panel-hdr">
                                            <h2>
                                                <?= '9.7. वित्तीय एवं डिजिटल साक्षरता सम्बन्धी सभी उपयोगी जानकारी उपलब्ध हो । प्रिंट निकालने की सुविधा हो ।' ?>
                                            </h2>

                                        </div>
                                        <div class="panel-container show">
                                            <div class="panel-content">
                                                <div class="row">
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider97a1))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider97a1->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 5 to 10
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider97a2))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider97a2->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 11 to 25
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider97a3))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider97a3->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 26 to 50
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider97a4))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider97a4->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 51 to 99

                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>


                                                </div>     
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12">
                                    <div id="panel-9" class="panel">
                                        <div class="panel-hdr">
                                            <h2>
                                                <?= '9.8. मोबाइल ऐप प्रयोग करने पर अगर कोई शुल्क निर्धारित हो रहा हो तो उनका बिल एवं शुल्क भुगतान की रसीद ऐप पर ही मिले – ज़रूरत हो तो प्रिंट निकाला जा सके  ।' ?>
                                            </h2>

                                        </div>
                                        <div class="panel-container show">
                                            <div class="panel-content">
                                                <div class="row">
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider98a1))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider98a1->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 5 to 10
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider98a2))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider98a2->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 11 to 25
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider98a3))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider98a3->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 26 to 50
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider98a4))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider98a4->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 51 to 99

                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>


                                                </div>     
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12">
                                    <div id="panel-9" class="panel">
                                        <div class="panel-hdr">
                                            <h2>
                                                <?= '9.9. मोबाइल ऐप के उपयोग में असुविधा हो तों तत्काल मदद के लिए हेल्पलाइन की सुविधा हो ।' ?>
                                            </h2>

                                        </div>
                                        <div class="panel-container show">
                                            <div class="panel-content">
                                                <div class="row">
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider99a1))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider99a1->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 5 to 10
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider99a2))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider99a2->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 11 to 25
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider99a3))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider99a3->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 26 to 50
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider99a4))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider99a4->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        Rs. 51 to 99

                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>


                                                </div>     
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-12">
                                    <div id="panel-9" class="panel">
                                        <div class="panel-hdr">
                                            <h2>
                                                <?= '9. अगर हाँ, तो निम्न में से कौन से तीन प्रमुख सुविधा/ सेवाएँ ज़रूर मिलना चाहिए ' ?>
                                            </h2>

                                        </div>
                                        <div class="panel-container show">
                                            <div class="panel-content">
                                                <div class="row">
                                                    <div class="col-sm-6 col-xl-2">
                                                        <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider91))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider91->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        9.1. मोबाइल ऐप पर ही इसके संचालन के लिए उपयुक्त दिशा-निर्देश/ गाइडलाइन मिले ।
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-2">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider92))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider92->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        9.2. राज्य मिशन से मिलने वाली सभी सुविधाओं की सूचना सरल हिंदी में मोबाइल ऐप पर ही प्राप्त हो ।
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-2">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider93))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider93->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        9.3. मोबाइल ऐप पर संकुल के खाता बही रखरखाव सम्बन्धी कार्य किया जा सके – रजिस्टर पर कार्य करने की आवश्यकता ना हो ।
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-2">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider94))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider94->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        9.4. संकुल (CLF), ग्राम संगठन (VO), एवं समूह (SHG) स्तर पर ऋण के लेनदेन की पूरी रिकार्ड रखा जा सके । माहवार मूलधन व ब्याज सहित ऋण वापसी (EMI) की जानकारी मिले ।
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-2">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider95))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider95->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        9.5. ऋण का भुगतान एवं ऋण वापसी की जानकारी का मैसज, ऋण देने व ऋण प्राप्त करने वाले दोनो को, मोबाइल ऐप पर ही मिले ।
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-2">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider96))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider96->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        9.6. संकुल के खाताबही एवं अन्य सभी रिकार्ड का प्रिंट निकालने की सुविधा हो  ।
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider96))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider96->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        9.6. संकुल के खाताबही एवं अन्य सभी रिकार्ड का प्रिंट निकालने की सुविधा हो ।
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider97))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider97->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        9.7. वित्तीय एवं डिजिटल साक्षरता सम्बन्धी सभी उपयोगी जानकारी उपलब्ध हो । प्रिंट निकालने की सुविधा हो ।
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider98))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider98->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        9.8. मोबाइल ऐप प्रयोग करने पर अगर कोई शुल्क निर्धारित हो रहा हो तो उनका बिल एवं शुल्क भुगतान की रसीद ऐप पर ही मिले – ज़रूरत हो तो प्रिंट निकाला जा सके  ।
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div class="p-3 bg-info-800 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    <?php
                                                                    if (isset($dataProvider99))
                                                                        echo common\helpers\Utility::numberIndiaStyle($dataProvider99->query->count());
                                                                    ?>
                                                                    <small class="m-0 l-h-n">
                                                                        9.9. मोबाइल ऐप के उपयोग में असुविधा हो तों तत्काल मदद के लिए हेल्पलाइन की सुविधा हो  ।
                                                                    </small>
                                                                    <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                </div>     
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            <?php } ?>                        
                            <div class="col-xl-12">
                                <div id="panel-6" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <?= '10. आपने सभी प्रश्नों का जवाब कैसे भरा ' ?>
                                        </h2>

                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider101))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider101->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>स्वयं सोचकर </h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '21']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider102))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider102->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>संकुल पदाधिकारियों से चर्चा की </h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '22']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php
                                                                if (isset($dataProvider103))
                                                                    echo common\helpers\Utility::numberIndiaStyle($dataProvider103->query->count());
                                                                ?>
                                                                <small class="m-0 l-h-n">
                                                                    <h5>सिर्फ़ लेखाकार के पास है</h5>

                                                                </small>
                                                                <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn btn-sm btn-danger ', 'name' => 'button_type', 'value' => '23']) ?>   
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div>
                                    </div>
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


                    <?php ActiveForm::end(); ?>
                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div> 
    </div>
</div>


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
