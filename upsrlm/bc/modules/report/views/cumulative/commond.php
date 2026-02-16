<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\models\BcCumulativeReportDistrict;
use bc\models\master\MasterGramPanchayatDetailBc;
?>
<table id='report' class="table table-striped  table-bordered tbl_sort">
    <thead>
        <tr>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
        
            <th colspan="2" class="text-center bg-info-50">SMMU</th>

            <th colspan="4" class="text-center bg-warning-50">RSETI</th>
            <th colspan="2" class="text-center bg-info-200">DMMU</th>
            <th colspan="4" class="text-center bg-info-50">SMMU</th>
            <th colspan="2" class="text-center bg-info-200">DMMU</th>
            <th colspan="2" class="text-center bg-info-50">SMMU</th>
            <th colspan="4" class="text-center bg-success-50">Partner agency</th>
            <th colspan="1" class="text-center">Overall</th>
            

        </tr>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">District</th>
            <th class="text-center">GP</th>
            <th colspan="1" class="text-center">Shortlisted</th>
            <th colspan="1" class="text-center">Standby GP</th>
            <th colspan="1" class="text-center">Vacant GP</th>
            <th colspan="4" class="text-center bg-danger-200  coll">Certified BC</th>
            <th colspan="2" class="text-center coll">PVR</th>
            <th colspan="2" class="text-center coll">BC-SHG assigned</th>
            <th colspan="2" class="text-center coll">BC & SHG bank a/c verified</th>
            <th colspan="2" class="text-center">SHG PFMS mapping</th>
            <th colspan="2" class="text-center coll">BC-support fund (SHG)</th>
            <th colspan="2" class="text-center coll">Handheld machine provided</th>
            <th colspan="2" class="text-center coll">Operational</th>
            <th colspan="1" class="text-center coll">Total target</th>
        </tr>
        <tr style="height: 76px">
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th colspan="1" class="text-center">Shortlisted</th>
            <th colspan="1" class="text-center">Standby GP</th>
            <th colspan="1" class="text-center">Vacant GP</th>
            <th class="text-90deg-text">Completed</th>
            <th colspan="1" class="bg-warning-50 text-90deg-text">Pendency</th>
            <th colspan="1" class="bg-warning-50 text-90deg-text">Pendency</th>
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
            <th colspan="1" class="bg-warning-50 text-90deg-text"></th>
        </tr>

    </thead>  
    <tbody>
        <tr class="font-weight-bold bg-success-50">
            <td class="text-center bg-success-50">1</td>
            <td class="text-center bg-success-50">2</td>
            <td class="text-center bg-success-50">3</td>
            <td class="text-center bg-success-50">4</td> 
            <td class="text-center bg-success-50">5</td>
            <td class="text-center bg-success-50">6</td>       
            <td class="text-center bg-success-50">7</td>          
            <td class="text-center bg-success-50">8</td>
            <td class="text-center bg-success-50">8.a</td>
            <td class="text-center bg-success-50">8.b</td>
            <td class="text-center bg-success-50">9</td>
            <td class="text-center bg-success-50">10</td>
            <td class="text-center bg-success-50">11</td>
            <td class="text-center bg-success-50">12</td>
            <td class="text-center bg-success-50">13</td>
            <td class="text-center bg-success-50">14</td>
            <td class="text-center bg-success-50">15</td>
            <td class="text-center bg-success-50">16</td>
            <td class="text-center bg-success-50">17</td>
            <td class="text-center bg-success-50">18</td>
            <td class="text-center bg-success-50">19</td>
            <td class="text-center bg-success-50">20</td>   
            <td class="text-center bg-success-50">21</td>
            <td class="text-center bg-success-50">22</td>
            <td class="23 text-center bg-success-500">(Col. 12, 14 & 16)</td>
        </tr>
        <tr class="font-weight-bold bg-primary-50">
            <td class="1 text-center bg-primary-50"></td>
            <td class="2qq text-center bg-primary-50"><?= 'Uttar Pradesh' ?></td>
            <td class="3 text-center bg-primary-50"><?= BcCumulativeReportDistrict::getTotal($dataProvider->models, 'no_of_gp') ?></td>
            <td class="4 text-center bg-primary-50"><?= BcCumulativeReportDistrict::getTotal($dataProvider->models, 'no_of_bc_shortlisted') - BcCumulativeReportDistrict::getTotal($dataProvider->models, 'urban') ?></td> 

            <td class="5 text-center bg-primary-50"><?= MasterGramPanchayatDetailBc::findBySql("SELECT master_gram_panchayat.district_name,master_gram_panchayat.block_name,master_gram_panchayat.gram_panchayat_name,master_gram_panchayat.gram_panchayat_code  FROM `master_gram_panchayat_detail_bc`

join master_gram_panchayat on master_gram_panchayat.gram_panchayat_code=master_gram_panchayat_detail_bc.gram_panchayat_code

where master_gram_panchayat.status=1 and master_gram_panchayat_detail_bc.current_available>0 and master_gram_panchayat_detail_bc.current_status IN (-100,-2,32,4,5,6,34) and master_gram_panchayat_detail_bc.issue=0 
")->count() ?></td>
            <td class="6 text-center bg-primary-50"><?= MasterGramPanchayatDetailBc::findBySql("SELECT  master_gram_panchayat.district_name,master_gram_panchayat.block_name,master_gram_panchayat.gram_panchayat_name,master_gram_panchayat_detail_bc.six_vacant FROM `master_gram_panchayat_detail_bc`

join master_gram_panchayat on master_gram_panchayat.gram_panchayat_code=master_gram_panchayat_detail_bc.gram_panchayat_code

where master_gram_panchayat.status=1 and master_gram_panchayat_detail_bc.current_available=0 and master_gram_panchayat_detail_bc.current_status IN (-100,-2,32,4,5,6,34) and master_gram_panchayat_detail_bc.issue=0")->count() ?></td>

            <td class="7 text-center bg-primary-50"><?= BcCumulativeReportDistrict::getTotal($dataProvider->models, 'certified_bc') ?></td>
            <td class="8 text-center bg-primary-50"><a href="<?= $searchModel->district_select_base_url ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportDistrict::getTotal($dataProvider->models, 'no_of_bc_shortlisted') - (BcCumulativeReportDistrict::getTotal($dataProvider->models, 'no_of_bc_registered') + BcCumulativeReportDistrict::getTotal($dataProvider->models, 'agree') + BcCumulativeReportDistrict::getTotal($dataProvider->models, 'blocked_bc'))) ?></a></td>
            <td class="8 text-center bg-primary-50"><?= (BcCumulativeReportDistrict::getTotal($dataProvider->models, 'agree')) ?></td>
            <td class="8 text-center bg-primary-50"><a href="<?= $searchModel->district_in_batch_base_url ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportDistrict::getTotal($dataProvider->models, 'in_batch')) ?></a></td>
            <td class="9 text-center bg-primary-50"><?= BcCumulativeReportDistrict::getTotal($dataProvider->models, 'pvr') ?></td>
            <td class="10 text-center bg-primary-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[pendency]=pvr' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportDistrict::getTotal($dataProvider->models, 'certified_bc') - BcCumulativeReportDistrict::getTotal($dataProvider->models, 'pvr')) ?></a></td>
            <td class="11 text-center bg-primary-50"><?= BcCumulativeReportDistrict::getTotal($dataProvider->models, 'shg_assigned') ?></td>
            <td class="12 text-center bg-primary-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[pendency]=bc_shg_assigned' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportDistrict::getTotal($dataProvider->models, 'certified_bc') - BcCumulativeReportDistrict::getTotal($dataProvider->models, 'shg_assigned')) ?></a></td>
            <td class="13 text-center bg-primary-50"><?= BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_shg_bank_verified') ?></td>
            <td class="14 text-center bg-primary-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[pendency]=bc_shg_bank_verified' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportDistrict::getTotal($dataProvider->models, 'shg_assigned') - BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_shg_bank_verified')) ?></a></td>
            <td class="15 text-center bg-primary-50"><?= BcCumulativeReportDistrict::getTotal($dataProvider->models, 'pfms_mapping') ?></td>
            <td class="16 text-center bg-primary-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[pendency]=pfms_mapping' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_shg_bank_verified') - BcCumulativeReportDistrict::getTotal($dataProvider->models, 'pfms_mapping')) ?></a></td>
            <td class="17 text-center bg-primary-50"><?= BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_support_fund_shg_transfer') ?></td>
            <td class="18 text-center bg-primary-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[pendency]=bc_shg_support_fund' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportDistrict::getTotal($dataProvider->models, 'pfms_mapping') - BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_support_fund_shg_transfer')) ?></td>

            <td class="19 text-center bg-primary-50"><?= BcCumulativeReportDistrict::getTotal($dataProvider->models, 'handheld_machine_provided') ?></td>
            <td class="20 text-center bg-primary-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[pendency]=handheld_machine' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_support_fund_shg_transfer') - BcCumulativeReportDistrict::getTotal($dataProvider->models, 'handheld_machine_provided')) ?></a></td>

            <td class="21 text-center bg-primary-50"><?= BcCumulativeReportDistrict::getTotal($dataProvider->models, 'operational') ?></td>
            <td class="22 text-center bg-primary-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[pendency]=operational' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportDistrict::getTotal($dataProvider->models, 'handheld_machine_provided') - BcCumulativeReportDistrict::getTotal($dataProvider->models, 'operational')) ?></td>
            <td class="23 text-center bg-primary-50"><?= (BcCumulativeReportDistrict::getTotal($dataProvider->models, 'certified_bc') - BcCumulativeReportDistrict::getTotal($dataProvider->models, 'shg_assigned'))+(BcCumulativeReportDistrict::getTotal($dataProvider->models, 'shg_assigned') - BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_shg_bank_verified'))+(BcCumulativeReportDistrict::getTotal($dataProvider->models, 'bc_shg_bank_verified') - BcCumulativeReportDistrict::getTotal($dataProvider->models, 'pfms_mapping')) ?></td>
        </tr>
        <?php
        $sr_no = 1;
        foreach ($dataProvider->getModels() as $model) {
            ?>
            <tr>
                <td class="1 text-center"><?= $sr_no ?></td>
                <td class="2 text-center text-danger"><?=
                    Html::a($model->district_name, ['/report/cumulative/pendencydb?district_code=' . $model->district_code], [
                        'data-pjax' => "0",
                        'class'=>'text-danger'
                    ]);
                    ?></td>
                <td class="3 text-center"><?= $model->no_of_gp ?></td>
                <td colspan="1" class="4 text-center"><?= $model->no_of_bc_shortlisted - $model->urban ?></td>
                <td colspan="1" class="5 text-center"><?= MasterGramPanchayatDetailBc::findBySql("SELECT master_gram_panchayat.district_name,master_gram_panchayat.block_name,master_gram_panchayat.gram_panchayat_name,master_gram_panchayat.gram_panchayat_code  FROM `master_gram_panchayat_detail_bc`

join master_gram_panchayat on master_gram_panchayat.gram_panchayat_code=master_gram_panchayat_detail_bc.gram_panchayat_code

where master_gram_panchayat.status=1  and master_gram_panchayat.district_code=" . $model->district_code . "  and master_gram_panchayat_detail_bc.current_available>0 and master_gram_panchayat_detail_bc.current_status IN (-100,-2,32,4,5,6,34) and master_gram_panchayat_detail_bc.issue=0 
")->count() ?></td>
                <td colspan="1" class="6 text-center"><?= MasterGramPanchayatDetailBc::findBySql("SELECT  master_gram_panchayat.district_name,master_gram_panchayat.block_name,master_gram_panchayat.gram_panchayat_name,master_gram_panchayat_detail_bc.six_vacant FROM `master_gram_panchayat_detail_bc`

join master_gram_panchayat on master_gram_panchayat.gram_panchayat_code=master_gram_panchayat_detail_bc.gram_panchayat_code

where master_gram_panchayat.status=1 and master_gram_panchayat.district_code=" . $model->district_code . " and master_gram_panchayat_detail_bc.current_available=0 and master_gram_panchayat_detail_bc.current_status IN (-100,-2,32,4,5,6,34) and master_gram_panchayat_detail_bc.issue=0")->count() ?></td>

                <td class="7 text-center"><?= $model->certified_bc ?></td>
                <td colspan="1" class="8 text-center bg-warning-50"><a href="<?= $searchModel->district_select_base_url . '?DashboardSearchForm[district_code]=' . $model->district_code . '' ?>" data-pjax="0" target="_blank"><?= ($model->no_of_bc_shortlisted - ($model->no_of_bc_registered + $model->agree + $model->blocked_bc)) ?></a></td>
                <td colspan="1" class="8 text-center bg-warning-50"><a href="<?= $searchModel->district_select_base_url . '?DashboardSearchForm[district_code]=' . $model->district_code . '' ?>" data-pjax="0" target="_blank"><?= ($model->agree) ?></a></td>
                <td colspan="1" class="8 text-center bg-warning-50"><a href="<?= $searchModel->district_in_batch_base_url . '?DashboardSearchForm[district_code]=' . $model->district_code . '' ?>" data-pjax="0" target="_blank"><?=($model->in_batch) ?></a></td>

                <td colspan="1" class="9 text-center"><?= $model->pvr ?></td>
                <td colspan="1" class="10 text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[pendency]=pvr' ?>" data-pjax="0" target="_blank"><?= ($model->certified_bc - $model->pvr) ?></a></td>

                <td colspan="1" class="11 text-center"><?= $model->shg_assigned ?></td>
                <td colspan="1" class="12 text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[pendency]=bc_shg_assigned' ?>" data-pjax="0" target="_blank"><?= ($model->certified_bc - $model->shg_assigned) ?></a></td>
                <td colspan="1" class="13 text-center"><?= $model->bc_shg_bank_verified ?></td>
                <td colspan="1" class="14 text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[pendency]=bc_shg_bank_verified' ?>" data-pjax="0" target="_blank"><?= ($model->shg_assigned - $model->bc_shg_bank_verified) ?></a></td>
                <td colspan="1" class="15 text-center"><?= $model->pfms_mapping ?></td>
                <td colspan="1" class="16 text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[pendency]=pfms_mapping' ?>" data-pjax="0" target="_blank"><?= ($model->bc_shg_bank_verified - $model->pfms_mapping) ?></a></td>

                <td colspan="1" class="17 text-center"><?= $model->bc_support_fund_shg_transfer ?></td>
                <td colspan="1" class="18 text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[pendency]=bc_shg_support_fund' ?>" data-pjax="0" target="_blank"><?= ($model->pfms_mapping - $model->bc_support_fund_shg_transfer) ?></a></td>

                <td colspan="1" class="19 text-center"><?= $model->handheld_machine_provided ?></td>
                <td colspan="1" class="20 text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[pendency]=handheld_machine' ?>" data-pjax="0" target="_blank"><?= ($model->bc_support_fund_shg_transfer - $model->handheld_machine_provided) ?></a></td>

                <td colspan="1" class="21 text-center"><?= $model->operational ?></td>
                <td colspan="1" class="22 text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[pendency]=operational' ?>" data-pjax="0" target="_blank"><?= ($model->handheld_machine_provided - $model->operational) ?></a></td></td>
                <td colspan="1" class="23 text-center"><?= ($model->certified_bc - $model->shg_assigned)+($model->shg_assigned - $model->bc_shg_bank_verified)+($model->bc_shg_bank_verified - $model->pfms_mapping) ?></td>
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