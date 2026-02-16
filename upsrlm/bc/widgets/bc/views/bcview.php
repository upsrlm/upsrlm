<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\User;
use yii\bootstrap4\Modal;
use miloschuman\highcharts\Highcharts;
use common\models\master\MasterRole;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">

                    <div class="col-xl-12 mt-3">
                        <div class="row ">
                            <div class="col-md-12 col-lg-4 col-xl-3 mb-3">
                                <div class="service-item h-100">
                                    <?= $model->bc->profile_photo != null ? '<span class="profile-picture">
                                        <img width="100%"  src="' . Yii::$app->params['baseurl_bc_image'] . $model->bc->profile_photo_url . '" data-src="' . Yii::$app->params['baseurl_bc_image'] . $model->bc->profile_photo_url . '"  class="lozad" title="profile_photo" style="cursor : pointer"/>
                                        </span> ' : '-' ?>
                                    <div class="down-content">
                                        <h4><a href="/report/topbc/bcview?bcid=<?= $model->bc->id ?>" class="text-info"><?= isset($model->bc->name) ? $model->bc->name : '' ?></a></h4>
                                        <p>Commission Earned : <strong> <?= '<i class="fa fa-inr"></i> ' . common\helpers\Utility::numberIndiaStyle($model->commission_amount) ?></strong></p>
                                        <p><?= isset($model->bc) ? $model->bc->district_name . ' / ' . $model->bc->block_name . ' / ' . $model->bc->gram_panchayat_name : '' ?></p>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12 col-lg-8 col-xl-9">
                                <div class="row">
                                    <div class="col-xl-4 ">
                                        <iframe src="<?= $model->gp_map_url ?>&zoom=1" width="100%" height="285" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>

                                    <div class="col-xl-8 pb-1">
                                        <h3 class="pb-lg-0 padding-set" style="font-size: 22px;">Over All Performance of BCs</h3>
                                        <div class="table-responsive border ">
                                            <table class="table w-100 table-striped">
                                                <tr>
                                                    <th>BC Operation started on</th>
                                                    <td> <?= $model->transaction_start_date ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total operational days</th>
                                                    <td> <?= $model->total_day ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total working days</th>
                                                    <td> <?= $model->total_working_day ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total no. of banking txn.</th>
                                                    <td><?= common\helpers\Utility::numberIndiaStyle($model->no_of_transaction) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total value of banking txn.</th>
<!--                                                    <td><?= $model->transaction_amount ?></td>-->
                                                    <td><?= '<i class="fa fa-inr"></i> ' . common\helpers\Utility::numberIndiaStyle($model->transaction_amount) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total earning as commission</th>
<!--                                                    <td><?= $model->commission_amount ?></td>-->
                                                    <td><?= '<i class="fa fa-inr"></i> ' . common\helpers\Utility::numberIndiaStyle($model->commission_amount) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Txn. start (Month)</th>
                                                    <td><?= $model->start_month_name ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Txn. latest reported (Month)</th>
                                                    <td><?= $model->last_month_name ?></td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 border">
                                        <h3 class="pb-0" style="font-size: 22px;">Monthly :  Commission Earned</h3>
                                        <?php
                                        $category1 = ArrayHelper::getColumn($report, 'month');
                                        $annotation_label = $annotation_label;
                                        
                                        //$bcData = ['name' => 'No. of BC operational', 'type' => 'column', 'yAxis' => 1, 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'no_of_bc'))))];
                                        //$comData = ['name' => 'Commistion Earned', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ' Rs'], 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'commission_amount'))))];
                                        $comData = [
                                            'name' => 'Commistion Earned',
                                            //'type' => 'spline',
                                            //'tooltip' => ['valueSuffix' => ' Rs'],
                                            'data' => $annotation_data
                                            ];
//                                        echo "<pre>";
//                                        print_r($category1);exit;
                                        echo Highcharts::widget([
                                            'scripts' => [
                                                'highcharts-more',
                                                'modules/annotations',
//                                                'modules/exporting',
//                                                'modules/export-data',
//                                                'themes/grid',
                                            ],
                                            'options' => [
                                                'chart' => [
                                                    'zoomType' => 'x',
                                                    'height' => 300,
//                                                    'type' => 'area',
                                                    'panning' => true,
                                                    'panKey' => 'shift',
                                                    'scrollablePlotArea' => [
                                                        'minWidth' => 600
                                                    ]
                                                ],
                                                'exporting' => [
                                                    'enabled' => false,
//                                                    'buttons' => [
//                                                        'contextButton' => [
//                                                            'menuItems' => ['downloadPNG', 'downloadPDF', 'downloadCSV']
//                                                        ]
//                                                    ]
                                                ],
                                                'credits' => [
                                                    'enabled' => false,
                                                ],
                                                'title' => [
                                                    'text' => '',
                                                ],
//                                                'lang' => [
//                                                    'accessibility' => [
//                                                        'screenReaderSection' => [
//                                                            'annotations' => [
//                                                                'descriptionNoPoints' => '{annotationText}, at distance 
//                                                                {annotation.options.point.x}, elevation 
//                                                               {annotation.options.point.y} meters.'
//                                                            ]
//                                                        ]
//                                                    ]
//                                                ],
                                                'subtitle' => [
                                                    'text' => '',
                                                    'margin' => 0,
                                                ],
                                                'xAxis' => [
                                                    'categories' => $category1,
                                                    'title' => [
                                                        'text' => '',
                                                    ],
                                                    'crosshair' => true,
                                                ],
                                                'yAxis' => [
                                                    'startOnTick' => true,
                                                    'endOnTick' => false,
                                                    'maxPadding' => 0.35,
                                                    [
                                                        'labels' => ['format' => '{value} Rs'],
                                                        'title' => [
                                                            'text' => '',
                                                        ],
                                                        'opposite' => false,
                                                    ],
                                                ],
                                                'tooltip' => [
                                                    'shared' => true
                                                ],
                                                'legend' => false,
                                                'series' => [$comData],
                                                'annotations' => [[
                                                'draggable' => '',
                                                'labelOptions' => [
                                                    'backgroundColor' => 'rgba(255,255,255,0.5)',
                                                    'verticalAlign' => 'top',
                                                    'y' => 15
                                                ],
                                                'labels' => $annotation_label
                                                    ]]
                                            ],
                                        ]);
                                        ?>

                                    </div>
                                    <div class="col-lg-12">
                                        <div class="desclaimer py-3">
                                            <p><Strong>Disclaimer: </Strong>  BC Sakhi is a doorstep facility to deliver banking services to rural customers. The depictions on the portal aim to encourage all BC Sakhis to pursue high level of performance in their respective gram panchayats, as achieved in these cases.</p>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>  
<div class=" clearfix"></div>
<?php
$js = <<<JS
observer = lozad('.lozad', {
load: function (el) {
el.src = el.getAttribute('data-src');
$(el).elevateZoom({
scrollZoom: true,
responsive: true,
zoomWindowOffetx: -600
});

}
}); 
observer.observe();     
        
JS;
$this->registerJs($js);
?>
<?php
$css = <<<cs
 .table td, .table th {
  padding: 3px;
  
}
cs;
$this->registerCss($css);
?>