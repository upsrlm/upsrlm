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
            <th class="text-center">Block</th>
            <th class="text-center">GP</th>
            <th colspan="1" class="text-center">Shortlisted</th>
            <th colspan="4" class="text-center">Certified BC</th>


        </tr>
        <tr>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th colspan="1" class="text-center">Shortlisted</th>

            <th class="text-center">Certified BC</th>
            <th colspan="1" class="text-center bg-warning-50">Pendency</th>
            <th colspan="1" class="text-center bg-warning-50">Agree</th>
            <th colspan="1" class="text-center bg-warning-50">In Batch</th>

        </tr>
    </thead>  
    <tbody>
        <tr class="font-weight-bold bg-primary-50">
            <td class="text-center"></td>
            <td class="text-center bg-primary-50"><?= $dis_model->district_name ?></td>
            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'no_of_gp') ?></td>
            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'no_of_bc_shortlisted') - BcCumulativeReportBlock::getTotal($dataProvider->models, 'urban') ?></td> 

            <td class="text-center bg-primary-50"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'certified_bc') ?></td>
            <td class="text-center bg-primary-50"><a href="<?= $searchModel->district_select_base_url. '?DashboardSearchForm[district_code]=' . $dis_model->district_code  ?>" data-pjax="0" target="_blank"><?= (BcCumulativeReportBlock::getTotal($dataProvider->models, 'no_of_bc_shortlisted') - (BcCumulativeReportBlock::getTotal($dataProvider->models, 'no_of_bc_registered') + BcCumulativeReportBlock::getTotal($dataProvider->models, 'agree') + BcCumulativeReportBlock::getTotal($dataProvider->models, 'blocked_bc'))) ?></a></td>
            <td class="text-center bg-primary-50"><a href="<?= $searchModel->district_in_batch_base_url. '?DashboardSearchForm[district_code]=' . $dis_model->district_code  ?>" data-pjax="0" target="_blank"><?= BcCumulativeReportBlock::getTotal($dataProvider->models, 'agree') ?></a></td>
        </tr>
        <?php
        $sr_no = 1;
        foreach ($dataProvider->getModels() as $model) {
            ?>
            <tr>
                <td class="text-center"><?= $sr_no ?></td>
                <td class="text-center"><?= $model->block_name ?></td>
                <td class="text-center"><?= $model->no_of_gp ?></td>
                <td colspan="1" class="text-center"><?= $model->no_of_bc_shortlisted - $model->urban ?></td>
                <td class="text-center"><?= $model->certified_bc ?></td>

                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_select_base_url. '?DashboardSearchForm[district_code]=' . $dis_model->district_code . '&DashboardSearchForm[block_code]='.$model->block_code ?>" data-pjax="0" target="_blank"><?= ($model->no_of_bc_shortlisted - ($model->no_of_bc_registered + $model->agree + $model->blocked_bc)) ?></a></td>
                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_select_base_url. '?DashboardSearchForm[district_code]=' . $dis_model->district_code . '&DashboardSearchForm[block_code]='.$model->block_code ?>" data-pjax="0" target="_blank"><?= ($model->agree) ?></a></td>
                <td colspan="1" class="text-center bg-warning-50"><a href="<?= $searchModel->district_in_batch_base_url. '?DashboardSearchForm[district_code]=' . $dis_model->district_code . '&DashboardSearchForm[block_code]='.$model->block_code ?>" data-pjax="0" target="_blank"><?= ($model->in_batch) ?></a></td>
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