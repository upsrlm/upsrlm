<?php

namespace common\widgets\cloudagent;

use Yii;
use yii\base\Model;
use yii\base\Widget;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLog;

class AgentFormWidget extends Widget {

    public $model;
    public $formmodel;
    public $visible = true;
    public $call_log_model;

    public function init() {
        parent::init();
    }

    public function run() {
        if ($this->visible) {
            AgentFormWidgetAsset::register($this->getView());
            $time = time();
            $before_time = ($time - 1200);
            $this->call_log_model = CloudTeleApiLog::find()->where(['upsrlm_user_mobile_no' => Yii::$app->user->identity->username, 'cType' => 'IVR'])->andFilterWhere(['>=', 'created_at', $before_time])->orderBy('created_at desc')->limit(1)->one();
            return $this->render('agentform', [
                        'model' => $this->model,
                        'formmodel' => $this->formmodel,
                        'call_log_model' => $this->call_log_model,
            ]);
        }
    }

}
?>

