<?php

namespace common\assets;

use yii;
use yii\web\AssetBundle;

class LeafLeftAssets extends AssetBundle {

    public $sourcePath = '@common/themes/smartadmin/assets/';
    public $css = [
       'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
       'https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' 
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $js = [
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
        'https://unpkg.com/leaflet.heat/dist/leaflet-heat.js',
        'https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'
        ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_BEGIN
    );
    public $depends = [
        
    ];

}
