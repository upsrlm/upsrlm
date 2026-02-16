<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

$this->title = 'SHG User';
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


                    <?php echo $this->render('_searchu', ['model' => $searchModel]); ?>
                    <div class="clearfix"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 2%', 'class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->user) ? $model->user->name : '';
                                }
                            ],
                            [
                                'attribute' => 'login',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->user) ? $model->user->username : '';
                                }
                            ],
                            [
                                'attribute' => 'shg_name',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return (isset($model->cbo) and $model->cbo_type == \common\models\CboMembers::CBO_TYPE_SHG) ? $model->cbo->name_of_shg : '';
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District/ Block',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->shg) ? $model->shg->district_name . '/ ' . $model->shg->block_name : '';
                                }
                            ],
                            [
                                'attribute' => 'gram_panchayat_name',
                                'label' => 'Gram Panchayat/ Rev. Village',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->shg) ? $model->shg->gram_panchayat_name . '/ ' . $model->shg->village_name : '';
                                }
                            ],
                            [
                                'attribute' => 'rishta_app_login',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->user->app_id) ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'shg_chairperson',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg_chairperson ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'shg_secretary',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg_secretary ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'shg_treasurer',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg_treasurer ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'shg_member',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->shg_member ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'bc_sakhi',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->bc_sakhi ? 'Yes' : 'No';
                                }
                            ],
                            [
                                'attribute' => 'samuh_sakhi',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->samuh_sakhi ? 'Yes' : 'No';
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

                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div>    
    </div>
</div> 
