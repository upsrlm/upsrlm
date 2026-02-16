<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\models\BcCumulativeReportDistrict;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Dashboard pendency";
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="niu_panel">

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
<!--                    <button id="exportBtn1" class="btn  btn-info float-right"> <i class="fal fa-file-excel" style="color: red"> </i> Export To Excel</button><br><br>-->
                    <div class="clearfix"></div>
                    <?php echo $this->render('rsethisd', ['dataProvider' => $dataProvider]); ?>

                    <?php
                    $script = <<< JS
          $(document).ready(function () {
      $("#exportBtn1").click(function(){
        TableToExcel.convert(document.getElementById("report"), {
            name: "ACS' report for daily monitoring - bc_pendency_report_district.xlsx",
            sheet: {
            name: "Sheet1"
            }
          });
        });                     
JS;
                    $this->registerJs($script);
                    ?>
                    <?php
                    if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                        $scriptts = <<< JS
                $('.tbl_sort').dataTable(
                {
                    searching: false,
                    fixedHeader: true,
                    paging: false,
                    scrollX: true,
                    scrollCollapse: true,
                    fixedColumns:   {
                        leftColumns: 4,
                    }
                });                    
     });                       
JS;
                        $this->registerJs($scriptts);
                    }
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
