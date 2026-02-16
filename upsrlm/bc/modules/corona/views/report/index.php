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

$this->title = "Corona dashboard";
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
                        <div class="row">
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider11))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider11->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है (अगर हाँ )<br/>&nbsp;&nbsp; </small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '11']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider12))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider12->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है (अगर नहीं )<br/>&nbsp;&nbsp;</small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '12']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider21))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider21->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">लगभग 10% <br/>क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है (अगर हाँ ) </small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '21']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider22))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider22->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">लगभग 25% <br/>क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है (अगर हाँ )</small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '22']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider23))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider23->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">लगभग 50%<br/>क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है (अगर हाँ )</small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '23']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider24))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider24->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">लगभग 90%<br/>क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है (अगर हाँ )</small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '24']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-600 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider31))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider31->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">पिछले एक दो महीने में गाँव/ ग्रा0प0 में कितने लोगों की मृत्यु हुई है ? (कोई नहीं)</small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '31']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-600 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider32))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider32->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">पिछले एक दो महीने में गाँव/ ग्रा0प0 में कितने लोगों की मृत्यु हुई है ? (5 से कम)</small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '32']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-600 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider33))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider33->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">पिछले एक दो महीने में गाँव/ ग्रा0प0 में कितने लोगों की मृत्यु हुई है ? (5 से 10)</small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '33']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-600 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider34))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider34->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">पिछले एक दो महीने में गाँव/ ग्रा0प0 में कितने लोगों की मृत्यु हुई है ? (10 से 25)</small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '34']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-600 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider35))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider35->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">पिछले एक दो महीने में गाँव/ ग्रा0प0 में कितने लोगों की मृत्यु हुई है ? (25 से ज़्यादा)</small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '35']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider41))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider41->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">पिछले कुछ दिनों में गाँव में इस तरह के बीमारियों की गम्भीरता कैसी है ? (कम हो रहा है)</small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '41']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider42))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider42->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">पिछले कुछ दिनों में गाँव में इस तरह के बीमारियों की गम्भीरता कैसी है ? (स्थिति यथापूर्व है)</small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '42']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-2">
                                <div class="p-3 bg-info-900 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider43))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider43->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">पिछले कुछ दिनों में गाँव में इस तरह के बीमारियों की गम्भीरता कैसी है ? (बढ़ रहा है)</small>
                                            <?php Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '43']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
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
