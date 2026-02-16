<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "CBO registration status";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    CBO registration status
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
                    <div class="clearfix pt-3"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'bsVersion' => '4.x',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
//                        'pjax' => TRUE,
//                        'floatHeader' => true,
//                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'showPageSummary' => true,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'pageSummary' => 'Total'
                            ],
                            [
                                'class' => 'kartik\grid\ExpandRowColumn',
                                'width' => '50px',
                                'header' => 'Block',
                                'value' => function ($model, $key, $index, $column) {
                                    return GridView::ROW_COLLAPSED;
                                },
                                'detailUrl' => Url::to(['/shg/report/registrationblock']),
//                        'detail' => function ($model, $key, $index, $column) {
//                            return Yii::$app->controller->renderPartial('block', ['model' => $model]);
//                        },
                                //'headerOptions' => ['class' => 'kartik-sheet-style'],
                                'expandOneOnly' => true,
                                'contentOptions' => ['style' => 'width: 8%'],
                                'expandIcon' => '<span class="fal fa-caret-right glyphicon glyphicon-triangle-right"></span>',
                                'collapseIcon' => '<span class="fal fa-chevron-down glyphicon glyphicon-triangle-bottom"></span>',        
                            ],
                            [
                                'attribute' => 'total_shgs',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'SHGs verified & correct',
                                'header' => 'SHGs Entered',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getShgs()->count();
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'SHGs verified & correct',
                                'header' => 'SHGs verified & correct',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->count();
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'SHG difference',
                                'header' => 'SHG difference',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return ($model->total_shgs - $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->count());
                                },
                                'pageSummary' => true,
                                'contentOptions' => ['class' => 'danger'],
                            ],
                            [
                                'attribute' => 'total_members',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'SHG members E-registered',
                                'header' => 'SHG members E-registered',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->sum('no_of_members') != null ? $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->sum('no_of_members') : '';
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'SHG members difference',
                                'header' => 'SHG members difference',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return ($model->total_members - $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->sum('no_of_members'));
                                },
                                'pageSummary' => true,
                                'contentOptions' => ['class' => 'danger'],
                            ],
                            [
                                'attribute' => 'total_vo',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'VOs Submitted',
                                'header' => 'VOs Submitted',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getVos()->andWhere(['status' => 2])->count();
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'VO difference',
                                'header' => 'VO difference',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return ($model->total_vo - $model->getVos()->andWhere(['status' => 2])->count());
                                },
                                'pageSummary' => true,
                                'contentOptions' => ['class' => 'danger'],
                            ],
                            [
                                'attribute' => 'total_clf',
                                'contentOptions' => ['style' => 'width: 10%'],
                                'enableSorting' => false,
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'CLFs submitted',
                                'header' => 'CLFs submitted',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->getClfs()->andWhere(['status' => 2])->count();
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'CLF difference',
                                'header' => 'CLF difference',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return ($model->total_clf - $model->getClfs()->andWhere(['status' => 2])->count());
                                },
                                'pageSummary' => true,
                                'contentOptions' => ['class' => 'danger'],
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

                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div>
    </div>
 </div>   