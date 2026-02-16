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
        
//        'js/ace-extra.js',
            // 'js/additional-methods.js',
            //below are the all js files  to test purpose not to use in production
//        'js/ace/ace.auto-container.js',
//         'js/ace/ace.auto-padding.js',
//         'js/ace/ace.auto-padding.js',
//        
//        'js/ace/ace.onpage-help.js',
//         'js/ace/ace.settings.js',
//         'js/ace/ace.settings-rtl.js',
//        
//         'js/ace/ace.settings-skin.js',
//         'js/ace/ace.sidebar.js',
//         'js/ace/ace.sidebar-scroll-1.js',
//        
//         'js/ace/ace.sidebar-scroll-2.js',
//         'js/ace/ace.submenu-hover.js',
//         'js/ace/ace.touch-drag.js',
//        
//         'js/ace/ace.widget-box.js',
//         'js/ace/ace.widget-on-reload.js',
//         'js/ace/elements.aside.js',
//        
//         'js/ace/elements.colorpicker.js',
//         'js/ace/elements.fileinput.js',
//         'js/ace/elements.aside.js',
//        
//         
//         'js/ace/elements.spinner.js',
//         'js/ace/elements.treeview.js',
//        
//        'js/ace/elements.typeahead.js',
//         'js/ace/elements.wizard.js',
//         'js/ace/elements.wysiwyg.js',
//        
//        'js/jquery-ui.custom.js',
////        'js/additional-methods.js',
//        'js/bootbox.js',
//        
//        'js/bootstrap.js',
//        'js/bootstrap-colorpicker.js',
//        'js/bootstrap-multiselect.js',
//        
//         'js/bootstrap-tag.js',
//        'js/bootstrap-wysiwyg.js',
//        'js/chosen.jquery.js',
//        
//         'js/dropzone.js',
//        'js/excanvas.js',
////        'js/fullcalendar.js',
//        
//         'js/html5shiv.js',
//        'js/jquery.autosize.js',
//        'js/jquery.bootstrap-duallistbox.js',
//        
//        'js/jquery.colorbox.js',
//        'js/jquery.easypiechart.js',
//        'js/jquery.gritter.js',
//        
//         'js/jquery.hotkeys.js',
//        'js/jquery.inputlimiter.1.3.1.js',
//        'js/jquery.knob.js',
//        
//         'js/jquery.maskedinput.js',
//        'js/jquery.mobile.custom.js',
//        'js/jquery.mousewheel.js',
//        
//         'js/jquery.nestable.js',
//        'js/jquery.raty.js',
//        'js/jquery.slimscroll.js',
//        
//         'js/jquery.sparkline.js',
//        'js/jquery.ui.touch-punch.js',
//        'js/jquery.validate.js',
//        
//         'js/jquery-ui.custom.js',
//        'js/jquery-ui.js',
//        'js/pace.js',
//        
//         'js/prettify.js',
//        'js/respond.js',
//        'js/select2.js',
//        
//          'js/spin.js',
//        'js/typeahead.jquery.js',
//        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        //        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
