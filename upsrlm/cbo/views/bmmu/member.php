<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\User;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BMMU';
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


                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    <div class="clearfix"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pager' => [
                            'options' => ['class' => 'pagination'],
                            'prevPageLabel' => 'Previous',
                            'nextPageLabel' => 'Next',
                            'firstPageLabel' => 'First',
                            'lastPageLabel' => 'Last',
                            'nextPageCssClass' => 'paginate_button page-item',
                            'prevPageCssClass' => 'paginate_button page-item',
                            'firstPageCssClass' => 'paginate_button page-item',
                            'lastPageCssClass' => 'paginate_button page-item',
                            'maxButtonCount' => 10,
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 6s%']],
                            [
                                'attribute' => 'name',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->name;
                                }
                            ],
                            [
                                'attribute' => 'username',
                                'header' => 'Mobile No',
                                'enableSorting' => false
                            ],
                            [
                                'attribute' => 'District',
                                'header' => 'District',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $html = '';
                                    if (in_array($model->role, [MasterRole::ROLE_BMMU])) {
                                        $html .= implode(', ', array_unique(ArrayHelper::getColumn($model->blocks, 'district.district_name')));
                                    }
                                    return $html;
                                },
                            ],
                            [
                                'attribute' => 'Block',
                                'header' => 'Block',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    $html = '';
                                    if (in_array($model->role, [MasterRole::ROLE_BMMU])) {

                                        $html .= '' . implode(', ', array_unique(ArrayHelper::getColumn($model->blocks, 'block.block_name')));
                                    }
                                    return $html;
                                },
                            ],
                            [
                                'attribute' => 'no_of_call',
                                'format' => 'raw',
                                'label' => 'No of call',
                                'enableSorting' => false,
                                'value' => function ($model) {

                                    return common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find()->select(['id'])->where(['customernumber' => $model->username, 'upsrlm_call_scenario' => \common\models\base\GenralModel::CALL_SCENARIO_BMMU_WADA_INFO])->count();
                                }
                            ],
                            [
                                'attribute' => 'Action',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'format' => 'raw',
                                'enableSorting' => false,
                                'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU]),
                                'value' => function ($model) {
                                    $html = '';
                                    if (Yii::$app->user->identity->username == '9506812777' or Yii::$app->user->identity->role == MasterRole::ROLE_ADMIN) {
                                        $html .= yii\helpers\Html::button('<i class="fal fa-phone"></i> Call', ['id' => 'take1-verify-' . $model->id, 'to' => $model->username, 'upsrlm_call_scenario' => \common\models\base\GenralModel::CALL_SCENARIO_BMMU_WADA_INFO, 'callrequesturl' => \Yii::$app->params['app_url']['cbo'] . '/call/requestsupplyuser?to=' . $model->username . '&upsrlm_call_scenario=' . \common\models\base\GenralModel::CALL_SCENARIO_BMMU_WADA_INFO, 'class' => 'btn  btn-success btn-block callto', 'value' => '/bmmu/call?id=' . $model->id . '&mobile_no=' . $model->username, 'name' => 'takeaction', 'title' => 'Call', 'style' => "margin-top:5px;"]) . '';
                                    }
                                    return $html;
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
   
JS;
                    $this->registerJs($script);
                    ?>

                    <?php
                    $js = <<<JS
 $(function () {       
$('.callto').click(function(){
        $('#formcontent').html('');
        var button = $(this);
       button.html('<span class="fal fa-spin fa-spinner"></span> Wait...');
       button.prop('disabled', true);                    
        var url=$(this).attr('callrequesturl'); 
                   $.ajax({
                        url: url,
                        type: 'post',
                        data: '',
                        mimeType: 'multipart/form-data',
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        context: this,    
                        success: function (data) {
                                if(data.success === true){
                                 var request_url=$(this).attr('value')+'&log_id='+data.log_id;
//                                $(this).html('');
//                                $(this).prop('disabled', false);   
                                    $('#modalform').modal('show')
                                     .find('#formcontent')
                                    .load(request_url);
                                    document.getElementById('modalHeaderform').innerHTML = '' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
                                 
                                }
                            },
                            error  : function (e)
                            {
                                console.log(e);
                            }
                           });
                    });                     
       
});  
        
JS;
                    $this->registerJs($js);
                    ?> `

                    <?php
                    Modal::begin([
                        'headerOptions' => ['id' => 'modalHeader'],
                        'id' => 'modal',
                        'size' => 'modal-xl',
                        'clientOptions' => [
                            'backdrop' => 'static',
                            'keyboard' => false,
                        ],
                    ]);
                    echo "<div id='imagecontent'></div>";
                    Modal::end();
                    ?>
                    <?php
                    Modal::begin([
                        'headerOptions' => ['id' => 'modalHeaderform'],
                        'id' => 'modalform',
                        'size' => 'modal-xl',
                        'clientOptions' => [
                            'backdrop' => 'static',
                            'keyboard' => false,
                        ],
                    ]);
                    echo "<div id='formcontent'></div>";

                    Modal::end();
                    ?> 
                    <?php Pjax::end(); ?> 
                </div>       
            </div>
        </div>
    </div>
</div>
<?php
$css = <<<cs
 @media (min-width: 992px) {
  .modal-dialog {
    max-width: 90% !important;
  }
  .modal-dialog table th, .modal-dialog table td {
        padding: 0rem !important;
  } 
      
}
cs;
$this->registerCss($css);
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
$this->registerJs(
        '
function init_click_handlers(){
jQuery.noConflict();
  $(".popb").click(function(e) {
             $("#imagecontent").html("");
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
