<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\selection\models\base\GenralModel;
use common\models\User;

$this->title = 'SRLM BC Selection report';
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
                    $form = ActiveForm::begin([
                                'layout' => 'inline',
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'Searchform'
                                ],
                                'method' => 'get',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_selectedserarch', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <?php ActiveForm::end(); ?>
                    <div class="clearfix pt-3"></div>
                    <?php if ($searchModel->report_type == 1) { ?>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                            'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                            'id' => 'grid-data',
                            'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                            
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%', 'class' => 'text-center']],
                                [
                                    'attribute' => 'district_name',
                                    'header' => 'District',
                                    'enableSorting' => false,
                                    'contentOptions' => ['style' => 'width: 12%'],
                                    'format' => 'raw',
                                    'value' => function ($model) use ($searchModel) {
                                        return $model->district != null ? $model->district->district_name : '';
                                    },
                                ],
                                [
                                    'attribute' => 'total_no_of_gp',
                                    'header' => 'Total no of GP',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'contentOptions' => ['style' => 'width: 10%'],
                                    'value' => function ($model) use ($searchModel) {
                                        return $model->district != null ? $model->district->gram_panchayat_count : '';
                                    },
                                ],
                                [
                                    'attribute' => 'total_no_of_gp',
                                    'header' => 'GPs with Zero application',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'contentOptions' => ['style' => 'width: 15%'],
                                    'value' => function ($model) use ($searchModel) {
                                        return $model->district != null ? $model->district->noregsrlmgp : '';
                                    },
                                ],
                                [
                                    'attribute' => 'application_received',
                                    'header' => 'Total no of GP where selection completed',
                                    'enableSorting' => false,
                                    'contentOptions' => ['style' => 'width: 55%'],
                                    'format' => 'raw',
                                    'value' => function ($model) use ($searchModel) {
                                        return $model->district != null ? $model->district->selected : '';
                                    },
                                ],
                            ],
                        ]);
                        ?>
                    <?php } ?>
                    <?php if ($searchModel->report_type == 2) { ?>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                            'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                            'id' => 'grid-data',
                            'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                            
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 3%', 'class' => 'text-center']],
                                [
                                    'attribute' => 'block_name',
                                    'header' => 'Block',
                                    'enableSorting' => false,
                                    'contentOptions' => ['style' => 'width: 12%'],
                                    'format' => 'raw',
                                    'value' => function ($model) use ($searchModel) {
                                        return $model->block != null ? $model->block->block_name : '';
                                    },
                                ],
                                [
                                    'attribute' => 'total_no_of_gp',
                                    'header' => 'Total no of GP',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'contentOptions' => ['style' => 'width: 10%'],
                                    'value' => function ($model) use ($searchModel) {
                                        return $model->block != null ? $model->block->gram_panchayat_count : '';
                                    },
                                ],
                                [
                                    'attribute' => 'total_no_of_gp',
                                    'header' => 'GPs with Zero application',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'contentOptions' => ['style' => 'width: 15%'],
                                    'value' => function ($model) use ($searchModel) {
                                        return $model->block != null ? $model->block->noregsrlmgp : '';
                                    },
                                ],
                                [
                                    'attribute' => 'application_received',
                                    'header' => 'Total no of GP where selection completed',
                                    'enableSorting' => false,
                                    'contentOptions' => ['style' => 'width: 55%'],
                                    'format' => 'raw',
                                    'value' => function ($model) use ($searchModel) {
                                        return $model->block != null ? $model->block->selected : '';
                                    },
                                ],
                            ],
                        ]);
                        ?>
                    <?php } ?>
                    <?php if ($searchModel->report_type == 3) { ?>
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
                                    'attribute' => 'gram_panchayat_name',
                                    'header' => 'Gram panchayat',
                                    'enableSorting' => false,
                                    'contentOptions' => ['style' => 'width: 18%'],
                                    'format' => 'raw',
                                    'value' => function ($model) use ($searchModel) {
                                        return $model->gram_panchayat_name;
                                    },
                                ],
                                [
                                    'attribute' => 'application_received',
                                    'header' => 'Selected GP',
                                    'enableSorting' => false,
                                    'contentOptions' => ['style' => 'width: 75%'],
                                    'format' => 'raw',
                                    'value' => function ($model) use ($searchModel) {
                                        return $model->selected ? 'Yes' : 'No';
                                    },
                                ],
                            ],
                        ]);
                        ?>
                    <?php } ?>

                </div>
            </div> 
        </div>
    </div>
</div>
<?php
$script = <<< JS
    $('form select').on('change', function(){
    $("#Searchform").attr({ "action":"/selection/dashboard/report/selected"});
     $("#Searchform").attr("data-pjax", "True");    
    $(this).closest('form').submit();
});            
         
JS;
$this->registerJs($script);
?>      


<?php Pjax::end(); ?>    


