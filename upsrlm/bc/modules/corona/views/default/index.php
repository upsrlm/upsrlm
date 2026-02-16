<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use cbo\models\CboClf;

$this->title = "Corona Feedbcak";
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
                                    'id' => 'Searchform'
                                ],
                                'id' => 'Searchform',
                                'layout' => 'inline',
                                'method' => 'get',
                    ]);
                    ?>

                    <?php
                    echo $this->render('_search', [
                        'model' => $searchModel, 'form' => $form
                    ]);
                    ?>

                    <div class="row mb-3"></div>
                    <div class="col-xl-12 mt-3">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                            'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                            'id' => 'grid-data',
                            'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                            'pjax' => TRUE,
//                            'floatHeader' => false,
//                            'floatHeaderOptions' => ['scrollingTop' => '50'],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                                [
                                    'attribute' => 'district_name',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->district_name;
                                    }
                                ],
                                [
                                    'attribute' => 'block_name',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->block_name;
                                    }
                                ],
                                [
                                    'attribute' => 'gram_panchayat_name',
                                    'format' => 'html',
                                    'enableSorting' => false,
                                    'value' => function ($model) {
                                        return $model->gram_panchayat_name;
                                    }
                                ],
                                [
                                    'attribute' => 'que1a',
                                    'enableSorting' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->q1a != null ? $model->q1a->name_hi : '';
                                    }
                                ],
                                [
                                    'attribute' => 'que2a',
                                    'enableSorting' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->q2a != null ? $model->q2a->name_hi : '';
                                    }
                                ],
                                [
                                    'attribute' => 'que3a',
                                    'enableSorting' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->q3a != null ? $model->q3a->name_hi : '';
                                    }
                                ],
                                [
                                    'attribute' => 'que4a',
                                    'enableSorting' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->q4a != null ? $model->q4a->name_hi : '';
                                    }
                                ],
                                [
                                    'attribute' => 'bc_name',
                                    'enableSorting' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {

                                        return $model->bc_name;
                                    }
                                ],
                                [
                                    'attribute' => 'created_at',
                                    'enableSorting' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return date('Y-m-d G:i:s', $model->created_at);
                                    }
                                ],
                            ],
                        ]);
                        ?> 
                    </div>


                    <?php ActiveForm::end(); ?>
                    <?php
                    $js = <<<js
        
        $(document).ready(function(){
            $("#download").click(function(event){
              $("#Searchform").attr({ "action":"/corona/default/csvdownload"});
              $("#Searchform").removeAttr("data-pjax");
              $("#Searchform").submit();
            });
                 
        $("#searchbtn").click(function(event){
                $("#Searchform").attr({ "action":"/corona"});
                $("#Searchform").attr("data-pjax", "True");
            })
       }) 
js;

                    $this->registerJs($js);
                    ?>     
                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div> 
    </div>
</div>


