<?php

namespace bcsakhi\components\widget\home;

use yii\base\Widget;

// TimelinesWidget.php
class PartnerWidget extends Widget {

    public $model;

    public function init() {
        parent::init();
    }

    public function run() {
        GalleryWidgetAsset::register($this->getView());
        $this->model=[];
        
        return $this->render('partner', [
                    'model' => $this->model,
                   
        ]);
    }
}

?>