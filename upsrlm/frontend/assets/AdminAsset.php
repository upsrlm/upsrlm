<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle {

    public $sourcePath = '@app/themes/aasaan/assets/';
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $css = [
        'css/custom-a-l.css'
    ];

}
