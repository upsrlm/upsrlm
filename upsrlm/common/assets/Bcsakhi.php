<?php

namespace common\assets;

use yii;
use yii\web\AssetBundle;

class Bcsakhi extends AssetBundle {

    public $sourcePath = '@common/themes/bcsakhinew/assets/';
    public $css = [
        'css/templatemofinancebusiness.css',
        'css/bcsakhi.css',
        'vendor/bootstrap/css/bootstrap.min.css',
        'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css',
        'css/owl.css',
        // 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css',

    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
    public $js = [
        'vendor/bootstrap/js/bootstrap.bundle.min.js',
        'vendor/jquery/jquery.min.js',
        'js/custom.js',
        'js/owl.js',
        'js/slick.js',
        'js/accordions.js',
        'js/jquery.elevatezoom.js',
        'js/lozad.min.js',
        // 'https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js',
        // 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js',
        // 'https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js',
        
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
