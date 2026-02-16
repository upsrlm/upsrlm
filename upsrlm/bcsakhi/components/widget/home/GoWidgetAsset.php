<?php

namespace bcsakhi\components\widget\home;

use yii\web\AssetBundle;

class GoWidgetAsset extends AssetBundle {

//    public $js = [
//        'js/timeline.js'
//    ];
    public $css = [
        'css/go.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];

    public function init() {
        // Tell AssetBundle where the assets files are
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }

}
