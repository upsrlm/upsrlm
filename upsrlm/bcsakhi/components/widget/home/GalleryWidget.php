<?php

namespace bcsakhi\components\widget\home;

use yii\base\Widget;

// TimelinesWidget.php
class GalleryWidget extends Widget {

    public $model;

    public function init() {
        parent::init();
    }

    public function run() {
        GalleryWidgetAsset::register($this->getView());
        $this->model=[];
        return $this->render('gallery', [
                    'model' => $this->model,
        ]);
    }
}

?>