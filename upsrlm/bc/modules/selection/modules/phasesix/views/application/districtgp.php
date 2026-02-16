<?php

use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use common\helpers\Utility;
use yii\bootstrap4\Modal;


$this->title = 'District';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    District
                </h2>
                <div class="panel-toolbar">
<!--                    <button id="exportBtn1" class="btn  btn-info float-right"> <i class="fal fa-file-excel" style="color: red"> </i> Export To Excel</button><br><br>-->
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">




                    <div class="clearfix pt-3"></div> 
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{summary}\n{items}",
                        'tableOptions' => ['id' => 'report','class' => 'table table-striped table-bordered table-condensed '],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%']],
                            [
                                'attribute' => 'district_code',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'enableSorting' => false,
                            ],
                            [
                                'attribute' => 'District',
                                'contentOptions' => ['style' => 'width: 15%'],
                                'enableSorting' => false,
                                'value' => function ($model) {
                                    return $model->district_name;
                                },
                            ],
                            [
                                'attribute' => 'No of GPs',
                                'header' => 'No of GPs',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'No of GPs'],
                                'value' => function ($model) {
                                    return \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->where(['status' => 1, 'six_vacant' => 1, 'district_code' => $model->district_code])->count();
                                }
                            ],
                            [
                                'attribute' => 'No of GPs with zero registration',
                                'header' => 'No of GPs with zero registration',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'No of GPs with zero registration'],
                                'value' => function ($model) {
                                    return \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->where(['status' => 1, 'six_vacant' => 1, 'six_complete' => 0, 'district_code' => $model->district_code])->count();
                                }
                            ],
                        ],
                    ]);
                    ?>

                   
                </div>
            </div>

        </div>
    </div>
</div>
 <?php
//                    $script = <<< JS
//          $(document).ready(function () {
//                  $("#exportBtn1").click(function(){
//        TableToExcel.convert(document.getElementById("report"), {
//            name: "report_district_gp.xlsx",
//            sheet: {
//            name: "Sheet1"
//            }
//          });
//        });                     
//JS;
//                    $this->registerJs($script);
                    ?>