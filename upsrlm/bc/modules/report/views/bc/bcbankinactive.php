<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = "BC Bank";
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
                    echo $this->render('_searchbcbankinactive', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <div class="clearfix pt-3"></div>


                    <div class="col-lg-12 pt-3">

                        <div class="card-body">
                            <?php
                            echo GridView::widget([
                                'dataProvider' => $dataProvider,
                                'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                                'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                'id' => 'grid-data',
                                'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                'pjax' => TRUE,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                    [
                                        'attribute' => 'name',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {

                                            $html = '';
                                            return $model->name;
                                            return Html::a($model->name, '#', ['value' => '/report/bc/setelmentac194n?bcid=' . $model->id, 'data-pjax' => "0", 'title' => $model->name, 'class' => 'popb']) . $html;
                                        }
                                    ],
                                    [
                                        'attribute' => 'district_name',
                                        'format' => 'html',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->district_name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'block_name',
                                        'format' => 'html',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->block_name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'gram_panchayat_name',
                                        'format' => 'html',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->gram_panchayat_name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'name_of_bank',
                                        'format' => 'html',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->name_of_bank;
                                        }
                                    ],
                                    [
                                        'attribute' => 'branch_code_or_ifsc',
                                        'format' => 'html',
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return $model->branch_code_or_ifsc;
                                        }
                                    ],
                                    [
                                        'attribute' => 'BC bank a/c',
                                        'header' => 'BC bank a/c',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $html = '';
                                            if (in_array($model->bc_bank, [2])) {
                                                $html .= '<br/> Verified';
                                            }
                                            return isset($model->bank_account_no_of_the_bc) ? 'Yes' . $model->bcbanks : 'No' . $model->bcbanks;
                                        }
                                    ],
                                    [
                                        'attribute' => 'passbook photo',
                                        'format' => 'raw',
                                        'contentOptions' => ['style' => 'width: 12%'],
                                        'value' => function ($model) {
                                            $status = '';
                                            $html = '<span id="' . $model->id . '">';
                                            $html .= $model->passbook_photo != null ? '<span class="profile-picture">
                                        <img width="150px" height="150px" src="' . $model->passbook_photo_url . '"  data-src="' . $model->passbook_photo_url . '"  class="lozad" title="aadhar_front_photo" style="cursor : pointer"/>
                                        </span> ' : '';

                                            $html .= '</span>';
                                            return $html;
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'Action',
                                        'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]),
                                        'template' => '{changebank}',
                                        'buttons' => [
                                            'changebank' => function ($url, $model) {
                                                return (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN]) and $model->urban_shg == '0' and $model->blocked == '0') ? Html::button('Change BC Account Bank', [
                                                    'data-pjax' => "0",
                                                    'style' => 'margin-bottom:5px',
                                                    'class' => 'btn btn-info btn-block popb',
                                                    'value' => '/report/bc/changebank?bcid=' . $model->id,
                                                    'title' => 'Change BC Account Bank of  : ' . $model->name
                                                ]) . ' ' : '';
                                            },
                                        ]
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
                    $js = <<< JS
$(document).on('ready pjax:success', function() {
        function updateURLParameter(url, param, paramVal)
        {
        var TheAnchor = null;
        var newAdditionalURL = "";
        var tempArray = url.split("?");
        var baseURL = tempArray[0];
        var additionalURL = tempArray[1];
        var temp ="";                       
                                                              
        if (additionalURL)                                    
        {                                                     
            var tmpAnchor = additionalURL.split("#");         
            var TheParams = tmpAnchor[0];                     
            TheAnchor = tmpAnchor[1];                         
            if(TheAnchor)                                     
                additionalURL = TheParams;                    
                                                              
            tempArray = additionalURL.split("&");             
                                                              
            for (var i=0; i<tempArray.length; i++)            
            {                                                 
                if(tempArray[i].split('=')[0] != param)       
                {                                             
                    newAdditionalURL += temp + tempArray[i];  
                    temp = "&";                               
                }                                             
            }                                                 
        }                                                     
        else                                                  
        {                                                     
            var tmpAnchor = baseURL.split("#");               
            var TheParams = tmpAnchor[0];                     
            TheAnchor  = tmpAnchor[1];                        
                                                              
            if(TheParams)
                baseURL = TheParams;     
        }                                                                      
                                                                               
        if(TheAnchor)                                                          
            paramVal += "#" + TheAnchor;                                       
                                                                               
        var rows_txt = temp + "" + param + "=" + paramVal;                     
        return baseURL + "?" + newAdditionalURL + rows_txt;                    
    }

    $('.pagination li a').click(function(event){
            event.preventDefault(); 
            var page = $(this).data('page') + 1;
            var href = updateURLParameter(this.href, 'page', page); 
            $('#search-form').prop('action', href);
            $('#search-form').submit();
        });  
});
JS;
                    $this->registerJs($js)
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
                                                    document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';
                                                });


                                        }
                                    }); // lazy loads elements with default selector as '.lozad'
                                    observer.observe();     
        
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
