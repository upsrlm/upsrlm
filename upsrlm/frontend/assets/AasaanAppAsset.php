<?php

namespace app\assets;

use yii\web\AssetBundle;

class AasaanAppAsset extends AssetBundle {

    public $sourcePath = '@app/themes/aasaan/assets/';
    public $css = [
        'plugins/morris/morris.css',
        'css/bootstrap.min.css',
        'css/bootstrap-select.css',
        'css/icons.css',
        'css/style.css',
        'css/slick.css',
        'css/slick-theme.css',
        'css/custom.css',
        
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $js = [
//        'js/jquery.min.js',
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/waves.js',
        'js/jquery.slimscroll.js',
        'js/slick.js',
        'js/printThis.js',
        'plugins/jquery-knob/jquery.knob.js',
        //'plugins/morris/morris.min.js',
        'plugins/raphael/raphael-min.js',
        //'plugins/morris/morris.js',
        //'pages/jquery.dashboard.js',
        'js/jquery.core.js',
        'js/jquery.app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
