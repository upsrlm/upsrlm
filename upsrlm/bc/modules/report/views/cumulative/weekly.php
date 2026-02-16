<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use yii\bootstrap\Modal;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\models\BcCumulativeReportDistrict;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Cumulative district report";
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="niu_panel">
            <!--            <div class="panel-hdr">
                            <h2>
            <?= $this->title ?>
                            </h2>
                            <div class="panel-toolbar">
            
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            </div>
                        </div>-->
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



                    <?php echo $this->render('_searchw', ['model' => $searchModel]); ?>
                    <button id="exportBtn1" class="btn  btn-info float-right"> <i class="fal fa-file-excel" style="color: red"> </i> Export To Excel</button><br><br>
                    <div class="clearfix"></div>
                    <?php if (count($dataProvider->date_array) == 0) { ?>
                        <?php echo $this->render('week0', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 1) { ?>
                        <?php echo $this->render('week1', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 2) { ?>
                        <?php echo $this->render('week2', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 3) { ?>
                        <?php echo $this->render('week3', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 4) { ?>
                        <?php echo $this->render('week4', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 5) { ?>
                        <?php echo $this->render('week5', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 6) { ?>
                        <?php echo $this->render('week6', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 7) { ?>
                        <?php echo $this->render('week7', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 8) { ?>
                        <?php echo $this->render('week8', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 9) { ?>
                        <?php echo $this->render('week9', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 10) { ?>
                        <?php echo $this->render('week10', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 11) { ?>
                        <?php echo $this->render('week11', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 12) { ?>
                        <?php echo $this->render('week12', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php if (count($dataProvider->date_array) == 13) { ?>
                        <?php echo $this->render('week13', ['data' => $dataProvider]); ?>
                    <?php } ?>
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    
    $("#Searchform").attr("data-pjax", "True");                               
    $(this).closest('form').submit();
});            
    $(document).ready(function () {
      $("#exportBtn1").click(function(){
        TableToExcel.convert(document.getElementById("report"), {
            name: "ACS' report for daily monitoring - bc_cumulative_report_district.xlsx",
            sheet: {
            name: "Sheet1"
            }
          });
        });
  
                            
                            
                            
                            
                               


    
    
                $('.tbl_sort').dataTable(
                {
                    searching: false,
                   // fixedHeader: true,
                    paging: false,
                            scrollX:        true,
        scrollCollapse: true,
                    fixedColumns:   {
                        leftColumns: 4,
                    }
                });
                            
                            
                            
                            
     });                       
                            
JS;
                    $this->registerJs($script);
                    ?>
                    <?php
                    $style = <<< CSS
   table.dataTable.fixedHeader-floating{
        opacity: 1;
        z-index: 1000;
    }
CSS;
                    $this->registerCss($style);
                    ?>


                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div> 
    </div>
</div>
