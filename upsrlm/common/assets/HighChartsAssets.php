<?php

namespace common\assets;

use yii;
use yii\web\AssetBundle;

class HighChartsAssets extends AssetBundle {

    public $sourcePath = '@common/themes/smartadmin/assets/';
    public $css = [
       
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
    public $js = [
        
        'https://code.highcharts.com/highcharts.js',
        'https://code.highcharts.com/stock/highstock.js',
        'https://code.highcharts.com/highcharts-3d.js',
        'https://code.highcharts.com/modules/data.js',
        'https://code.highcharts.com/modules/drilldown.js',
    
        'https://code.highcharts.com/highcharts-more.js',
        'https://code.highcharts.com/modules/heatmap.js',
        'https://code.highcharts.com/modules/solid-gauge.js',
        'https://code.highcharts.com/modules/exporting.js',
        'https://code.highcharts.com/modules/export-data.js',
        ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_BEGIN
    );
    public $depends = [
        
    ];

}
