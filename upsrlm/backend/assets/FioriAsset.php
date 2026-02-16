<?php

namespace backend\assets;

use yii;
use yii\web\AssetBundle;

class FioriAsset extends AssetBundle {

    public $sourcePath = '@backend/themes/fiori/assets/';
    public $css = [
        'css/custom.css',
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
    }

}
