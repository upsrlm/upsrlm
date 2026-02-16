<?php

namespace common\models\dynamicdb\internalcallcenter\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLog;

class CloudLog extends \yii\base\Model {

    public $agree;
    public $bc_model;
    public $log_model;
    public $unwilling_model;
    public $upsrlm_connection_status;
    public $upsrlm_call_status;
    public $upsrlm_call_quality;
    public $upsrlm_call_outcome;
    public $upsrlm_call_again;
    public $smart_phone_whose;
    public $reason_not_talk;
    public $agree_download_rishta_app;
    public $else_having_smart_phone;
    public $carry_smart_phone;
    public $action_status;
    public $smart_phone;
    public $entry_type;
    public $unwilling_reason;
    public $training_status;
    public $server_id;
    public $log_id;
    public $wada_info_call;
    public $connection_status_option = [];
    public $call_status_option = [];
    public $action_option = [];
    public $unwilling_reason_option = [];
    public $allow_training_status = [];
    public $smart_phone_option = [];
    public $call_quality_option = [];
    public $call_outcome_option = [];
    public $call_again_option = [];
    public $smart_phone_whose_option = [];
    public $agree_download_rishta_app_option = [];
    public $carry_smart_phone_option = [];
    public $else_having_smart_phone_option = [];
    public $form_model;
    public $log_history;
    public $status_url;
    public $dataProvider;

    public function __construct($log_model) {

        $this->log_model = $log_model;
        $this->log_id = $this->log_model->id;
        $this->connection_status_option = \common\models\base\GenralModel::cloud_tel_connection_status_option();
        $this->call_status_option = \common\models\base\GenralModel::cloud_tel_call_status_option();
        $this->call_quality_option = \common\models\base\GenralModel::cloud_tel_call_quality_option();
        $this->call_outcome_option = \common\models\base\GenralModel::cloud_tel_call_outcome_option();
        $this->call_again_option = \common\models\base\GenralModel::cloud_tel_call_again_option();
        $this->smart_phone_whose_option = \common\models\base\GenralModel::cloud_tel_smart_phone_whose_option();
        $this->smart_phone_option = [1 => 'Yes', 2 => 'No'];
        $this->agree_download_rishta_app_option = [1 => 'Yes', 2 => 'No'];
        $this->carry_smart_phone_option = [1 => 'Yes', 2 => 'No'];
        $this->log_history = CloudTeleApiLog::find()->select(['id', 'bc_application_id', 'upsrlm_user_id', 'upsrlm_user_mobile_no', 'customernumber', 'cbo_shg_id', 'upsrlm_call_scenario', 'upsrlm_call_type', 'callStatus', 'upsrlm_call_status', 'upsrlm_connection_status', 'api_status_code', 'api_status', 'api_message', 'upsrlm_call_quality', 'upsrlm_call_outcome', 'upsrlm_call_again', 'smart_phone_whose'])->where(['customernumber' => $this->log_model->customernumber, 'upsrlm_call_scenario' => $this->log_model->upsrlm_call_scenario])->andwhere(['!=', 'id', $this->log_model->id])->all();
        $this->load(Yii::$app->request->post());
//        if ($this->log_model->upsrlm_connection_status) {
//            $this->upsrlm_connection_status = $this->log_model->upsrlm_connection_status;
//        }
//        if ($this->log_model->upsrlm_call_status) {
//            $this->upsrlm_call_status = $this->log_model->upsrlm_call_status;
//        }
    }

    public function rules() {
        return [
            [['upsrlm_connection_status'], 'required'],
            [['log_id'], 'required'],
            ['upsrlm_call_status', 'required', 'when' => function ($model) {
                    return $model->upsrlm_connection_status == \common\models\base\GenralModel::CONNECTION_STATUS_PHONE_PICKED;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#upsrlm_connection_status').val() == '1';
            }"],
            [['upsrlm_call_quality', 'upsrlm_call_outcome', 'upsrlm_call_again', 'smart_phone_whose'], 'integer'],
            [['upsrlm_call_quality'], 'default', 'value' => 0],
            [['upsrlm_call_outcome'], 'default', 'value' => 0],
            [['upsrlm_call_again'], 'default', 'value' => 0],
            [['smart_phone_whose'], 'default', 'value' => 0],
            [['smart_phone'], 'safe'],
            [['smart_phone'], 'default', 'value' => 0],
            [['reason_not_talk'], 'string', 'max' => 500],
            ['agree_download_rishta_app', 'default', 'value' => 0],
            ['smart_phone', 'required', 'on' => ['callnew'], 'when' => function ($model) {
                    return $model->upsrlm_call_status == \common\models\base\GenralModel::CALL_STATUS_CALL_CONTINUED;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#upsrlm_call_status').val() == '10';
            }"],
            ['agree_download_rishta_app', 'required', 'on' => ['callnew'], 'when' => function ($model) {
                    return $model->upsrlm_call_status == \common\models\base\GenralModel::CALL_STATUS_CALL_CONTINUED and $model->smart_phone == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#upsrlm_call_status').val() == '10'  && $('#smart_phone').val() == '1';
            }"],
            ['else_having_smart_phone', 'required', 'on' => ['callnew'], 'when' => function ($model) {
                    return $model->upsrlm_call_status == \common\models\base\GenralModel::CALL_STATUS_CALL_CONTINUED and $model->smart_phone == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#upsrlm_call_status').val() == '10'  && $('#smart_phone').val() == '2';
            }"],
            ['carry_smart_phone_option', 'required', 'on' => ['callnew'], 'when' => function ($model) {
                    return $model->upsrlm_call_status == \common\models\base\GenralModel::CALL_STATUS_CALL_CONTINUED and $model->smart_phone == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#upsrlm_call_status').val() == '10'  && $('#smart_phone').val() == '2';
            }"],
            [['smart_phone', 'agree_download_rishta_app', 'else_having_smart_phone', 'carry_smart_phone'], 'integer'],
            ['else_having_smart_phone', 'default', 'value' => 0],
            ['carry_smart_phone', 'default', 'value' => 0],
            ['wada_info_call', 'default', 'value' => 0],
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
            'smart_phone' => 'Smart Phone',
            'upsrlm_call_quality' => 'Call quality',
            'upsrlm_call_outcome' => 'Call outcome',
            'upsrlm_call_again' => 'Call followup',
            'smart_phone_whose' => 'Smart Phone owner',
            'reason_not_talk' => 'Reason for not able to talk with Chair Person',
            'smart_phone' => 'Smart Phone availaibility',
            'agree_download_rishta_app' => 'Do you agree to download Rishta app in your phone',
            'else_having_smart_phone' => 'Who else is having smart phone in SHG',
            'carry_smart_phone' => 'Do they carry the smartphone with them',
            'wada_info_call' => 'Talk about wada info to bmmu',
        ];
    }

}
