<?php

namespace app\assets;

use yii\web\AssetBundle;
use app\assets\AppAsset;

class StaticAsset extends AssetBundle {

    public $sourcePath = '@app/themes/aasaan/assets/';
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $css = [
        'css/custom.css'
    ];

}
