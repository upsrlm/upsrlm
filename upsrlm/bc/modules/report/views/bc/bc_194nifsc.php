<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
use kartik\icons\FontAwesomeAsset;

FontAwesomeAsset::register($this);
$this->title = "IFSC Code Wise Pendency";
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
                    <?php
                    $form = ActiveForm::begin([
                                'layout' => 'inline',
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'Searchform'
                                ],
                                'method' => 'get',
                    ]);
                    ?>

                    <?php
                    echo $this->render('_search194nifc', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <div class="clearfix pt-3"></div>


                    <div class="col-lg-12 pt-3">
                        <div class="card ">    
                            <div class="card-header <?= \Yii::$app->params['class'] ?>"><i class="fal fa-user"> </i> <?= \Yii::$app->params['title'] ?></div>
                        </div>
                        <div class="card-body">
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                'id' => 'grid-data',
                                'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                'pjax' => TRUE,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%']],
                                    [
                                        'class' => 'kartik\grid\ExpandRowColumn',
                                        'width' => '50px',
                                        'value' => function ($model, $key, $index, $column) {
                                            return GridView::ROW_COLLAPSED;
                                        },
                                        'detailUrl' => Url::to(['/report/bc/detailpendency']),        
//                                        'detail' => function ($model, $key, $index, $column) {
//                                            return Yii::$app->controller->renderPartial('_ifscbankbc', ['model' => $model]);
//                                        },
                                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                                        'expandOneOnly' => true,
                                        'expandIcon' => '<span class="fal fa fa-caret-right glyphicon glyphicon-triangle-right"></span>',
                                        'collapseIcon' => '<span class="fal fa fa-chevron-down glyphicon glyphicon-triangle-bottom"></span>',
                                    ],
                                    [
                                        'attribute' => 'branch_code_or_ifsc',
                                        'header' => 'IFSC Code',
                                        'contentOptions' => ['style' => 'width: 15%'],
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->bc_settlement_account_ifsc_code;
                                        },
                                    ],
                                    [
                                        'attribute' => 'name_of_bank',
                                        'header' => 'Bank Name',
                                        'format' => 'raw',
                                        'contentOptions' => ['data-title' => 'Bank Name'],
                                        'value' => function ($model) {
                                            return $model->bc_settlement_account_bank_name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'BC Sakhi',
                                        'header' => 'No. of BC Sakhi',
                                        'format' => 'raw',
                                        'contentOptions' => ['data-title' => 'BC Sakhi'],
                                        'value' => function ($model) {
                                            return $model->application_count;
                                        }
                                    ],
                                    [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{download}',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_RBI]),
                                'contentOptions' => ['style' => 'width: 5%;'],
                                'header' => 'Download',
                                'buttons' => [
                                    'download' => function ($url, $model) {
                                        return Html::a('<i class="fas fa fa-download" ></i> <i class="fas fa fa-file-csv" style="color:red"></i> Download', ['detailpendencydownload?bank_id=' . $model->bc_settlement_account_bank_name.'&ifsc_code='.$model->bc_settlement_account_ifsc_code], [
                                            'title' => Yii::t('app', 'Download CSV'),
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-default btn-sm',
                                        ]);
                                    },
                                ],
                            ],         
                                ],
                            ]);
                            ?>
                        </div> 
                    </div>   
                    <?php ActiveForm::end(); ?>
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    
    $("#search-form").attr("data-pjax", "True");                
    $(this).closest('form').submit();
});            
    
JS;
                    $this->registerJs($script);
                    ?>
                    <?php
//                    $js = <<< JS
//$(document).on('ready pjax:success', function() {
//        function updateURLParameter(url, param, paramVal)
//        {
//        var TheAnchor = null;
//        var newAdditionalURL = "";
//        var tempArray = url.split("?");
//        var baseURL = tempArray[0];
//        var additionalURL = tempArray[1];
//        var temp ="";                       
//                                                              
//        if (additionalURL)                                    
//        {                                                     
//            var tmpAnchor = additionalURL.split("#");         
//            var TheParams = tmpAnchor[0];                     
//            TheAnchor = tmpAnchor[1];                         
//            if(TheAnchor)                                     
//                additionalURL = TheParams;                    
//                                                              
//            tempArray = additionalURL.split("&");             
//                                                              
//            for (var i=0; i<tempArray.length; i++)            
//            {                                                 
//                if(tempArray[i].split('=')[0] != param)       
//                {                                             
//                    newAdditionalURL += temp + tempArray[i];  
//                    temp = "&";                               
//                }                                             
//            }                                                 
//        }                                                     
//        else                                                  
//        {                                                     
//            var tmpAnchor = baseURL.split("#");               
//            var TheParams = tmpAnchor[0];                     
//            TheAnchor  = tmpAnchor[1];                        
//                                                              
//            if(TheParams)
//                baseURL = TheParams;     
//        }                                                                      
//                                                                               
//        if(TheAnchor)                                                          
//            paramVal += "#" + TheAnchor;                                       
//                                                                               
//        var rows_txt = temp + "" + param + "=" + paramVal;                     
//        return baseURL + "?" + newAdditionalURL + rows_txt;                    
//    }
//
//    $('.pagination li a').click(function(event){
//            event.preventDefault(); 
//            var page = $(this).data('page') + 1;
//            var href = updateURLParameter(this.href, 'page', page); 
//            $('#search-form').prop('action', href);
//            $('#search-form').submit();
//        });  
//});
//JS;
//                    $this->registerJs($js)
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
