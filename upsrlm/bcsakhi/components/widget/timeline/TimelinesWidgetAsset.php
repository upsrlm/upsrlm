<?php

namespace bcsakhi\components\widget\timeline;

use yii\web\AssetBundle;

class TimelinesWidgetAsset extends AssetBundle {

//    public $js = [
//        'js/timeline.js'
//    ];
    public $css = [
        'css/timeline.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
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
