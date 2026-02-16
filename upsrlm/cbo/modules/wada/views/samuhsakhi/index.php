<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = "समूह सखी";
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
                    ]);
                    ?>

                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    <div class="clearfix"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'header' => 'WSS का नाम',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->name;
                                    return Html::a($model->name, '/selection/application/view?wadaid=' . $model->id, ['value' => '/selection/application/view?wadaid=' . $model->id, 'data-pjax' => "0", 'title' => $model->name, 'target' => '_blank', 'class' => 'popb']);
                                }
                            ],
                            [
                                'attribute' => 'cbo_shg_id',
                                'header' => 'समूह का नाम',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->shg->name_of_shg) ? $model->shg->name_of_shg : '';
                                }
                            ],
                            [
                                'attribute' => 'mobile_number',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->mobile_number) ? $model->mobile_number : '';
                                }
                            ],
                            [
                                'attribute' => 'guardian_name',
                                'header' => 'अभिभावक का नाम',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->guardian_name) ? $model->guardian_name : '';
                                }
                            ],
                            [
                                'attribute' => 'district_block',
                                'header' => 'जिला / ब्लॉक',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->district_name) ? $model->district_name . ' /' . $model->block_name : '';
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'header' => 'ग्राम पंचायत',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->gram_panchayat_name) ? $model->gram_panchayat_name : '';
                                }
                            ],
//                            [
//                                'attribute' => 'dob',
//                                'enableSorting' => false,
//                                'format' => 'raw',
//                                'value' => function ($model) {
//                                    return isset($model->dob) ? $model->dob : '';
//                                }
//                            ],
//                            [
//                                'attribute' => 'academic_level',
//                                'enableSorting' => false,
//                                'format' => 'raw',
//                                'value' => function ($model) {
//                                    return isset($model->edu->name_hi) ? $model->edu->name_hi : '';
//                                }
//                            ],
//                            [
//                                'attribute' => 'social_class',
//                                'enableSorting' => false,
//                                'format' => 'raw',
//                                'value' => function ($model) {
//                                    return isset($model->cast->name_hi) ? $model->cast->name_hi : '';
//                                }
//                            ],
//                            [
//                                'attribute' => 'marital_status',
//                                'enableSorting' => false,
//                                'format' => 'raw',
//                                'value' => function ($model) {
//                                    return isset($model->marriagestatus->name_hi) ? $model->marriagestatus->name_hi : '';
//                                }
//                            ],
                            [
                                'attribute' => 'Passbook image',
                                'header' => 'पासबुक फोटो',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->passbook_photo != null ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'wada_bank',
                                'header' => 'समूह सखी बैंक विवरण',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $arr = [0 => 'बैंक विवरण अपलोड नहीं ', 1 => 'बैंक विवरण अपलोड किया गया', 2 => 'बैंक विवरण सत्यापित', 3 => 'बैंक विवरण वापसी'];
                                    return $model->wadabanks;
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU]),
                                'template' => '{verification}',
                                'buttons' => [
                                    'verification' => function ($url, $model) {
                                        $html='';
                                        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU]) and ($model->wada_bank == 1)) {
                                            $html .= ' ' . yii\helpers\Html::a('<i class="fa fa-task"></i> बैंक विवरण सत्यापित करें', ['/wada/samuhsakhi/veryfywadabank?wadaid=' . $model->id], ['id' => 'verify-action-' . $model->id, 'class' => 'btn  btn-info', 'value' => '/wada/samuhsakhi/veryfywadabank?wadaid=' . $model->id, 'name' => 'takeaction', 'data-pjax' => "0", 'title' => 'बैंक विवरण सत्यापित करें']);
                                        }


                                        return $html;
                                    },
                                ]
                            ],
                        ],
                    ]);
                    ?>
                    <?php
                    $css = <<<cs
 
 .modal-xl {
    width: 100% !important;
    max-width: 90% !important; 
       
} 
.form-group {
  margin-bottom: 0px !important;                           
}
   
cs;
                    $this->registerCss($css);
                    ?>

                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){                     
    $("#Searchform").attr("data-pjax", "True");                
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
            $('#Searchform').prop('action', href);
            $('#Searchform').submit();
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
         document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right ml-auto float-right" data-dismiss="modal" style="cursor : pointer;color:red;float:right"></i>';    
        });
});  
        
JS;
                    $this->registerJs($js);
                    ?> 


                    <?php
                    Modal::begin([
                        'headerOptions' => ['id' => 'modalHeader1'],
                        'id' => 'modal1',
                        'size' => 'modal-md',
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
