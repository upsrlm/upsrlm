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


        </tr>
        <tr>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th colspan="1" class="text-center">Shortlisted</th>

            <th class="text-center">Certified BC</th>
            <th colspan="1" class="text-center bg-warning-50">Pendency</th>


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
            <td class="text-center bg-primary-50"><?= (BcCumulativeReportBlock::getTotal($dataProvider->models, 'no_of_bc_shortlisted') - (BcCumulativeReportBlock::getTotal($dataProvider->models, 'no_of_bc_registered') + BcCumulativeReportBlock::getTotal($dataProvider->models, 'agree') + BcCumulativeReportBlock::getTotal($dataProvider->models, 'blocked_bc'))) ?></td>

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

                <td colspan="1" class="text-center bg-warning-50"><?= ($model->no_of_bc_shortlisted - ($model->no_of_bc_registered + $model->agree + $model->blocked_bc)) ?></td>

            </tr>
            <?php
            $sr_no++;
        }
        ?>
    </tbody>


</table>   