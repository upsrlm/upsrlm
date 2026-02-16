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
//                        'pjax' => TRUE,
//                        'floatHeader' => true,
//                        'floatHeaderOptions' => ['scrollingTop' => '50'],
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
                                'attribute' => 'primary_phone_no',
                                'format' => 'raw',
                                'header' => 'Mobile No',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->profile != null ? $model->profile->primary_phone_no : '';
                                },
                            ],  
                            [
                                'attribute' => 'alternate_phone_no',
                                'format' => 'raw',
                                'header' => 'Alternate Mobile No',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->profile != null ? $model->profile->alternate_phone_no : '';
                                },
                            ],            
                            [
                                'attribute' => 'whatsapp_no',
                                'format' => 'raw',
                                'header' => 'Whatsapp number',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->profile != null ? $model->profile->whatsapp_no : '';
                                },
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
                            
                            
                        ],
                    ]);
                    ?>
                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div>
    </div>    

</div>
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
$script = <<< JS
    $(function(){

        function init_click_handlers(){

            $('.popb').click( function () {
                $('#modal').modal('show')
                .find('#imagecontent')
                .load($(this).attr('value'));

            $('#modal').on('shown.bs.modal', function (e) {
                var form =jQuery('#verify-profile');
                form.on('beforeSubmit', function(e) {
                    e.preventDefault();
                    jQuery.ajax({
                        url: form.attr('action'),
                            type: form.attr('method'),
                            data: new FormData(form[0]),
                            mimeType: 'multipart/form-data',
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: 'json',
                            success: function (data) {
                                if(data.success === true){
                                    $("#search-form").submit();
                                    $('#modal').modal('hide');
                                }
                            },
                            error  : function (e)
                            {
                                console.log(e);
                            }   
                    });
                    return false;        
                });
            });
        });
        }

        init_click_handlers(); //first run
        $("#grid-data").on("pjax:success", function() {
            init_click_handlers(); //reactivate links in grid after pjax update
        });


        
    });
JS;
$this->registerJs($script);
?>

