<?php

namespace common\assets;

use yii;
use yii\web\AssetBundle;

class FioriSrlmAsset extends AssetBundle {

    public $sourcePath = '@common/themes/fiori/assets/';
    public $css = [
        'css/upsrlm.css'
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
    public $js = [
       
    ];
    public $depends = [
    ];

    public function init() {
        parent::init();
        \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            'css' => [],
        ];
    }

}
