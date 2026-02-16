<?php

namespace frontend\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use common\models\User;
use common\models\master\MasterRole;
use common\components\Appcheck;

class App extends \yii\base\Component {
    public $check;
    public function init() {
        $this->check= new Appcheck();
        $this->check->current_app=Yii::$app->params['current_app'];
        $this->check->access();
        parent::init();
    }

}
