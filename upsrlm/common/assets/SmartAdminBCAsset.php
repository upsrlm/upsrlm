<?php

namespace common\assets;

use yii;
use yii\web\AssetBundle;

class SmartAdminBCAsset extends AssetBundle {

    public $sourcePath = '@common/themes/smartadmin/assets/';
    public $css = [
        'css/vendors.bundle.css',
        'css/app.bundle.css',
        'css/datagrid/datatables/datatables.bundle.css',
        'css/upsrlm.css',
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
    public $js = [
        'js/vendors.bundle.js',
        'js/app.bundle.js',
        'js/custom.js',
        'js/jquery.elevatezoom.js',
        'js/lozad.min.js',
        'js/datagrid/datatables/datatables.bundle.js',
        //'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js'
//        'https://code.highcharts.com/highcharts.js',
//        'https://code.highcharts.com/stock/highstock.js',
//        'https://code.highcharts.com/highcharts-3d.js',
//        'https://code.highcharts.com/modules/data.js',
//        'https://code.highcharts.com/modules/drilldown.js',
//    
//        'https://code.highcharts.com/highcharts-more.js',
//        'https://code.highcharts.com/modules/heatmap.js',
//        'https://code.highcharts.com/modules/solid-gauge.js',
//        'https://code.highcharts.com/modules/exporting.js',
//        'https://code.highcharts.com/modules/export-data.js',
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_BEGIN
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];

}
