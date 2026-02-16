<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
use bc\models\BcCumulativeReportBlockPartnerBank;
use bc\models\master\MasterGramPanchayatDetailBc;
use bc\modules\selection\models\BcGramPanchayat;
?>
<table id='report' class="table table-striped  table-bordered tbl_sort">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">District</th>
            <th class="text-center">GP</th>
            <th colspan="1" class="text-center">Shortlisted</th>
            <th colspan="1" class="text-center">Standby GP</th>
            <th colspan="1" class="text-center">Vacant GP</th>
            <th colspan="2" class="text-center">Certified BC</th>
            <th colspan="2" class="text-center">PVR</th>
            <th colspan="2" class="text-center">BC-SHG assigned</th>
            <th colspan="2" class="text-center">BC & SHG bank a/c verified</th>
            <th colspan="2" class="text-center">SHG PFMS mapping</th>
            <th colspan="2" class="text-center">BC-support fund (SHG)</th>
            <th colspan="2" class="text-center">Handheld machine provided</th>
            <th colspan="2" class="text-center">Operational</th>

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
            <td class="text-center bg-primary-50">Uttar Pradesh</td>
            <td class="text-center bg-primary-50">
                <?= BcGramPanchayat::getTotal($searchModel, 'gp', 'district_code') ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= BcGramPanchayat::getTotal($searchModel, 'bc_shortlist', 'district_code') ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= BcGramPanchayat::getTotal($searchModel, 'standbc', 'district_code') ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= BcGramPanchayat::getTotal($searchModel, 'vacantgp', 'district_code') ?>
            </td>

            <td class="text-center bg-primary-50">
                <?= BcGramPanchayat::getTotal($searchModel, 'certified_bc', 'district_code') ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= BcGramPanchayat::getTotal($searchModel, 'certified_bc_pen', 'district_code') ?>
            </td>

            <td class="text-center bg-primary-50">
                <?= BcGramPanchayat::getTotal($searchModel, 'pvr', 'district_code') ?>
            </td>
            <td class="text-center bg-primary-50">
               <?= BcGramPanchayat::getTotal($searchModel, 'pvr_pen', 'district_code') ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= BcGramPanchayat::getTotal($searchModel, 'shg', 'district_code') ?>
            </td>
            <td class="text-center bg-primary-50">
               <?= BcGramPanchayat::getTotal($searchModel, 'shg_pen', 'district_code') ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= BcGramPanchayat::getTotal($searchModel, 'bc_shg_bank', 'district_code') ?>
            </td>
            <td class="text-center bg-primary-50">
               <?= BcGramPanchayat::getTotal($searchModel, 'bc_shg_bank_pen', 'district_code') ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= '' ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= '' ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= '' ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= '' ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= '' ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= '' ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= '' ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= '' ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= '' ?>
            </td>
            <td class="text-center bg-primary-50">
                <?= '' ?>
            </td>

        </tr>
        <?php
        $sr_no = 1;
        foreach ($dataProvider->getModels() as $model) {
            $model->master_partner_bank_id = $searchModel->master_partner_bank_id;
            ?>
            <tr>
                <td class="text-center"><?= $sr_no ?></td>

                <td class="text-center"><?php
                    echo Html::a($model->district_name, ['/report/pendency/block?district_code=' . $model->district_code . ''], [
                        'data-pjax' => "0",
                    ]);
                    ?>
                </td>
                <td class="text-center">
                    <?= BcGramPanchayat::getTotal($model, 'gp', 'district_code') ?>
                </td>
                <td colspan="1" class="text-center">
                    <?= BcGramPanchayat::getTotal($model, 'bc_shortlist', 'district_code') ?>
                </td>

                <td colspan="1" class="text-center">
                    <?= BcGramPanchayat::getTotal($model, 'standbc', 'district_code') ?>
                </td>
                <td colspan="1" class="text-center">
                    <?= BcGramPanchayat::getTotal($model, 'vacantgp', 'district_code') ?>
                </td>

                <td class="text-center">
                    <?= BcGramPanchayat::getTotal($model, 'certified_bc', 'district_code') ?>
                </td>
                <td colspan="1" class="text-center bg-warning-50">
                    <?= BcGramPanchayat::getTotal($model, 'certified_bc_pen', 'district_code') ?>
                </td>

                <td colspan="1" class="text-center">
                            <?= BcGramPanchayat::getTotal($model, 'pvr', 'district_code') ?>
                </td>
                <td colspan="1" class="text-center bg-warning-50">
                   <?= BcGramPanchayat::getTotal($model, 'pvr_pen', 'district_code') ?>
                </td>

                <td colspan="1" class="text-center">
                            <?= BcGramPanchayat::getTotal($model, 'shg', 'district_code') ?>
                </td>
                <td colspan="1" class="text-center bg-warning-50">
                   <?= BcGramPanchayat::getTotal($model, 'shg_pen', 'district_code') ?>
                </td>
                <td colspan="1" class="text-center">
                            <?= BcGramPanchayat::getTotal($model, 'bc_shg_bank', 'district_code') ?>
                </td>
                <td colspan="1" class="text-center bg-warning-50">
                   <?= BcGramPanchayat::getTotal($model, 'bc_shg_bank_pen', 'district_code') ?>
                </td>
                <td colspan="1" class="text-center"><?= '' ?></td>
                <td colspan="1" class="text-center bg-warning-50">
                    <?= '' ?>
                </td>
                <td colspan="1" class="text-center"><?= '' ?></td>
                <td colspan="1" class="text-center bg-warning-50">
                    <?= '' ?>
                </td>
                <td colspan="1" class="text-center"><?= '' ?></td>
                <td colspan="1" class="text-center bg-warning-50">
                    <?= '' ?>
                </td>
                <td colspan="1" class="text-center"><?= '' ?></td>
                <td colspan="1" class="text-center bg-warning-50">
                    <?= '' ?>
                </td>
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