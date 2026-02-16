<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "SHG's";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    SHG's
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
                    ]);
                    ?>

                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    <div class="col-lg-12">
                        <div class="col-xs-4 col-sm-4">
                            <div style="margin: 0px 24px 0px 10px;border: 0px">
                                <label class="control-label">Legends</label>
                            </div>
                            <div class="widget-box" style="background-color: #D0E9C6;font-size: 14px;height: 40px;margin: 0px 20px;border: 0px">
                                <div class="widget-header" style="background-color: #D0E9C6;height:25px;border:0px"><span class="badge success" style="background-color:#D0E9C6;height:25px;width:40px;color: black;font: 18;font-weight: bold">1</span> Verified SHG</div>
                            </div>
                            <div class="widget-box warning" style="background-color: #FCF8E3;font-size: 14px;height: 40px;margin: 0px 20px;border: 0px">
                                <div class="widget-header" style="background-color: #FCF8E3;height:25px;border:0px"><span class="badge warning" style="background-color: #FCF8E3;height:25px;width:40px;color: black;font: 18;font-weight: bold">2</span> Return SHG</div>
                            </div>


                        </div>
                    </div>   
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-responsive table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
//                        'pjax' => TRUE,
//                        'floatHeader' => true,
//                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'rowOptions' => function ($model) {

                            if ($model->verification_status == '1' and $model->verify_mobile_no == '0') {
                                return ['class' => 'color-warning-400'];
                            } elseif ($model->verification_status == '1' and $model->verify_mobile_no == '1') {
                                return ['class' => 'color-success-400'];
                            } else {
                                
                            }
                        },
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'id',
                                'enableSorting' => false,
                                'contentOptions' => ['class' => 'info'],
                            ],
                            [
                                'attribute' => 'name_of_shg',
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District',
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'block_name',
                                'label' => 'Block ',
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'label' => 'Gram Panchayat ',
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'village_name',
                                'label' => 'Rev. Village',
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'hamlet',
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'chaire_person_name',
                                'label' => 'Chair Person',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $mmodel = $model->getRmembers()->andWhere(['role' => 1])->one();
                                    return isset($mmodel) ? $mmodel->name . "<br/>" . $mmodel->mobile : '';
                                }
                            ],
                            [
                                'attribute' => 'secretary_name',
                                'label' => 'Secretary',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $mmodel = $model->getRmembers()->andWhere(['role' => 2])->one();
                                    return isset($mmodel) ? $mmodel->name . "<br/>" . $mmodel->mobile : '';
                                }
                            ],
                            [
                                'attribute' => 'treasurer_name',
                                'label' => 'Treasurer',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $mmodel = $model->getRmembers()->andWhere(['role' => 3])->one();
                                    return isset($mmodel) ? $mmodel->name . "<br/>" . $mmodel->mobile : '';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_SUPPORT_UNIT]),
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return ' ' . Html::a('<span class="fal fa-eye"></span>', ['/shg/view?shgid=' . $model->id], [
                                            'data-pjax' => "0",
                                            'class' => 'btn btn-sm btn-primary',
                                        ]);
                                    },
                                ]
                            ],
//                            [
//                                'attribute' => 'chaire_person_name',
//                                'label' => 'Chair Person',
//                                'contentOptions' => ['style' => 'width: 10%'],
//                                'format' => 'raw',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    $html = $model->chaire_person_name . "<br/>" . $model->chaire_person_mobile_no;
//                                    if ($model->verify_over_all == 0 and $model->verify_chaire_person == 0 and $model->getProrole() == 0 and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
//                                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i>Verify Chairperson', ['id' => 'verify-chaire-person-action-' . $model->id, 'class' => 'btn  btn-info popb', 'value' => '/shg/default/verifychairperson?shgid=' . $model->id, 'name' => 'takeaction', 'data-pjax' => "0", 'title' => 'Verify Chairperson']);
//                                    }
//                                    return $html;
//                                }
//                            ],
//                            [
//                                'attribute' => 'secretary_name',
//                                'label' => 'Secretary',
//                                'contentOptions' => ['style' => 'width: 10%'],
//                                'format' => 'raw',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    $html = $model->secretary_name . "<br/>" . $model->secretary_mobile_no;
//                                    if ($model->verify_over_all == 0 and $model->verify_chaire_person == 2 and $model->verify_secretary == 0 and $model->getSeorole() == 0 and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
//                                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i>Verify secretary', ['id' => 'verify-secretary-action-' . $model->id, 'class' => 'btn  btn-info popb', 'value' => '/shg/default/verifysecretary?shgid=' . $model->id, 'name' => 'takeaction', 'data-pjax' => "0", 'title' => 'Verify secretary']);
//                                    }
//                                    return $html;
////                                    return $model->secretary_name . "<br/>" . $model->secretary_mobile_no;
//                                }
//                            ],
//                            [
//                                'attribute' => 'treasurer_name',
//                                'label' => 'Treasurer',
//                                'contentOptions' => ['style' => 'width: 10%'],
//                                'format' => 'raw',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    $html = $model->treasurer_name . "<br/>" . $model->treasurer_mobile_no;
//                                    if ($model->verify_over_all == 0 and $model->verify_chaire_person == 2 and $model->verify_secretary == 2 and $shg_model->verify_treasurer == 0 and $model->getTrorole() == 0 and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
//                                        $html .= yii\helpers\Html::button('<i class="fa fa-task"></i>Verify Treasurer', ['id' => 'verify-treasurer-action-' . $model->id, 'class' => 'btn  btn-info popb', 'value' => '/shg/default/verifytreasurer?shgid=' . $model->id, 'name' => 'takeaction', 'data-pjax' => "0", 'title' => 'Verify Treasurer']);
//                                    }
//                                    return $html;
//                                    //return $model->treasurer_name . "<br/>" . $model->treasurer_mobile_no;
//                                }
//                            ],
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
                        'headerOptions' => ['id' => 'modalHeader'],
                        'id' => 'modal',
                        'size' => 'modal-xl',
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
jQuery.noConflict();
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