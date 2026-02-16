<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\models\BcCumulativeReportBlock;
?>
<table id='report' class="table table-striped  table-bordered tbl_sort">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">District</th>
            <th class="text-center">Block</th>
            <th class="text-center">GP</th>
            <th colspan="1" class="text-center">Shortlisted</th>
            <th colspan="2" class="text-center">Certified BC</th>
            <th colspan="2" class="text-center">PVR</th>
            <th colspan="2" class="text-center">BC-SHG assigned</th>
            <th colspan="2" class="text-center">BC & SHG bank a/c verified</th>
            <th colspan="2" class="text-center">SHG PFMS mapping</th>
            <th colspan="2" class="text-center">BC-support fund (SHG)</th>
            <th colspan="2" class="text-center">Handheld machine provided</th>
            <th colspan="2" class="text-center">Operational</th>
        </tr>
        <tr style="height: 80px">
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th colspan="1" class="text-center">Shortlisted</th>

            <th class="text-90deg-text">Completed</th>
            <th colspan="1" class="bg-warning-50 text-90deg-text">Pendency</th>
            <th colspan="1" class="text-90deg-text">Completed</th>
            <th colspan="1" class="bg-warning-50 text-90deg-text">Pendency</th>
            <th colspan="1" class="text-90deg-text">Completed</th>
            <th colspan="1" class="bg-warning-50 text-90deg-text">Pendency</th>
            <th colspan="1" class="text-90deg-text">Completed</th>
            <th colspan="1" class="bg-warning-50 text-90deg-text">Pendency</th>
            <th colspan="1" class="text-90deg-text">Completed</th>
            <th colspan="1" class="bg-warning-50 text-90deg-text">Pendency</th>
            <th colspan="1" class="text-90deg-text">Completed</th>
            <th colspan="1" class="bg-warning-50 text-90deg-text">Pendency</th>
            <th colspan="1" class="text-90deg-text">Completed</th>
            <th colspan="1" class="bg-warning-50 text-90deg-text">Pendency</th>
            <th colspan="1" class="text-90deg-text">Completed</th>
            <th colspan="1" class="bg-warning-50 text-90deg-text">Pendency</th>

        </tr>
    </thead>  
    <tbody>
        <tr class="font-weight-bold bg-primary-50">
            <td class="text-center"></td>
            <td class="text-center bg-primary-50"><?= 'District' ?></td>
            <td class="text-center bg-primary-50"><?= 'Aspirational blocks' ?></td>
            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'no_of_gp') ?></td>
            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'no_of_bc_shortlisted') - BcCumulativeReportBlock::getTotal($dataProvider->models, 'urban') ?></td> 
            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'certified_bc') ?></td>

            <td class="text-center bg-primary-50"><a href="<?= $searchModel->district_select_base_url . '?DashboardSearchForm[aspirational]=1'?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportBlock::getTotal($dataProvider->models, 'no_of_bc_shortlisted') - (BcCumulativeReportBlock::getTotal($dataProvider->models, 'no_of_bc_registered') + BcCumulativeReportBlock::getTotal($dataProvider->models, 'agree') + BcCumulativeReportBlock::getTotal($dataProvider->models, 'blocked_bc'))) ?></a></td>

            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'pvr') ?></td>
            <td class="text-center bg-primary-50"><a href="<?= $searchModel->district_base_url .'?RsetisBatchParticipantsSearch[pendency]=pvr&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportBlock::getTotal($dataProvider->models, 'certified_bc') - BcCumulativeReportBlock::getTotal($dataProvider->models, 'pvr')) ?></a></td>
            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'shg_assigned') ?></td>
            <td class="text-center bg-primary-50"><a href="<?= $searchModel->district_base_url .'?RsetisBatchParticipantsSearch[pendency]=bc_shg_assigned&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportBlock::getTotal($dataProvider->models, 'certified_bc') - BcCumulativeReportBlock::getTotal($dataProvider->models, 'shg_assigned')) ?></a></td>
            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'bc_shg_bank_verified') ?></td>
            <td class="text-center bg-primary-50"><a href="<?= $searchModel->district_base_url .'?RsetisBatchParticipantsSearch[pendency]=bc_shg_bank_verified&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportBlock::getTotal($dataProvider->models, 'shg_assigned') - BcCumulativeReportBlock::getTotal($dataProvider->models, 'bc_shg_bank_verified')) ?></a></td>
            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'pfms_mapping') ?></td>
            <td class="text-center bg-primary-50"><a href="<?= $searchModel->district_base_url .'?RsetisBatchParticipantsSearch[pendency]=pfms_mapping&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportBlock::getTotal($dataProvider->models, 'bc_shg_bank_verified') - BcCumulativeReportBlock::getTotal($dataProvider->models, 'pfms_mapping')) ?></a></td>
            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'bc_support_fund_shg_transfer') ?></td>
            <td class="text-center bg-primary-50"><a href="<?= $searchModel->district_base_url .'?RsetisBatchParticipantsSearch[pendency]=bc_shg_support_fund&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportBlock::getTotal($dataProvider->models, 'pfms_mapping') - BcCumulativeReportBlock::getTotal($dataProvider->models, 'bc_support_fund_shg_transfer')) ?></a></td>
            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'handheld_machine_provided') ?></td>
            <td class="text-center bg-primary-50"><a href="<?= $searchModel->district_base_url .'?RsetisBatchParticipantsSearch[pendency]=handheld_machine&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportBlock::getTotal($dataProvider->models, 'bc_support_fund_shg_transfer') - BcCumulativeReportBlock::getTotal($dataProvider->models, 'handheld_machine_provided')) ?></a></td>
            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'operational') ?></td>
            <td class="text-center bg-primary-50"><a href="<?= $searchModel->district_base_url .'?RsetisBatchParticipantsSearch[pendency]=operational&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportBlock::getTotal($dataProvider->models, 'handheld_machine_provided') - BcCumulativeReportBlock::getTotal($dataProvider->models, 'operational')) ?></a></td>
        </tr>
        <?php
        $sr_no = 1;
        foreach ($dataProvider->getModels() as $model) {
            ?>
            <tr>
                <td class="text-center"><?= $sr_no ?></td>
                <td class="text-center"><?=
                    Html::a($model->district_name, ['/report/cumulative/pendencydb?district_code=' . $model->district_code], [
                        'data-pjax' => "0",
                    ]);
                    ?></td>
                <td class="text-center"><?= $model->block_name ?></td>
                <td class="text-center"><?= $model->no_of_gp ?></td>
                <td colspan="1" class="text-center"><?= $model->no_of_bc_shortlisted - $model->urban ?></td>

                <td class="text-center"><?= $model->certified_bc ?></td>
                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_select_base_url . '?DashboardSearchForm[district_code]=' . $model->district_code . '&DashboardSearchForm[block_code]=' . $model->block_code ?>" data-pjax="0" target="_blank"><?= ($model->no_of_bc_shortlisted - ($model->no_of_bc_registered + $model->agree + $model->blocked_bc)) ?></a></td>

                <td colspan="1" class="text-center"><?= $model->pvr ?></td>
                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->block_code . '&RsetisBatchParticipantsSearch[pendency]=pvr&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= ($model->certified_bc - $model->pvr) ?></a></td>
                <td colspan="1" class="text-center"><?= $model->shg_assigned ?></td>
                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->block_code . '&RsetisBatchParticipantsSearch[pendency]=bc_shg_assigned&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= ($model->certified_bc - $model->shg_assigned) ?></a></td>
                <td colspan="1" class="text-center"><?= $model->bc_shg_bank_verified ?></td>
                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->block_code . '&RsetisBatchParticipantsSearch[pendency]=bc_shg_bank_verified&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= ($model->shg_assigned - $model->bc_shg_bank_verified) ?></a></td>
                <td colspan="1" class="text-center"><?= $model->pfms_mapping ?></td>
                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->block_code . '&RsetisBatchParticipantsSearch[pendency]=pfms_mapping&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= ($model->bc_shg_bank_verified - $model->pfms_mapping) ?></a></td>
                <td colspan="1" class="text-center"><?= $model->bc_support_fund_shg_transfer ?></td>
                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->block_code . '&RsetisBatchParticipantsSearch[pendency]=bc_shg_support_fund&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= ($model->pfms_mapping - $model->bc_support_fund_shg_transfer) ?></a></td>

                <td colspan="1" class="text-center"><?= $model->handheld_machine_provided ?></td>
                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->block_code . '&RsetisBatchParticipantsSearch[pendency]=handheld_machine&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= ($model->bc_support_fund_shg_transfer - $model->handheld_machine_provided) ?></a></td>
                <td colspan="1" class="text-center"><?= $model->operational ?></td>
                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->block_code . '&RsetisBatchParticipantsSearch[pendency]=operational&RsetisBatchParticipantsSearch[aspirational]=1' ?>" data-pjax="0" target="_blank"><?= ($model->handheld_machine_provided - $model->operational) ?></a></td>
            </tr>
            <?php
            $sr_no++;
        }
        ?>
    </tbody>


</table>  
<?php
$css = <<<cs
 .table a {
 color:blue;
 text-decoration: underline !important;     
   }     
.text-90deg-text{
 * FF3.5+ */
  -moz-transform: rotate(-90.0deg);
  /* Opera 10.5 */
  -o-transform: rotate(-90.0deg);
  /* Saf3.1+, Chrome */
  -webkit-transform: rotate(-90.0deg);
  /* IE6,IE7 */
  filter: progid: DXImageTransform.Microsoft.BasicImage(rotation=0.083);
  /* IE8 */
  -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
  /* Standard */
  transform: rotate(-90.0deg);
     
        vertical-align:middle;
     
}
        table.dataTable thead > tr > th.sorting{
      padding-right:0px !important;      
   }
        .coll{
        width:9% !important;
        }
cs;
$this->registerCss($css);
?> 