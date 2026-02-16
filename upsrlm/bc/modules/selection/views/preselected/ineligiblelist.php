<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\tabs\TabsX;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\User;
use kartik\widgets\Select2;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = 'SRLM BC Selection : ineligible';
$this->params['icon'] = 'fa fa-pie-chart';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
?>
<div class="dashboard-index">


    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>

    <div class="row-fluid" style="padding-top:5px;padding-bottom:5px">
        <?php
        echo $this->render('_search', [
            'model' => $searchModel, 'form' => $form
        ]);
        ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>


<div class="col-xs-12 applicant" id="printcontaineer">
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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
            [
                'attribute' => 'name',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 9%'],
                'format' => 'raw',
                'value' => function ($model) {
                    $status = '';
//                    if ($model->bc_unwilling_rsetis == 1) {
//                        $status .= '<div class="text-danger">Unwilling</div>';
//                    }
                    return $model->name . $status;
                    //return Html::a($model->name, "/selection/data/application/view?id=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]) . $status;
                    ///return $model->name_of_head_of_household;
                },
            ],
            [
                'attribute' => 'guardian_name',
                'format' => 'html',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 9%'],
                'value' => function ($model) {
                    return $model->guardian_name != null ? $model->guardian_name : '';
                },
            ],
            [
                'attribute' => 'mobile_number',
                'enableSorting' => false,
                'format' => 'html',
                'value' => function ($model) {
                    return $model->mobile_number . '<br/>' . $model->mobile_no;
                },
            ],
            [
                'attribute' => 'age',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 3%'],
                'format' => 'raw',
                'value' => function ($model) {

                    return $model->age != null ? $model->age : '';
                },
            ],
            [
                'attribute' => 'reading_skills',
                'enableSorting' => false,
                'label' => 'Education',
                'format' => 'html',
                'value' => function ($model) {

                    return $model->readingskills != null ? $model->readingskills->name_eng : '';
                },
            ],
            [
                'attribute' => 'address',
                'enableSorting' => false,
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 15%'],
                'value' => function ($model) {
                    return $model->fulladdressdbgp;
                },
            ],
            [
                'attribute' => 'ineligible_reason',
                'format' => 'raw',
                'value' => function ($model) {

                    return $model->ineligible;
                }
            ],
            
        ],
    ]);
    ?>


</div>

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
$js = <<<JS
$(function () {
         
    $('.popb').click(function(){
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

//                                            $(function () {
//                                                $('.popb').elevateZoom({
//                                                    scrollZoom: true,
//                                                    responsive: true,
//                                                    zoomWindowOffetx: -600
//                                                });
//                                                $('.popbc').click(function () {
//                                                    $('#imagecontent').html('');
//                                                    $('#modal').modal('show')
//                                                            .find('#imagecontent')
//                                                            .load($(this).attr('value'));
//                                                    document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';
//                                                });
//                                            });

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
