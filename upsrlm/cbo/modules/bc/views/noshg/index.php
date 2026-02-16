<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

$this->title = 'BC (SHG not mentioned)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                   BC (SHG not mentioned)
                </h2>
                <div class="panel-toolbar">

                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="panel-tag">  
                        <p>बीसी सखी के SHG/ समूह को दर्ज (e-register) करने के लिए समूह सखी/
                            CRP द्वारा संभावित कृत्य -</p>
                        <ul style="list-style-type: upper-greek;">
                            <li>बीसी सखी के द्वारा संकेतित SHG सूची में ना उपलब्ध होने के स्थिति में
                                नामित SHG को e-register करना;</li> 
                            <li>बअगर बीसी सखी द्वारा संकेतित समूह उपलब्ध ही ना हो, तो बीसी सखी
                                को मौजूदा समूहों में किसी एक में शामिल करना एवं बीसी सखी को
                                सम्बद्ध समूह का नाम उनके मोबाइल ऐप से फ़ीड करने के लिए कहना;</li> 
                            <li>शामिल होने के बाद, बीसी सखी स्वयं से सम्बद्ध समूह का नाम एवं अन्य
                                आवश्यक जानकारी स्वयं अपने मोबाइल ऐप से उपलब्ध कराएँगी ।</li> 
                        </ul>

                        <p>सावधानी – पूरे प्रक्रिया में BMM का सीधे इन्वॉल्व्मेंट/ एंगेज होना आवश्यक
                            नहीं है । किसी भी स्थिति में BMM या मिशन के कोई भी अन्य मैनेजर/
                            अधिकारी बीसी सखीयों को ब्लॉक में नहीं बुलाएँगे । बीसी सखी को उनके
                            मोबाइल ऐप जानकारी भरने के लिए किसी तरह की कोई मदद करने की कोई
                            आवश्यकता नहीं है । उन्हें कोई भी असुविधा होने के स्थिति में Helpline नम्बर
                            पर फ़ोन करने के लिए कहा जा सकता है ।</p>
                    </div>
                    
                        <?php
                        Pjax::begin([
                            'id' => 'grid-data',
                            'enablePushState' => FALSE,
                            'enableReplaceState' => FALSE,
                            'timeout' => false,
                        ]);
                        ?>

                        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                        <div class="clearfix"></div>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "\n{items}\n{pager}\n{summary}",
                            'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                            'id' => 'grid-data',
                            'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                            'pjax' => TRUE,
                            
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'text-center']],
                                [
                                    'attribute' => 'name',
                                    'header' => 'BC Name',
//                        'contentOptions' => ['style' => 'width: 18%'],
                                    'enableSorting' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {

                                        return $model->name;
                                    }
                                ],
                                [
                                    'attribute' => 'district_name',
                                    'header' => 'BC District',
                                    'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->district_name;
                                    }
                                ],
                                [
                                    'attribute' => 'block_name',
                                    'header' => 'BC Block',
                                    'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->block_name;
                                    }
                                ],
                                [
                                    'attribute' => 'gram_panchayat_name',
                                    'header' => 'BC GP',
                                    'format' => 'html',
//                        'contentOptions' => ['style' => 'width: 10%'],
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->gram_panchayat_name;
                                    }
                                ],
//                                [
//                                    'attribute' => 'member',
//                                    'header' => 'BC Member',
////                        'contentOptions' => ['style' => 'width: 10%'],
//                                    'enableSorting' => false,
//                                    'format' => 'raw',
//                                    'value' => function ($model) {
//                                        return isset($model->agm) ? $model->agm->name_eng : '';
//                                    }
//                                ],
                                
                                
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'visible' => 0,//in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BMMU]),
                                    'template' => '{assignshg}',
                                    'buttons' => [
                                        'assignshg' => function ($url, $model) {
                                            return $model->cbo_shg_id == null ? yii\helpers\Html::button('<i class="fa fa-task"></i> Assign SHG', ['id' => 'take-action-' . $model->id, 'class' => 'btn btn-sm btn-warning btn-block popb', 'value' => '/bc/noshg/assignshg?bcid=' . $model->id, 'name' => 'takeaction', 'title' => 'Assign SHG']) : yii\helpers\Html::button('<i class="fa fa-task"></i> Update SHG', ['id' => 'take-action-' . $model->id, 'class' => 'btn btn-sm btn-warning btn-block popb', 'value' => '/bc/noshg/assignshg?bcid=' . $model->id, 'name' => 'takeaction', 'title' => 'Update SHG']);
                                            return $model->cbo_shg_id == null ? Html::a('<span class="fa fa-tasks"></span> Assign SHG', ['assignshg?bcid=' . $model->id], [
                                                'data-pjax' => "0",
                                                'class' => 'btn btn-sm btn-primary',
                                            ]) . ' ' : Html::a('<span class="fa fa-tasks"></span> Update SHG', ['assignshg?bcid=' . $model->id], [
                                                'data-pjax' => "0",
                                                'class' => 'btn btn-sm btn-primary',
                                            ]);
                                        },
                                    ]
                                ],
                            ],
                        ]);
                        ?>

                        <?php
                        $script = <<< JS
    $('form select').on('change', function(){
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
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right ml-auto float-right" data-dismiss="modal" style="cursor : pointer;color:red;float:right"></i>';     
        });
});  
        
JS;
                        $this->registerJs($js);
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
            <?php
            Modal::begin([
                'headerOptions' => ['id' => 'modalHeader'],
                'id' => 'modal',
                'size' => 'modal-lg',
                
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
            ]);
            echo "<div id='imagecontent'></div>";
            Modal::end();
            ?>