<?php

namespace bcsakhi\components\widget\home;

use yii\web\AssetBundle;

class GoTimelineAsset extends AssetBundle {

//    public $js = [
//        'js/timeline.js'
//    ];
    public $css = [
        'css/gotimeline.css'
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
