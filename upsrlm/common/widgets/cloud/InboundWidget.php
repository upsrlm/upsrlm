<?php

namespace common\widgets\cloud;

use yii\base\Widget;

class InboundWidget extends Widget {

    public $model;
    public $check_call_url;
    public $redirect_url;

    public function init() {
        parent::init();
    }

    public function run() {
        InboundWidgetAsset::register($this->getView());
        return $this->render('inbound', [
                    'model' => $this->model,
                    'check_call_url' => $this->check_call_url,
                    'redirect_url' => $this->redirect_url,
        ]);
    }

}

?>
