<?php

namespace common\widgets\cloudagent;

use yii\web\AssetBundle;

class ViewWidgetAsset extends AssetBundle {

    public $js = [
        'js/shg.js'
    ];
    public $css = [
        'css/shg.css'
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
