<?php

namespace common\assets;

use yii;
use yii\web\AssetBundle;

class GradiantAppAsset extends AssetBundle {

    public $sourcePath = '@common/themes/gradient_able/assets/';
    public $css = [
        'css/plugins/prism-coy.css',
        'css/style.css',
        'css/custom.css',
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
    public $js = [
        'js/vendor-all-oec.js',
        'js/pcoded.min.js',
        'js/plugins/moment.min.js',
        'js/plugins/daterangepicker.js',
        'js/pages/ac-datepicker.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];

    public function init() {
        parent::init();
        \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            'css' => [],
        ];
    }

}
