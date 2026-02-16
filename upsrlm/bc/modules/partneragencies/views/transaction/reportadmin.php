<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\User;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel bc\models\transaction\BcTransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "BC's Transactions file upload report";
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>

            </div>
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


                    <?php echo $this->render('_radminsearch', ['model' => $searchModel]); ?>
                    <button id="exportBtn1" class="btn  btn-info float-right"> <i class="fal fa-file-excel" style="color: red"> </i> Export To Excel</button>
                    <div class="clearfix pt-6"></div>
                    <table id='report' class="table table-striped  table-bordered tbl_sort">
                        <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">Bank Of Baroda</th>
                                <th class="text-center">FINO Payment Bank</th>
                                <th class="text-center">Nearby Technologies Pvt. Ltd.</th>
                                <th class="text-center">Manipal Technologies Limited</th>
                                <th class="text-center">MFSL-Airtel-GVI Consortia</th>
                                <th class="text-center">Paytm Payment Bank</th>
                                <th class="text-center">State Bank of India</th>
                            </tr>
                        </thead>  
                        <tbody>
                            <?php
                            $sr_no = 1;
                            foreach ($dataProvider as $data) {
                                ?>
                                <tr>

                                    <td class="text-center"><?= $data[0] ?></td>
                                    <td class="text-center"><?= $data[1] ?></td>
                                    <td class="text-center"><?= $data[2] ?></td>
                                    <td class="text-center"><?= $data[3] ?></td>
                                    <td class="text-center"><?= $data[4] ?></td>
                                    <td class="text-center"><?= $data[5] ?></td>
                                    <td class="text-center"><?= $data[6] ?></td>
                                    <td class="text-center"><?= $data[7] ?></td>
                                </tr>
                                <?php
                                $sr_no++;
                            }
                            ?>
                        </tbody>
                    </table> 

                    <?php
                    $script = <<< JS
          $(document).ready(function () {
      $("#exportBtn1").click(function(){
        TableToExcel.convert(document.getElementById("report"), {
            name: "Transaction daily file upload monitoring.xlsx",
            sheet: {
            name: "Sheet1"
            }
          });
        });
       });      
JS;
                    $this->registerJs($script);
                    ?>
                    <?php
                    $script = <<< JS
    $('form select').on('change', function(){
    $(this).closest('form').submit();
});            
JS;
                    $this->registerJs($script);
                    ?>

                    <?php Pjax::end(); ?>
                </div>
            </div> 
        </div>
    </div>
</div>
