<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\User;
use yii\bootstrap\Modal;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\nfsa\NfsaBaseSurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registered user';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nfsa-base-survey-index">

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
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'search-form'
                ],
                'method' => 'get',
//                'fieldConfig' => [
//                    'template' => "{label}\n<div class=\"col-lg-0\">{input}</div>",
//                    'labelOptions' => ['class' => 'col-md-12 control-label'],
//                ],
    ]);
    ?>

    <div class="row-fluid" style="padding-top:5px;padding-bottom:5px">
        <?php
        echo $this->render('_regusersearch', [
            'model' => $searchModel, 'form' => $form
        ]);
        ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="ajax"> </div>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
        'id' => 'grid-data',
        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
        'pjax' => TRUE,
        'floatHeader' => true,
        'floatHeaderOptions' => ['scrollingTop' => '50'],
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
            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
            [
                'attribute' => 'mobile_no',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 15%'],
                'format' => 'raw',
                'value' => function ($model) {

                    return $model->mobile_no;
                },
            ],
            [
                'attribute' => 'form_number',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 75%'],
                'format' => 'raw',
                'value' => function ($model) {

                    return $model->bcsapplication!=null?$model->bcsapplication->form_number:'';
                },
            ],
//            [
//                'attribute' => 'Images',
//                'format' => 'raw',
//                'contentOptions' => ['style' => 'width: 25%'],
//                'value' => function ($model) {
//                    $html = '';
//                    if ($model->photo_of_eligible_household != NULL) {
//                        $html .= ' <span class="profile-picture">
//                                  <img width="90px" height="90px" src="/imagehelper/image?id=' . $model->id . '&col=photo_of_eligible_household' . '"  value ="' . Url::to("/image/showimage?id=" . $model->id . "&col=photo_of_eligible_household") . '" class="popb" title="Photo of eligible household" style="cursor : pointer"/>
//                                   </span>';
//                    }
//                    if ($model->passbook_photo != NULL) {
//                    $html .= ' <span class="profile-picture">
//                                  <img width="90px" height="90px" src="/imagehelper/image?id=' . $model->id . '&col=passbook_photo' . '"  value ="' . Url::to("/image/showimage?id=" . $model->id . "&col=passbook_photo") . '" class="popb" title="passbook photo" style="cursor : pointer"/>
//                                   </span>';
//                    }
//                    if ($model->aadhar_card_front != NULL) {
//                    $html .= ' <span class="profile-picture">
//                                  <img width="90px" height="90px" src="/imagehelper/image?id=' . $model->id . '&col=aadhar_card_front' . '"  value ="' . Url::to("/image/showimage?id=" . $model->id . "&col=aadhar_card_front") . '" class="popb" title="aadhar card front" style="cursor : pointer"/>
//                                   </span>';
//                    }
//                    if ($model->aadhar_card_back != NULL) {
//                    $html .= ' <span class="profile-picture">
//                                  <img width="90px" height="90px" src="/imagehelper/image?id=' . $model->id . '&col=aadhar_card_back' . '"  value ="' . Url::to("/image/showimage?id=" . $model->id . "&col=aadhar_card_back") . '" class="popb" title="aadhar card back" style="cursor : pointer"/>
//                                   </span>';
//                    }
//                    if ($model->photo_family != NULL) {
//                    $html .= ' <span class="profile-picture">
//                                  <img width="90px" height="90px" src="/imagehelper/image?id=' . $model->id . '&col=photo_family' . '"  value ="' . Url::to("/image/showimage?id=" . $model->id . "&col=photo_family") . '" class="popb" title="photo_family" style="cursor : pointer"/>
//                                   </span>';
//                    }
//                    if ($model->house_photo_full_frame != NULL) {
//                    $html .= ' <span class="profile-picture">
//                                  <img width="90px" height="90px" src="/imagehelper/image?id=' . $model->id . '&col=house_photo_full_frame' . '"  value ="' . Url::to("/image/showimage?id=" . $model->id . "&col=house_photo_full_frame") . '" class="popb" title="house photo full frame" style="cursor : pointer"/>
//                                   </span>';
//                    }
//                    return $html;
//                }
//            ],
            [
                'attribute' => 'Action',
                'format' => 'raw',
                'visible' => 0,
                'contentOptions' => ['style' => 'width: 5%'],
                'value' => function ($model) {
                    $status = '';

                    $html = '<span id="' . $model->id . '">';
                    $html .= yii\helpers\Html::button('<i class="fa fa-task"></i> View Data', ['id' => 'call' . $model->id, 'class' => 'btn  btn-warning btn-block popb', 'value' => '/nfsaSurvey/data/survey/view?id=' . $model->id, 'name' => 'viewdata', 'title' => 'View Data : ' . $status]);
                    $html .= "</span>";

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
    <?php Pjax::end(); ?>   
</div>

<?php
$css = <<<cs
 .pagination{margin: 0px !important;}
 .modal-lg {
    width: 100% !important;;
}       
cs;
$this->registerCss($css);
?>
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
$js = <<<JS
$(function () {
   $('.popnelig').click(function(){
        $('#fcontent').html('');
        $('#modal1').modal('show')
         .find('#fcontent')
         .load($(this).attr('value'));
         document.getElementById('modalHeader1').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';     
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
<?php
$css = <<<cs
      .img{cursor : pointer }
cs;
$this->registerCss($css);
?>
<?php
$this->registerJs(
        '
function init_click_handlers(){
$(".popb").elevateZoom({
       scrollZoom : true,
        responsive : true,
        zoomWindowOffetx:-600
   });
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





</div>
