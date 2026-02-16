<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AngularAsset extends AssetBundle
{

    public $sourcePath = '@frontend/themes/angular/';
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $css = [
        'styles.c918da419af6f812fa3e.css'
    ];

    public $js = [
        'main-es5.6c05dc467019bc71fdc3.js',
        'main-es2017.6c05dc467019bc71fdc3.js',
        'polyfills-es5.38e29e86cd58dd90ab3b.js',
        'polyfills-es2017.e91f9ff83cdff7174329.js',
        'runtime-es5.e0b479dd0cf7883deeb5.js',
        'runtime-es2017.e0b479dd0cf7883deeb5.js',
    ];
}
