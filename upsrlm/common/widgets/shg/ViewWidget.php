<?php

namespace common\widgets\shg;

use Yii;
use yii\base\Model;
use yii\base\Widget;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;
use cbo\models\Shg;

class ViewWidget extends Widget {

    public $model;
    public $visible = true;

    public function init() {
        parent::init();
    }

    public function run() {
        if ($this->visible) {
            ViewWidgetAsset::register($this->getView());
            return $this->render('shg_view', [
                        'model' => $this->model,
            ]);
        }
    }

}
?>

