<?php

namespace common\assets;

use yii\web\AssetBundle;

class HandsonTableAsset extends AssetBundle {

    public $sourcePath = '@common/handsontable/assets/';
    public $css = [
        'stylesheets/handsontable.full.min.css',
    ];
    public $js = [
        'javascripts/handsontable.full.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
