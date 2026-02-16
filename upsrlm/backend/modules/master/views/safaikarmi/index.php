<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\editable\Editable;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel common\models\master\SafaiKarmiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Safai Karmis';
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
                    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
                    <div class="clearfix pt-3"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-responsive table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'district',
                            'block',
                            'gram_panchyat',
                            'name',
                            'mobile_no',
                            'district_code',
                            'block_code',
                            [
                                'attribute' => 'gram_panchayat_code',
                                'format' => 'raw',
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return Editable::widget([
                                        'name' => 'gram_panchayat_code',
                                        'asPopover' => false,
                                        'value' => (isset($model->gram_panchayat_code) and $model->gram_panchayat_code != 0) ? $model->gram_panchayat_code : '',
                                        'inputType' => Editable::INPUT_TEXT,
                                        'data' => [0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                                        'header' => 'gram panchayat code',
                                        'valueIfNull' => 'gram panchayat code',
                                        'options' => ['class' => 'form-control', 'placeholder' => ''],
                                        'formOptions' => ['action' => ['/master/safaikarmi/updategpcode?id=' . $model->id]],
                                        'pluginEvents' => [
                                            "editableChange" => "function(event, val) { console.log('Changed Value ' + val); }",
                                            "editableSubmit" => "function(event, val, form) { console.log('Submitted Value ' + val); }",
                                            "editableBeforeSubmit" => "function(event, jqXHR) { console.log('Before submit triggered'); }",
                                            "editableSubmit" => "function(event, val, form, jqXHR) { console.log('Submitted Value ' + val); }",
                                            "editableReset" => "function(event) { console.log('Reset editable form'); }",
                                            "editableSuccess" => "function(event, val, form, data) {  console.log('a'); }",
                                            "editableError" => "function(event, val, form, data) { console.log('Error while submission of value ' + val); }",
                                            "editableAjaxError" => "function(event, jqXHR, status, message) { console.log(message); }",
                                        ],
                                    ]);
                                    
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
            </div>
        </div>
    </div>
</div>
