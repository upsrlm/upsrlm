<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
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

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-responsive table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'rowOptions' => function ($model) {

//                            if ($model->verification_status == '1' and $model->verify_mobile_no == '0') {
//                                return ['class' => 'color-warning-400'];
//                            } elseif ($model->verification_status == '1' and $model->verify_mobile_no == '1') {
//                                return ['class' => 'color-success-400'];
//                            } else {
//                                
//                            }
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
                                'attribute' => 'shg_code',
                                'label' => 'NRLM SHG Code',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg_code != NULL ? $model->shg_code : '';
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District/ Block',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->district_name . '/ ' . $model->block_name;
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'label' => 'Gram Panchayat/ Rev. Village',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->gram_panchayat_name . '/ ' . $model->village_name;
                                }
                            ],
                            [
                                'attribute' => 'hamlet',
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'no_of_members',
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'chaire_person_name',
                                'label' => 'Chair Person',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->chaire_person_name . "<br/>" . $model->chaire_person_mobile_no;
                                }
                            ],
                            [
                                'attribute' => 'secretary_name',
                                'label' => 'Secretary',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->secretary_name . "<br/>" . $model->secretary_mobile_no;
                                }
                            ],
                            [
                                'attribute' => 'treasurer_name',
                                'label' => 'Treasurer',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->treasurer_name . "<br/>" . $model->treasurer_mobile_no;
                                }
                            ],
                            [
                                'attribute' => 'bc_sakhi',
                                'label' => 'BC Sakhi',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->bcuser) ? $model->bcuser->name . "<br/>" . $model->bcuser->username : '';
                                }
                            ],
                            [
                                'attribute' => 'samuh_sakhi',
                                'label' => 'Samuh Sakhi',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->ssuser) ? $model->ssuser->name . "<br/>" . $model->ssuser->username : '';
                                }
                            ],
                            [
                                'attribute' => 'created_by',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->entryby) ? $model->entryby->name . " (" . $model->entryby->mobile_no . ")" : '';
                                }
                            ],
                        ],
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