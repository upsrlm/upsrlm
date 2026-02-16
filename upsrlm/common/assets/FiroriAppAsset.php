<?php

namespace common\assets;

use yii;
use yii\web\AssetBundle;

class FiroriAppAsset extends AssetBundle {

    public $sourcePath = '@common/themes/fiori/assets/';
    public $css = [
        'css/main.5fb56474af9319a1be42.css',
        'css/owl.carousel.css',
        'css/app.css',
//        'css/upsrlm.css'
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
    public $js = [
        // 'scripts/main.5fb56474af9319a1be42.js',
        'scripts/owl.carousel.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
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
