<?php

namespace common\assets;

use yii;
use yii\web\AssetBundle;

class SmartAdminCallCenterAsset extends AssetBundle {

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
