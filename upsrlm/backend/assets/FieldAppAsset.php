<?php

namespace app\assets;

use yii\web\AssetBundle;
use app\assets\AppAsset;

class FieldAppAsset extends AssetBundle {

//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
    public $sourcePath = '@app/themes/field/assets/';
    public $css = [
        //   'css/bootstrap.css',
        'css/font-awesome.css',
        'css/ace-fonts.css',
        'css/ace.css',
//        'css/ace-part2.css',
        //below are the all css for test purpose not to use in production
//        'css/ace.onpage-help.css',
        // 'css/jquery-ui.css',
        //  'css/jquery-ui.custom.css',
//        'css/fullcalendar.css',
        //test css end
        'css/addon-tli.css',
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
    public $js = [
        //    'js/bootstrap.js',
        'js/ace/elements.scroller.js',
        'js/ace/ace.js',
        'js/ace/ace.sidebar.js',
        'js/ace/ace.sidebar-scroll-1.js',
        'js/ace/ace.submenu-hover.js',
        'js/jquery.elevatezoom.js',
        'js/jspdf.min.js',
        'js/printThis.js',
        
        
        'https://code.highcharts.com/highcharts.js',
        'https://code.highcharts.com/highcharts-3d.js',
        'https://code.highcharts.com/modules/data.js',
        'https://code.highcharts.com/modules/drilldown.js',
    
        'https://code.highcharts.com/highcharts-more.js',
        'https://code.highcharts.com/modules/heatmap.js',
        'https://code.highcharts.com/modules/solid-gauge.js',
        'https://code.highcharts.com/modules/exporting.js',
        'https://code.highcharts.com/modules/export-data.js',
       
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        //        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
