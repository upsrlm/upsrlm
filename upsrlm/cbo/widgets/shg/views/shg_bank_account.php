<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'Bank Account Detail' ?>
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
                    ]);
                    ?>
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
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'bank_account_no_of_the_shg',
                                'label' => 'बैंक का खाता संख्या',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    
                                    return isset($model->bank_account_no_of_the_shg)?$model->bank_account_no_of_the_shg:'';
                                }
                            ],
                            [
                                'attribute' => 'name_of_bank',
                                'label' => 'बैंक का नाम',
                                'enableSorting' => false,
                                'value' => function ($model) {    
                                    return isset($model->name_of_bank)?$model->name_of_bank:'';
                                }
                            ],
                            [
                                'attribute' => 'branch',
                                'label' => 'शाखा का नाम',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    
                                    return $model->branch;
                                }
                            ],
                            [
                                'attribute' => 'branch_code_or_ifsc',
                                'label' => 'शाखा कोड या IFSC कोड',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->branch_code_or_ifsc;
                                }
                            ],
                            [
                                'attribute' => 'date_of_opening_the_bank_account',
                                'label' => 'बैंक खाता खोलने की तिथि',
                                'enableSorting' => false,
                                'value' => function ($model) {    
                                    return isset($model->date_of_opening_the_bank_account)?$model->date_of_opening_the_bank_account:'';
                                }
                            ],
                            [
                                'attribute' => 'balance_as_on_date',
                                'label' => 'दिनांक के अनुसार शेष राशि',
                                'enableSorting' => false,
                                'value' => function ($model) {    
                                    return isset($model->balance_as_on_date)?$model->balance_as_on_date:'';
                                }
                            ],
//                            [
//                                'attribute' => 'bank_balance_date',
//                                'label' => 'से प्राप्त किया',
//                                'enableSorting' => false,
//                                'value' => function ($model) {    
//                                    return isset($model->bank_balance_date)?$model->bank_balance_date:'';
//                                }
//                            ],         
                        ]
                    ]);
                    ?>

                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $(this).closest('form').submit();
});            
    var loader = $(".ajax");
    $(document).on({
        ajaxStart: function () {
            loader.addClass("loader");
        },
        ajaxStop: function () {
            loader.removeClass("loader");
        }
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