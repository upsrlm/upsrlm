<?php

namespace common\assets;

use yii;
use yii\web\AssetBundle;

class FioriAsset extends AssetBundle {

    public $sourcePath = '@common/themes/fiori/assets/';
    public $css = [
        'css/main.5fb56474af9319a1be42.css',
        'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css',
        'css/owl.css',
        'css/custom-2.css',
        'css/upsrlm.css'
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
