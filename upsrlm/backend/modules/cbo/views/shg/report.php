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


                    <?php echo $this->render('_searchr', ['model' => $searchModel]); ?>
                    <div class="row mb-3"></div>
                    <div class="col-xl-12 mt-3">
                        <div class="row">
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvidergp))
                                                
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvidergp->query->distinct('gram_panchayat_code')->count());
                                            ?>
                                            <small class="m-0 l-h-n">No of GP</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '1']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->count());
                                            ?>
                                            <small class="m-0 l-h-n">No of SHG</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '1']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-100 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('no_of_user'));
                                            ?>
                                            <small class="m-0 l-h-n">No. of user</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '2']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('no_of_cst_user'));
                                            ?>
                                            <small class="m-0 l-h-n">Chairperson/Secretary/Treasurer user</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '2a']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('no_of_cst_user_login'));
                                            ?>
                                            <small class="m-0 l-h-n">Chairperson/Secretary/Treasurer used rishta app</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '2a']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('no_of_cst_user_not_login'));
                                            ?>
                                            <small class="m-0 l-h-n">Chairperson/Secretary/Treasurer not used rishta app</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '2a']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('suggest_samuh_sakhi'));
                                            ?>
                                            <small class="m-0 l-h-n">Nominated Samuh Sakhi</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '3']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('suggest_samuh_sakhi_completed_application'));
                                            ?>
                                            <small class="m-0 l-h-n">Nominated Samuh Sakhi completed form</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '3']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
<!--                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('suggest_samuh_sakhi_save_application'));
                                            ?>
                                            <small class="m-0 l-h-n">Nominated Samuh Sakhi incomplete form</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '3']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>-->
<!--                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-black mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            <?php
                                            if (isset($dataProvider))
                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('shg_profile_updated'));
                                            ?>
                                            <small class="m-0 l-h-n">SHG Profile updated</small>
                                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '3']) ?>   
                                        </h3>
                                    </div>
                                    <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>-->
                            <!--                            <div class="col-sm-6 col-xl-3">
                                                            <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-white mb-g">
                                                                <div class="">
                                                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <?php
                            if (isset($dataProvider))
                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('no_of_fund_received'));
                            ?>
                                                                        <small class="m-0 l-h-n">No of fund received</small>
                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '3']) ?>   
                                                                    </h3>
                                                                </div>
                                                                <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                            </div>
                                                        </div>-->
                            <!--                            <div class="col-sm-6 col-xl-3">
                                                            <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-white mb-g">
                                                                <div class="">
                                                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            <?php
                            if (isset($dataProvider))
                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('total_fund_received_amount'));
                            ?>
                                                                        <small class="m-0 l-h-n">Total fund received</small>
                            <?php //echo Html::submitButton('More Info <i class="fal fa-angle-right"></i>', ['class' => 'btn  btn-danger ', 'name' => 'button_type', 'value' => '3']) ?>   
                                                                    </h3>
                                                                </div>
                                                                <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                            </div>
                                                        </div>-->
                        </div>

                    </div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-responsive table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%', 'class' => 'text-center']],
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
                                'visible' => 0,
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
                                'attribute' => 'bc_sakhi',
                                'label' => 'BC Sakhi',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->is_bc == 1 ? 'Yes' : 'No';
                                }
                            ],
//                            [
//                                'attribute' => 'no_of_user',
//                                'label' => 'Total user',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return $model->no_of_user;
//                                }
//                            ],
                            [
                                'attribute' => 'no_of_cst_user',
                                'label' => 'CST User',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->no_of_cst_user;
                                }
                            ],
                            [
                                'attribute' => 'no_of_cst_user_used_rishta',
                                'label' => 'CST used rishta app',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->no_of_cst_user_used_rishta > 0 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'suggest_samuh_sakhi',
                                'label' => 'Nominated samuh sakhi',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->suggest_samuh_sakhi == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'suggest_samuh_sakhi_completed_application',
                                'label' => 'Nominated Samuh Sakhi form complete',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->suggest_samuh_sakhi_completed_application == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'shg_profile_updated',
                                'label' => 'SHG profile update',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg_profile_updated == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'no_of_member_added',
                                'label' => 'Member Added',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->no_of_member_added > 0 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'bank_detail_add',
                                'label' => 'Bank detail add',
                                'visible' => 0,
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bank_detail_add == 1 ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'no_of_fund_received',
                                'label' => 'Fund received',
                                'visible' => 0,
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->no_of_fund_received;
                                }
                            ],
                            [
                                'attribute' => 'total_fund_received_amount',
                                'label' => 'Total Fund received',
                                'visible' => 0,
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->total_fund_received_amount;
                                }
                            ],
//                            [
//                                'attribute' => 'bc_sakhi',
//                                'label' => 'BC Sakhi',
//                                'format' => 'html',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return isset($model->bcuser) ? $model->bcuser->name . "<br/>" . $model->bcuser->username : '';
//                                }
//                            ],
//                            [
//                                'attribute' => 'samuh_sakhi',
//                                'label' => 'Samuh Sakhi',
//                                'format' => 'html',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return isset($model->ssuser) ? $model->ssuser->name . "<br/>" . $model->ssuser->username : '';
//                                }
//                            ],
//                            [
//                                'attribute' => 'created_by',
//                                'format' => 'html',
//                                'enableSorting' => false,
//                                'value' => function ($model) {
//                                    return isset($model->entryby) ? $model->entryby->name . " (" . $model->entryby->mobile_no . ")" : '';
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