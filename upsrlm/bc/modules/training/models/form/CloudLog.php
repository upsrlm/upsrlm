<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;

class CloudLog extends \yii\base\Model {

    public $agree;
    public $bc_model;
    public $log_model;
    public $unwilling_model;
    public $upsrlm_connection_status;
    public $upsrlm_call_status;
    public $action_status;
    public $entry_type;
    public $unwilling_reason;
    public $training_status;
    public $server_id;
    public $log_id;
    public $connection_status_option = [];
    public $call_status_option = [];
    public $action_option = [];
    public $unwilling_reason_option = [];
    public $allow_training_status = [];

    public function __construct($bc_model, $log_model) {
        $this->bc_model = $bc_model;
        $this->log_model = $log_model;
        $this->server_id = $this->bc_model->id;
        $this->log_id = $this->log_model->id;
        $this->unwilling_model = \bc\modules\selection\models\BcUnwillingRsetis::findOne(['bc_application_id' => $this->bc_model->id, 'entry_type' => SrlmBcApplication::UNWILLING_TYPE_RSETHIS]);
        $this->connection_status_option = \common\models\base\GenralModel::cloud_tel_connection_status_option();
        $this->call_status_option = \common\models\base\GenralModel::cloud_tel_call_status_option();
        if ($this->bc_model->bc_unwilling_rsetis == 1) {
            $this->action_option = [1 => 'Agree for training'];
        } else {
            $this->action_option = [1 => 'Agree for training', 2 => 'Unwilling'];
        }
        $this->unwilling_reason_option = \bc\modules\selection\models\base\GenralModel::unwilling_reason_rsethis_option();
    }

    public function rules() {
        return [
            [['upsrlm_connection_status'], 'required'],
            [['server_id'], 'required'],
            [['log_id'], 'required'],
            ['upsrlm_call_status', 'required', 'when' => function ($model) {
                    return $model->upsrlm_connection_status == \common\models\base\GenralModel::CONNECTION_STATUS_PHONE_PICKED;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#upsrlm_connection_status').val() == '1';
            }"],
            ['action_status', 'required', 'when' => function ($model) {
                    return $model->upsrlm_call_status == \common\models\base\GenralModel::CALL_STATUS_CALL_CONTINUED;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#upsrlm_call_status').val() == '10';
            }"],
            ['unwilling_reason', 'required', 'when' => function ($model) {
                    return $model->action_status == 2;
                }, 'message' => 'एक से ज़्यादा कारण पर टिक कर सकते हैं', 'whenClient' => "function (attribute, value) {
                  return $('#action_status').val() == '2';
            }"],
            ['training_status', 'in', 'range' => [0]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'upsrlm_connection_status' => 'Connection status',
            'upsrlm_call_status' => 'Call status',
            'action_status' => 'Action',
            'unwilling_reason' => 'अगर हाँ, तो कृपया अपने अनिच्छा के कारण बतायें -',
        ];
    }

}
