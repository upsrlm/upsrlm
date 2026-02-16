<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\models\BcCumulativeReportDistrictPartnerBank;
?>
<table id='report' class="table table-striped  table-bordered tbl_sort">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">District</th>
            <th class="text-center">GP</th>
            <th colspan="1" class="text-center">Shortlisted</th>
            <th colspan="2" class="text-center">Certified BC</th>
            <th colspan="2" class="text-center">PVR</th>
            <th colspan="2" class="text-center">BC-support fund (SHG)</th>
            <th colspan="2" class="text-center">Handheld machine provided</th>
            <th colspan="2" class="text-center">Operational</th>

        </tr>
        <tr>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th colspan="1" class="text-center">Shortlisted</th>

            <th class="text-center">Certified BC</th>
            <th colspan="1" class="text-center bg-warning-50">Pendency</th>
            <th colspan="1" class="text-center">PVR</th>
            <th colspan="1" class="text-center bg-warning-50">Pendency</th>

            <th colspan="1" class="text-center">BC-support fund (SHG)</th>
            <th colspan="1" class="text-center bg-warning-50">Pendency</th>
            <th colspan="1" class="text-center">Handheld machine provided</th>
            <th colspan="1" class="text-center bg-warning-50">Pendency</th>
            <th colspan="1" class="text-center">Operational</th>
            <th colspan="1" class="text-center bg-warning-50">Pendency</th>
        </tr>
    </thead>  
    <tbody>
        <tr class="font-weight-bold bg-primary-50">
            <td class="text-center"></td>
            <td class="text-center bg-primary-50"><?= 'Uttar Pradesh' ?></td>
            <td class="text-center bg-primary-50"><?= BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'no_of_gp') ?></td>
            <td class="text-center bg-primary-50"><?= BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'no_of_bc_shortlisted') - BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'urban') ?></td> 

            <td class="text-center bg-primary-50"><?= BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'certified_bc') ?></td>
            <td class="text-center bg-primary-50"><?= (BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'no_of_bc_shortlisted') - (BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'no_of_bc_registered') + BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'agree') + BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'blocked_bc'))) ?></td>

            <td class="text-center bg-primary-50"><?= BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'pvr') ?></td>
            <td class="text-center bg-primary-50"><?= (BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'certified_bc') - BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'pvr')) ?></td>

            <td class="text-center bg-primary-50"><?= BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'bc_support_fund_shg_transfer') ?></td>
            <td class="text-center bg-primary-50"><?= (BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'pfms_mapping') - BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'bc_support_fund_shg_transfer')) ?></td>

            <td class="text-center bg-primary-50"><?= BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'handheld_machine_provided') ?></td>
            <td class="text-center bg-primary-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[master_partner_bank_id]=' . $searchModel->master_partner_bank_id . '&RsetisBatchParticipantsSearch[pendency]=handheld_machine' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'bc_support_fund_shg_transfer') - BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'handheld_machine_provided')) ?></td>

            <td class="text-center bg-primary-50"><?= BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'operational') ?></td>
            <td class="text-center bg-primary-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[master_partner_bank_id]=' . $searchModel->master_partner_bank_id . '&RsetisBatchParticipantsSearch[pendency]=operational' ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'handheld_machine_provided') - BcCumulativeReportDistrictPartnerBank::getTotal($dataProvider->models, 'operational')) ?></a></td>
        </tr>
        <?php
        $sr_no = 1;
        foreach ($dataProvider->getModels() as $model) {
            ?>
            <tr>
                <td class="text-center"><?= $sr_no ?></td>
    <!--                <td class="text-center"><?= $model->district_name ?></td>-->
                <td class="text-center"><?php
                    echo Html::a($model->district_name, ['/report/cumulative/pendencydb?district_code=' . $model->district_code . '&master_partner_bank_id=' . $model->master_partner_bank_id], [
                        'data-pjax' => "0",
                    ]);
                    ?>
                </td>
                <td class="text-center"><?= $model->no_of_gp ?></td>
                <td colspan="1" class="text-center"><?= $model->no_of_bc_shortlisted - $model->urban ?></td>

                <td class="text-center"><?= $model->certified_bc ?></td>
                <td colspan="1" class="text-center bg-warning-50"><?= ($model->no_of_bc_shortlisted - ($model->no_of_bc_registered + $model->agree + $model->blocked_bc)) ?></td>

                <td colspan="1" class="text-center"><?= $model->pvr ?></td>
                <td colspan="1" class="text-center bg-warning-50"><?= ($model->certified_bc - $model->pvr) ?></td>

                <td colspan="1" class="text-center"><?= $model->bc_support_fund_shg_transfer ?></td>
                <td colspan="1" class="text-center bg-warning-50"><?= ($model->pfms_mapping - $model->bc_support_fund_shg_transfer) ?></td>

                <td colspan="1" class="text-center"><?= $model->handheld_machine_provided ?></td>
                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[master_partner_bank_id]=' . $model->master_partner_bank_id . '&RsetisBatchParticipantsSearch[pendency]=handheld_machine' ?>" data-pjax="0" target="_blank"><?= ($model->bc_support_fund_shg_transfer - $model->handheld_machine_provided) ?></a></td>


                <td colspan="1" class="text-center"><?= $model->operational ?></td>
                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_base_url . '?RsetisBatchParticipantsSearch[district_code]=' . $model->district_code . '&RsetisBatchParticipantsSearch[master_partner_bank_id]=' . $model->master_partner_bank_id . '&RsetisBatchParticipantsSearch[pendency]=operational' ?>" data-pjax="0" target="_blank"><?= ($model->handheld_machine_provided - $model->operational) ?></a></td>

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

        .coll{
        width:10% !important;
        }
cs;
$this->registerCss($css);
?>  