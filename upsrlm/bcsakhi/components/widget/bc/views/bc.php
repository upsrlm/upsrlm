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
                    <?php
                    Pjax::begin([
                        'id' => 'grid-data',
                        'enablePushState' => FALSE,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                    ]);
                    ?>
                    <div class="col-xl-12 mt-3">
                        <div class="row px-4">

                            <div class="col-xl-4 col-lg-4 col-md-6 mb-3 ">
                                <div class="for_box card">
                                    <div class="card-body">
                                        <?= $model->bc->profile_photo != null ? '<span class="profile-picture profile_img">
                                        <img  src="' . Yii::$app->params['baseurl_bc_image'] . $model->bc->profile_photo_url . '" data-src="' . Yii::$app->params['baseurl_bc_image'] . $model->bc->profile_photo_url . '"  class="lozad img-fluid" title="profile_photo" style="cursor : none"/>
                                        </span> ' : '-' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-3 ">
                                <div class="for_box card title_set h-100">
                                    <div class="card-body">
<!--                                        <h3><?= isset($model->bc) ? $model->bc->district_name . ' / ' . $model->bc->block_name . ' / ' . $model->bc->gram_panchayat_name : '' ?></h3>-->
                                        <h4><small class="m-0 ">District : </small> <?=$model->bc->district_name?></h4>
                                        <h4><small class="m-0 ">Block : </small> <?=$model->bc->block_name?></h4>
                                        <h4><small class="m-0 ">Gram Panchayat : </small> <?=$model->bc->gram_panchayat_name?></h4>
                                        <h4><small class="m-0 ">Certified Date : </small> <?=\Yii::$app->formatter->asDatetime($model->bc->iibf_date, "php:d-m-Y")?></h4>
                                        <h4><small class="m-0 ">Operational Date : </small> <?=\Yii::$app->formatter->asDatetime($model->transaction_start_date, "php:d-m-Y")?></h4>
