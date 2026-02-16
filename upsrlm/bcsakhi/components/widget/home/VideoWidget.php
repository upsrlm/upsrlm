<?php

namespace bcsakhi\components\widget\home;

use yii\base\Widget;

// TimelinesWidget.php
class VideoWidget extends Widget {

    public $model;

    public function init() {
        parent::init();
    }

    public function run() {
        
        $this->model=[];
        
        return $this->render('video', [
                    'model' => $this->model,
                   
        ]);
    }
}

?>