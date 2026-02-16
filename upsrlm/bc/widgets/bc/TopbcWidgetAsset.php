<?php

namespace bc\widgets\bc;

use yii\web\AssetBundle;

class TopbcWidgetAsset extends AssetBundle {

    public $js = [
        'js/owl.js',
        'js/slick.js',
        'js/gallery.js',
    ];
    public $css = [
        'css/topbc.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];

    public function init() {
        // Tell AssetBundle where the assets files are
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }
}
