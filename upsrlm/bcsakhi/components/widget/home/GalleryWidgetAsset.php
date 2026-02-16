<?php

namespace bcsakhi\components\widget\home;

use yii\web\AssetBundle;

class GalleryWidgetAsset extends AssetBundle {

    public $js = [
        'js/owl.js',
        'js/slick.js',
        'js/gallery.js',
    ];
    public $css = [
        'css/gallery.css'
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
