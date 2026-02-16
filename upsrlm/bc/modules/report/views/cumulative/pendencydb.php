<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\models\BcCumulativeReportBlock;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shg\models\ShgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "District : " . $dis_model->district_name . " pendency";
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
                    <?php $this->render('_searchw', ['model' => $searchModel]); ?>
                    <a href="/report/cumulative/pendencyd" data-pjax="0" class="btn btn-primary"> Back </a>
                    <div class="clearfix"></div>
                    <?php ?>
                    <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_BC_VIEWER])) { ?>

                        <?php
                        if (!$searchModel->master_partner_bank_id) {
                            echo $this->render('commondb', ['dis_model' => $dis_model, 'dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
                        }
                        if ($searchModel->master_partner_bank_id) {
                            echo $this->render('bankdbupsrlm', ['dis_model' => $dis_model, 'dataProvider' => $dataProviderb,'master_partner_bank_id'=>$searchModel->master_partner_bank_id,'model'=>$searchModel, 'searchModel' => $searchModel]);
                        }
                        ?>

                    <?php } ?> 
                    <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_MD])) { ?>
                        <?php //echo $this->render('commondb', ['dis_model' => $dis_model, 'dataProvider' => $dataProvider]); ?>
                    <?php } ?> 
                    <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) { ?>
                        <?php echo $this->render('rsethisdb', ['dis_model' => $dis_model, 'dataProvider' => $dataProvider, 'searchModel' => $searchModel]); ?>
                    <?php } ?>
                    <?php if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) { ?>
                        <?php echo $this->render('bankdb', ['dis_model' => $dis_model, 'dataProvider' => $dataProvider, 'searchModel' => $searchModel]); ?>
                    <?php } ?>    
                    <?php
                    $script = <<< JS
          
    $(document).ready(function () {
      $("#exportBtn1").click(function(){
        TableToExcel.convert(document.getElementById("report"), {
            name: "ACS' report for daily monitoring - bc_pendency_report_block.xlsx",
            sheet: {
            name: "Sheet1"
            }
          });
        });                     
                            
JS;
                    $this->registerJs($script);
                    ?>
                    <?php
//                    if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
//                      if (!$searchModel->master_partner_bank_id) {
//                        $scriptts = <<< JS
//                $('.tbl_sort').dataTable(
//                {
//                    searching: false,
//                    fixedHeader: true,
//                    paging: false,
//                    scrollX: true,
//                    scrollCollapse: true,
//                    fixedColumns:   {
//                        leftColumns: 6,
//                    }
//                });                    
//     });                       
//JS;
//                        $this->registerJs($scriptts);
//                      }
//                      if ($searchModel->master_partner_bank_id) {
//                        $scriptts = <<< JS
//                $('.tbl_sort').dataTable(
//                {
//                    searching: false,
//                    fixedHeader: true,
//                    paging: false,
//                    scrollX: true,
//                    scrollCollapse: true,
//                    fixedColumns:   {
//                        leftColumns: 6,
//                    }
//                });                    
//     });                       
//JS;
//                        $this->registerJs($scriptts);
//                      }
//                    }
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
