<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ApiLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Api Logs';
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
                    ]);
                    ?>
                    <?php
                    $js = <<<JS
$(function () {
   
        
     $('.reqmodel').click(function(){
        $('#requestmodel').modal('show')
         .find('#requestcontent')
         .load($(this).attr('value'));
     });    
});        

   
JS;
                    $this->registerJs($js);
                    ?>

                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

                    <div class="clearfix pt-6"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'headerRowOptions' => ['style' => 'background-color:#c3d9ff'],
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%']],
                            [
                                'attribute' => 'app_id',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->srlm_bc_selection_app_id;
                                }
                            ],
                            [
                                'attribute' => 'ip',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'time',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'request_url',
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'http_response_code',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'enableSorting' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'app_id',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'header' => 'App Version',
                                'value' => function ($model) {
                                    return $model->appdetail != null ? $model->appdetail->app_version : '-';
                                }
                            ],
                            [
                                'header' => '',
                                'contentOptions' => ['style' => 'width: 6%'],
                                'value' => function ($model) {
                                    $html = '';
                                    $html .= Html::button('<span class="fa fa-info"></span> Detail', ['value' => Url::to('/bc/apilog/requestbody?id=' . $model->id), 'class' => 'btn btn-xs btn-info btn-block reqmodel']);
                                    $html .= Html::a('View', Url::to(["/bc/apilog/requestbody?" . "id=$model->id"]), ['data-pjax' => "0"]);

                                    return $html;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'request',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->request_body != null ? $model->request_body : '-';
                                }
                            ],
                            [
                                'attribute' => 'response',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->response != null ? $model->response : '-';
                                }
                            ],
                            [
                                'header' => '',
                                'contentOptions' => ['style' => 'width: 6%'],
                                'value' => function ($model) {
                                    $html = '';
                                    $html .= Html::button('<span class="fa fa-info"></span> Detail', ['value' => Url::to('/bc/apilog/requestbody?id=' . $model->id), 'class' => 'btn btn-xs btn-info btn-block reqmodel']);
                                    $html .= Html::a('View', Url::to(["/bc/apilog/requestbody?" . "id=$model->id"]), ['data-pjax' => "0"]);

                                    return $html;
                                },
                                'format' => 'raw',
                            ],
//                                [
//                                    'attribute' => 'request_body',
//                                    'enableSorting' => false,
//                                    'format' => 'raw',
//                                ],
                        //'created_at',
                        ],
                    ]);
                    ?>
                    <?php Pjax::end() ?>
                </div>  
            </div>  
        </div> 
    </div>     
</div> 
<?php
Modal::begin([
    'id' => 'requestmodel',
    'size' => 'modal-lg',
    'clientOptions' => [
    //'backdrop' => 'static'
    ]
]);
echo "<div id='requestcontent'></div>";
Modal::end();
?>