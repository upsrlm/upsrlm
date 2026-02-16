<?php

namespace common\assets;

use yii;
use yii\web\AssetBundle;

class SmartAdminSumupAppAsset extends AssetBundle {

     public $sourcePath = '@common/themes/smartadmin/assets/';
    public $css = [
        'css/vendors.bundle.css',
        'css/app.bundle.css',
        'css/rishta-mobile.css',
        'css/mopup-mobile.css',
        
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $js = [
        'js/vendors.bundle.js',
        'js/app.bundle.js',
        'js/custom.js',
        
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
