<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

$this->title = "WSS";
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
                    <?php
                    $form = ActiveForm::begin([
                                'options' => [
                                    'class' => 'form-inline',
                                    'data-pjax' => true,
                                    'id' => 'search-form'
                                ],
                                'id' => 'search-form',
                                'layout' => 'inline',
                                'method' => 'get',
                    ]);
                    ?>
                    <?php
                    echo $this->render('_searchwss', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>
                    <?php ActiveForm::end(); ?>
                    <div class="mb-3"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                            [
                                'attribute' => 'name',
                                'label' => 'Name',
                                'format' => 'html',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->user) ? $model->user->name : '';
                                }
                            ],
                            [
                                'attribute' => 'login',
                                'label' => 'Mobile No',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return isset($model->user) ? $model->user->username : '';
                                }
                            ],
                            [
                                'attribute' => 'shg_name',
                                'label' => 'SHG',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return (isset($model->shg)) ? $model->shg->name_of_shg : '';
                                }
                            ],
                            [
                                'attribute' => 'district_name',
                                'label' => 'District',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return (isset($model->shg)) ? $model->shg->district_name : '';
                                }
                            ],
                            [
                                'attribute' => 'block_name',
                                'label' => 'Block',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return (isset($model->shg)) ? $model->shg->block_name : '';
                                }
                            ],
                            [
                                'attribute' => 'grampanchyat_name',
                                'label' => 'Gram Panchayat',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return (isset($model->shg)) ? $model->shg->gram_panchayat_name : '';
                                }
                            ],
                            [
                                'attribute' => 'form_status',
                                'label' => 'अभी का स्टेज',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->formstatus;
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