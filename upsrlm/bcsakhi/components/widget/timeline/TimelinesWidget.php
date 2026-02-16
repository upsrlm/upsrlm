<?php

namespace bcsakhi\components\widget\timeline;

use yii\base\Widget;

// TimelinesWidget.php
class TimelinesWidget extends Widget {

    public $model;

    public function init() {
        parent::init();
    }

    public function run() {
        TimelinesWidgetAsset::register($this->getView());
         $this->model = [
        1 => ['time' => 'Janury 2020', 'txt' => 'Form Open'],
        2 => ['time' => 'Janury 2020', 'txt' => 'Form Open'],
        3 => ['time' => 'Janury 2020', 'txt' => 'Form Open'],
        4 => ['time' => 'Janury 2020', 'txt' => 'Form Open'],
        5 => ['time' => 'Janury 2020', 'txt' => 'Form Open'],
        6 => ['time' => 'Janury 2020', 'txt' => 'Form Open'],
        6 => ['time' => 'Janury 2020', 'txt' => 'Form Open']    
        ];
        return $this->render('timelines', [
                    'model' => $this->model,
        ]);
    }

}

?>