<!--                                        <h4><small class="m-0 ">Total day : </small> <?=$model->total_day?></h4>-->
                                        <h4><small class="m-0 ">Total Working Day : </small> <?=$model->total_working_day?></h4>
                                        <h4><small class="m-0 ">Total no. of Txn : </small> <?php
                                                                                            if (isset($dataProvider))
                                                                                                echo common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('no_of_transaction'));
                                                                                            ?></h4>
                                        <h4> <small class="m-0 ">Total Transaction Amount : </small> <?php
                                                                                                    if (isset($dataProvider))
                                                                                                        echo '<i class="fa fa-inr"></i> ' . common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('transaction_amount'));
                                                                                                    ?></h4>
                                        <h4>
                                            <small class="m-0 ">Total Commission Earned : </small>
                                            <?php
                                            if (isset($dataProvider))
                                                echo '<i class="fa fa-inr"></i> ' . common\helpers\Utility::numberIndiaStyle($dataProvider->query->sum('commission_amount'));
                                            ?>

                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-3 ">
                                <div class="for_box card">
                                    <div class="card-body">
                                        <?= $model->bc->iibf_photo_file_name != null ? '<span class="profile-picture certificate_img">
                                        <img  src="' . Yii::$app->params['baseurl_bc_image'] . $model->bc->iibf_photo_url . '" data-src="' . Yii::$app->params['baseurl_bc_image'] . $model->bc->iibf_photo_url . '"  class="img-responsive img-fluid lozad" title="IIBF Certificate" style="cursor : none"/>
                                        </span> ' : '-' ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 mt-3">
                        <div class="row p-4">
                            <div class="col-lg-12">
                                <?php
                                $category1 = ArrayHelper::getColumn($report, 'month');
                                //$bcData = ['name' => 'No. of BC operational', 'type' => 'column', 'yAxis' => 1, 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'no_of_bc'))))];
                                $comData = ['name' => 'Commistion Earned', 'type' => 'spline', 'tooltip' => ['valueSuffix' => ' Rs'], 'data' => array_map('intval', explode(',', implode(',', yii\helpers\ArrayHelper::getColumn($report, 'commission_amount'))))];
                                echo Highcharts::widget([
                                    'scripts' => [
                                        'highcharts-more',
                                        'modules/exporting',
                                        'modules/export-data',
                                        'themes/grid',
                                    ],
                                    'options' => [
                                        'chart' => [
                                            'zoomType' => 'xy',
                                        ],
                                        'exporting' => [
                                            'buttons' => [
                                                'contextButton' => [
                                                    'menuItems' => ['downloadPNG', 'downloadPDF', 'downloadCSV']
                                                ]
                                            ]
                                        ],
                                        'credits' => [
                                            'enabled' => false,
                                        ],
                                        'title' => [
                                            'text' => 'Monthly :  commission earned',
                                        ],
                                        'subtitle' => [
                                            'text' => '',
                                            'margin' => 0,
                                        ],
                                        'xAxis' => [
                                            'categories' => $category1,
                                            'title' => [
                                                'text' => 'Month',
                                            ],
                                            'crosshair' => true,
                                        ],
                                        'yAxis' => [
                                            [
                                                'labels' => ['format' => '{value} Rs'],
                                                'title' => [
                                                    'text' => 'Commisstion Earned',
                                                ],
                                                'opposite' => true,
                                            ],
                                        ],
                                        'tooltip' => [
                                            'shared' => true
                                        ],
                                        'legend' => [
                                            'layout' => 'vertical',
                                            'align' => 'left',
                                            'x' => 120,
                                            'verticalAlign' => 'top',
                                            'y' => 100,
                                            'floating' => true,
                                        ],
                                        //                        'plotOptions' => [
                                        //                            'column' => [
                                        //                                'pointPadding' => 0.2,
                                        //                                'borderWidth' => 0
                                        //                            ],
                                        //                        ],
                                        'series' => [$comData]
                                    ],
                                ]);
                                ?>

                            </div>
                            <div class="col-lg-12 py-4 cstm-table">
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'layout' => "{items}\n{pager}\n{summary}",
                                'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                                'id' => 'grid-data',
                                'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                                'pjax' => TRUE,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn', 'header' => 'Srl.No.',],
                                    [
                                        'attribute' => 'month',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return isset($model->month_start_date) ? \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y") : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'master_partner_bank_id',
                                        'visible' => 0,
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return isset($model->pbank) ? $model->pbank->bank_short_name : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'total_working_day',
                                        'header' => "No. of days worked in the month",
                                        'enableSorting' => false,
                                        'value' => function ($model) {
                                            return isset($model->total_working_day) ? $model->total_working_day : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'no_of_transaction',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return isset($model->no_of_transaction) ? $model->no_of_transaction : '';
                                        }
                                    ],
                                    //                                    [
                                    //                                        'attribute' => 'zero_transaction',
                                    //                                        'header' => 'Zero Amount transaction',
                                    //                                        'enableSorting' => false,
                                    //                                        'value' => function ($model) {
                                    //                                            return isset($model->zero_transaction) ? $model->zero_transaction : '';
                                    //                                        }
                                    //                                    ],
                                    [
                                        'attribute' => 'transaction_amount',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return '<i class="fal fa fa-rupee-sign"></i> ' . $model->transaction_amount;
                                        }
                                    ],
                                    [
                                        'attribute' => 'commission_amount',
                                        'enableSorting' => false,
                                        'format' => 'raw',
                                        'contentOptions' => ['class' => 'text-right'],
                                        'value' => function ($model) {
                                            return isset($model->commission_amount) ? '<i class="fal fa fa-rupee-sign"></i> ' . common\helpers\Utility::numberIndiaStyle($model->commission_amount, 2) : '';
                                        }
                                    ],
                                ],
                            ]);
                            ?>
                        </div> 
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
    </div>
    <div class=" clearfix"></div>
    <?php
$js = <<<JS
             
        observer = lozad('.lozad', {
                                        load: function (el) {
                                            console.log('loading element');
                                            el.src = el.getAttribute('data-src');
                                            // Custom implementation to load an element
                                            // e.g. el.src = el.getAttribute('data-src');

                
                
                                                $(el).elevateZoom({
                                                    scrollZoom: true,
                                                    responsive: true,
                                                    zoomWindowOffetx: -600
                                                });


                                        }
                                    }); // lazy loads elements with default selector as '.lozad'
                                    observer.observe();     
        
JS;
$this->registerJs($js);
?> 
<?php
$css = <<<cs

.cstm-table .kv-table-header{
	background: #a4c639;
    color: #fff;
}
cs;
$this->registerCss($css);
?>