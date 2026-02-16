<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\bootstrap4\Modal;
use yii\grid\GridView;
use kartik\popover\PopoverX;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

/* @var $this yii\web\View */
/* @var $model app\models\nfsa\NfsaBaseSurvey */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $model->name ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="panel-2" class="panel">
                                <div class="panel-hdr">
                                    <h2>
                                        <?= 'First Saree' ?>
                                    </h2>

                                </div>
                                <div class="panel-container show">
                                    <div class="panel-content">


                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'saree1_provided',
                                                    'label' => 'Provided',
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->saree1_provided) ? 'Yes' : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'saree1_provided_date',
                                                    'label' => 'Provided date',
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->saree1_provided_date) ? $model->bcsaree->saree1_provided_date : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'saree1_acknowledge',
                                                    'label' => 'बीसी सखी यूनिफ़ॉर्म साड़ी 1 प्राप्त की',
                                                    'visible'=> isset($model->bcsaree->saree1_acknowledge),
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return (isset($model->bcsaree->saree1_acknowledge)) ? $model->bcsaree->saree1_ack : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree1_date',
                                                    'label' => 'प्राप्त दिनांक',
                                                    'format' => 'html',
                                                    'visible'=> (isset($model->bcsaree->saree1_acknowledge) and $model->bcsaree->saree1_acknowledge==1),
                                                    'value' => function ($model) {
                                                        return (isset($model->bcsaree->saree1_acknowledge) and $model->bcsaree->saree1_acknowledge==1) ? $model->bcsaree->get_saree1_date : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree1_packed_new',
                                                    'label' => 'सही ढंग से पैक किया हुआ नया साड़ी मिला',
                                                    'format' => 'html',
                                                    'visible'=> (isset($model->bcsaree->saree1_acknowledge) and $model->bcsaree->saree1_acknowledge==1),
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree1_packed_new) ? $model->bcsaree->saree1_packed_new : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree1_quality',
                                                    'label' => 'क्या साड़ी की क्वालिटी अच्छी है?',
                                                    'format' => 'html',
                                                    'visible'=> (isset($model->bcsaree->saree1_acknowledge) and $model->bcsaree->saree1_acknowledge==1),
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree1_quality) ? $model->bcsaree->saree1_quality : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree1_quality_no_1',
                                                    'label' => 'साड़ी के कपड़े की क्वालिटी अच्छी नहीं है। साड़ी का मटेरीयल सिन्थेटिक है, सूती नहीं है।',
                                                    'format' => 'html',
                                                    'visible'=> (isset($model->bcsaree->saree1_acknowledge) and $model->bcsaree->saree1_acknowledge==1),
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree1_quality_no_1) ? $model->bcsaree->saree1_quality_no_1 : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree1_quality_no_2',
                                                    'label' => 'साड़ी में जो बुनाई है, उसके धागे निकल रहे है ।',
                                                    'visible'=> (isset($model->bcsaree->saree1_acknowledge) and $model->bcsaree->saree1_acknowledge==1),
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree1_quality_no_2) ? $model->bcsaree->saree1_quality_no_2 : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree1_quality_no_3',
                                                    'label' => 'धुलने के बाद साड़ी का रंग हल्का हो गया है ।',
                                                    'visible'=> (isset($model->bcsaree->saree1_acknowledge) and $model->bcsaree->saree1_acknowledge==1),
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree1_quality_no_3) ? $model->bcsaree->saree1_quality_no_3 : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree1_quality_no_4',
                                                    'label' => 'साड़ी की लंबाई कम है ।',
                                                    'visible'=> (isset($model->bcsaree->saree1_acknowledge) and $model->bcsaree->saree1_acknowledge==1),
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree1_quality_no_4) ? $model->bcsaree->saree1_quality_no_4 : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree1_quality_no_other',
                                                    'label' => 'अन्य कोई',
                                                    'visible'=> (isset($model->bcsaree->saree1_acknowledge) and $model->bcsaree->saree1_acknowledge==1),
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree1_quality_no_other_text) ? $model->bcsaree->get_saree1_quality_no_other_text : '';
                                                    }
                                                ],    
                                            ],
                                        ])
                                        ?>
                                        <br/>
                                        <?=
                                            isset($model->bcsaree->get_saree1_quality_photo) ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->bcsaree->saree1_photo_url . '" data-src="' . $model->bcsaree->saree1_photo_url . '"  class="lozad" title="Saree photo"/>
                                        </span> ' : '-' 
                                        ?>
                                        
                                    </div> 

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">

                            <div id="panel-1" class="panel">
                                <div class="panel-hdr">
                                    <h2>
                                        <?= 'Second Saree' ?>
                                    </h2>

                                </div>
                                <div class="panel-container show">
                                    <div class="panel-content">

                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'saree2_provided',
                                                    'label' => 'Provided',
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->saree2_provided) ? 'Yes' : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'saree2_provided_date',
                                                    'label' => 'Provided date',
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->saree2_provided_date) ? $model->bcsaree->saree2_provided_date : '';
                                                    }
                                                ],
                                               [
                                                    'attribute' => 'saree2_acknowledge',
                                                    'label' => 'बीसी सखी यूनिफ़ॉर्म साड़ी 1 प्राप्त की',
                                                    'visible'=> isset($model->bcsaree->saree2_acknowledge),
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return (isset($model->bcsaree->saree2_acknowledge) and $model->bcsaree->saree2_acknowledge==1) ? 'Yes' : 'No';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree2_date',
                                                    'label' => 'प्राप्त दिनांक',
                                                    'format' => 'html',
                                                    'visible'=> (isset($model->bcsaree->saree2_acknowledge) and $model->bcsaree->saree2_acknowledge==1),
                                                    'value' => function ($model) {
                                                        return (isset($model->bcsaree->saree2_acknowledge) and $model->bcsaree->saree2_acknowledge==1) ? $model->bcsaree->get_saree2_date : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree2_packed_new',
                                                    'label' => 'सही ढंग से पैक किया हुआ नया साड़ी मिला',
                                                    'format' => 'html',
                                                    'visible'=> (isset($model->bcsaree->saree2_acknowledge) and $model->bcsaree->saree2_acknowledge==1),
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree2_packed_new) ? $model->bcsaree->saree2_packed_new : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree2_quality',
                                                    'label' => 'क्या साड़ी की क्वालिटी अच्छी है?',
                                                    'format' => 'html',
                                                    'visible'=> (isset($model->bcsaree->saree2_acknowledge) and $model->bcsaree->saree2_acknowledge==1),
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree2_quality) ? $model->bcsaree->saree2_quality : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree2_quality_no_1',
                                                    'label' => 'साड़ी के कपड़े की क्वालिटी अच्छी नहीं है। साड़ी का मटेरीयल सिन्थेटिक है, सूती नहीं है।',
                                                    'format' => 'html',
                                                    'visible'=> (isset($model->bcsaree->saree2_acknowledge) and $model->bcsaree->saree2_acknowledge==1),
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree2_quality_no_1) ? $model->bcsaree->saree2_quality_no_1 : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree2_quality_no_2',
                                                    'label' => 'साड़ी में जो बुनाई है, उसके धागे निकल रहे है ।',
                                                    'visible'=> (isset($model->bcsaree->saree2_acknowledge) and $model->bcsaree->saree2_acknowledge==1),
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree2_quality_no_2) ? $model->bcsaree->saree2_quality_no_2 : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree2_quality_no_3',
                                                    'label' => 'धुलने के बाद साड़ी का रंग हल्का हो गया है ।',
                                                    'visible'=> (isset($model->bcsaree->saree2_acknowledge) and $model->bcsaree->saree2_acknowledge==1),
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree2_quality_no_3) ? $model->bcsaree->saree2_quality_no_3 : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree2_quality_no_4',
                                                    'label' => 'साड़ी की लंबाई कम है ।',
                                                    'visible'=> (isset($model->bcsaree->saree2_acknowledge) and $model->bcsaree->saree2_acknowledge==1),
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree2_quality_no_4) ? $model->bcsaree->saree2_quality_no_4 : '';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'get_saree2_quality_no_other',
                                                    'label' => 'अन्य कोई',
                                                    'visible'=> (isset($model->bcsaree->saree2_acknowledge) and $model->bcsaree->saree2_acknowledge==1),
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return isset($model->bcsaree->get_saree2_quality_no_other_text) ? $model->bcsaree->get_saree2_quality_no_other_text : '';
                                                    }
                                                ],           
                                            ],
                                        ])
                                        ?>
                                        <br/>
                                        <?=
                                            isset($model->bcsaree->get_saree2_quality_photo) ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->bcsaree->saree2_photo_url . '" data-src="' . $model->bcsaree->saree2_photo_url . '"  class="lozad" title="Saree photo"/>
                                        </span> ' : '-' 
                                        ?>

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
    $js = <<<JS
