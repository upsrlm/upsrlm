<?php

namespace common\assets;

use yii;
use yii\web\AssetBundle;

class BcSakhiAppAsset extends AssetBundle {

    public $sourcePath = '@common/themes/bcsakhi/assets/';
    public $css = [
        'css/bootstrap.min.css',
        'css/style.css',
        'css/responsive.css',
        'https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css',
        'https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css',

    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
    public $js = [
        'js/popper.min.js',
        'js/bootstrap.bundle.min.js',
        'js/plugin.js',
        'js/jquery.mCustomScrollbar.concat.min.js',
        'js/custom.js',
        'js/jquery.elevatezoom.js',
        'js/lozad.min.js',
        'https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js',
        'https://oss.maxcdn.com/respond/1.4.2/respond.min.js',
        'https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js',
        
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
