<?php

namespace common\widgets\cloud;

use yii\web\AssetBundle;

class InboundWidgetAsset extends AssetBundle {

    public $js = [
        'js/inbound.js'
    ];
    public $css = [
        'css/inbound.css'
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