$(function () {
        $('.popb').elevateZoom({
         scrollZoom : true,
        responsive : true,
        zoomWindowOffetx:-600
   });
   $('.popbc').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';     
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
    $js = <<<JS
             
        observer = lozad('.lozad', {
                                        load: function (el) {
                                            console.log('loading element');
                                            el.src = el.getAttribute('data-src');
                                            // Custom implementation to load an element
                                            // e.g. el.src = el.getAttribute('data-src');

                
                
                                                $(el).elevateZoom({
                                                    scrollZoom: true,
                                                    responsive: true,
                                                    zoomWindowOffetx: -600
                                                });
                                                $('.popbc').click(function () {
                                                    $('#imagecontent').html('');
                                                    $('#modal').modal('show')
                                                            .find('#imagecontent')
                                                            .load($(this).attr('value'));
                                                    document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';
                                                });

//                                            $(function () {
//                                                $('.popb').elevateZoom({
//                                                    scrollZoom: true,
//                                                    responsive: true,
//                                                    zoomWindowOffetx: -600
//                                                });
//                                                $('.popbc').click(function () {
//                                                    $('#imagecontent').html('');
//                                                    $('#modal').modal('show')
//                                                            .find('#imagecontent')
//                                                            .load($(this).attr('value'));
//                                                    document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';
//                                                });
//                                            });

                                        }
                                    }); // lazy loads elements with default selector as '.lozad'
                                    observer.observe();     
        
JS;
    $this->registerJs($js);
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

    <?php
    $css = <<<cs
      .img{cursor : pointer }
cs;
    $this->registerCss($css);
    ?>

    <style>
        .box .box-header.blue-background {
            color: #000;
        }
        .box .box-header {
            padding: 0px 15px;
        }
        .box .box-header {
            font-size: 21px;
            font-weight: 200;
            line-height: 30px;
            padding: 10px 15px;
            overflow: hidden;
            *zoom: 1;
            width: 100%;
        }
        .blue-background {
            background-color: #d9edf7 !important;
            border-color: #bce8f1;
        }
        th{
            font-weight: normal;
        }
        td{
            font-weight: bold;
            vertical-align:middle;
        }
        hr{
            margin: 5px;
            height: 1px;
            background-color: #ccc;
            width: 106.8%;
        }


    </style>
