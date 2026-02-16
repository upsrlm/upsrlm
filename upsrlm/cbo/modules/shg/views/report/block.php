<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use cbo\models\CboBlock;
use cbo\models\CboBlockSearch;

//$searchModel = new CboBlockSearch();
//$searchModel->district_code = $model->district_code;
//$dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
?>
<div class="pfa-domestic-premium-freight-index">

    <div class="box">
        <div class="box box-primary">
            <div class="box-header with-border">

            </div>      
            <div class="box-body no-padding">
                <?php
                Pjax::begin([
                    'id' => 'grid-data',
                    'enablePushState' => FALSE,
                    'enableReplaceState' => FALSE,
                    'timeout' => false,
                ]);
                ?>

                <div id="no-more-tables" class="no-more-tables">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'showPageSummary' => true,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'block_name',
                                'label' => 'block',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'pageSummary' => 'Total'
                            ],
                            [
                                'attribute' => 'total_shgs',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'SHGs verified & correct',
                                'header' => 'SHGs Entered',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function($model) {
                                    return $model->getShgs()->count();
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'SHGs E-registered',
                                'header' => 'SHGs verified & correct',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'value' => function($model) {
                                    return $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->count();
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'SHG difference',
                                'header' => 'SHG difference',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function($model) {
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
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'value' => function($model) {
                                    return $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->sum('no_of_members') != null ? $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->sum('no_of_members') : '';
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'SHG members difference',
                                'header' => 'SHG members difference',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function($model) {
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
                                'attribute' => 'VOs e-registered',
                                'header' => 'VOs Submitted',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'value' => function($model) {
                                    return $model->getVos()->andWhere(['status' => 2])->count();
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'VO difference',
                                'header' => 'VO difference',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function($model) {
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
                                'attribute' => 'CLFs e-registered',
                                'header' => 'CLFs submitted',
                                'contentOptions' => ['style' => 'width: 8%'],
                                'enableSorting' => false,
                                'value' => function($model) {
                                    return $model->getClfs()->andWhere(['status' => 2])->count();
                                },
                                'pageSummary' => true
                            ],
                            [
                                'attribute' => 'CLF difference',
                                'header' => 'CLF difference',
                                'contentOptions' => ['style' => 'width: 9%'],
                                'enableSorting' => false,
                                'value' => function($model) {
                                    return ($model->total_clf - $model->getClfs()->andWhere(['status' => 2])->count());
                                },
                                'pageSummary' => true,
                                'contentOptions' => ['class' => 'danger'],
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
