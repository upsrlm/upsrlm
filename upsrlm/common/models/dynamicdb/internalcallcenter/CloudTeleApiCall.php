<?php

namespace common\models\dynamicdb\internalcallcenter;

use Yii;

/**
 * This is the model class for table "cloud_tele_api_call".
 *
 * @property int $id
 * @property int $cloud_tele_api_log
 * @property int $bc_application_id
 * @property int|null $upsrlm_user_id
 * @property int $upsrlm_user_role
 * @property string|null $upsrlm_user_mobile_no
 * @property string|null $customernumber
 * @property int $cbo_shg_id
 * @property int $api_status_code
 * @property string|null $api_request_datetime
 * @property int|null $ivrDuration
 * @property int|null $masterGroupId
 * @property int|null $talkDuration
 * @property int|null $agentOnCallDuration
 * @property int|null $lastFirstDuration
 * @property int|null $custAnswerDuration
 * @property int $callStatus
 * @property int|null $totalHoldDuration
 * @property int $upsrlm_connection_status
 * @property int $upsrlm_call_status
 * @property int $upsrlm_call_quality
 * @property int $upsrlm_call_outcome
 * @property int $upsrlm_call_again
 * @property int $smart_phone_whose
 * @property int $upsrlm_call_type
 * @property int $upsrlm_call_scenario
 * @property int $project_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class CloudTeleApiCall extends InternalCallCenteractiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cloud_tele_api_call';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cloud_tele_api_log'], 'required'],
            [['cbo_shg_id', 'cloud_tele_api_log', 'bc_application_id', 'upsrlm_user_id', 'api_status_code', 'ivrDuration', 'masterGroupId', 'talkDuration', 'agentOnCallDuration', 'lastFirstDuration', 'custAnswerDuration', 'callStatus', 'totalHoldDuration', 'upsrlm_connection_status', 'upsrlm_call_status', 'upsrlm_call_type', 'upsrlm_call_scenario', 'created_at', 'created_by', 'updated_at', 'updated_by','project_id'], 'integer'],
            [['api_request_datetime'], 'safe'],
            [['upsrlm_user_mobile_no'], 'string', 'max' => 15],
            [['customernumber'], 'string', 'max' => 255],
            [['cloud_tele_api_log'], 'unique'],
            [['cbo_shg_id'], 'default', 'value' => 0],
            [['bc_application_id'], 'default', 'value' => 0],
            [['upsrlm_agent_call_received', 'upsrlm_call_quality', 'upsrlm_call_outcome', 'upsrlm_call_again', 'smart_phone_whose'], 'integer'],
            [['upsrlm_agent_call_received'], 'default', 'value' => 0],
            [['upsrlm_call_quality'], 'default', 'value' => 0],
            [['upsrlm_call_outcome'], 'default', 'value' => 0],
            [['upsrlm_call_again'], 'default', 'value' => 0],
            [['smart_phone_whose'], 'default', 'value' => 0],
            [['upsrlm_user_role'], 'integer'],
            [['upsrlm_user_role'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cloud_tele_api_log' => 'Cloud Tele Api Log',
            'bc_application_id' => 'Bc Application ID',
            'upsrlm_user_id' => 'Upsrlm User ID',
            'upsrlm_user_mobile_no' => 'Caller No.',
            'customernumber' => 'Calling To.',
            'api_status_code' => 'Api Status Code',
            'api_request_datetime' => 'Api Request Datetime',
            'ivrDuration' => 'Ivr Duration',
            'masterGroupId' => 'Master Group ID',
            'talkDuration' => 'Talk Duration',
            'agentOnCallDuration' => 'Agent On Call Duration',
            'lastFirstDuration' => 'Last First Duration',
            'custAnswerDuration' => 'Cust Answer Duration',
            'callStatus' => 'Call Status',
            'totalHoldDuration' => 'Total Hold Duration',
            'upsrlm_connection_status' => 'Upsrlm Connection Status',
            'upsrlm_call_status' => 'Upsrlm Call Status',
            'upsrlm_call_quality' => 'Call quality',
            'upsrlm_call_outcome' => 'Call outcome',
            'upsrlm_call_again' => 'Call followup',
            'smart_phone_whose' => 'Smart Phone owner',
            'upsrlm_user_role' => 'Role',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function GetUser()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'upsrlm_user_id']);
    }

    public function GetApicallstatus()
    {
        return $this->hasOne(master\CloudTeleMasterApiCallStatus::className(), ['id' => 'callStatus']);
    }

    public function GetApicallerror()
    {
        return $this->hasOne(master\CloudTeleMasterApiErrorCode::className(), ['id' => 'api_status_code']);
    }

    public function GetCallstatus()
    {
        return $this->hasOne(master\CloudTeleMasterCallStatus::className(), ['id' => 'upsrlm_call_status']);
    }

    public function GetConnectionstatus()
    {
        return $this->hasOne(master\CloudTeleMasterConnectionStatus::className(), ['id' => 'upsrlm_connection_status']);
    }

    public function GetCallqullity()
    {
        return $this->hasOne(master\CloudTeleMasterCallQuality::className(), ['id' => 'upsrlm_call_quality']);
    }

    public function GetCalloutcome()
    {
        return $this->hasOne(master\CloudTeleMasterCallOutcome::className(), ['id' => 'upsrlm_call_outcome']);
    }

    public function GetCallagain()
    {
        return $this->hasOne(master\CloudTeleMasterCallAgain::className(), ['id' => 'upsrlm_call_again']);
    }

    public function GetSmartwhose()
    {
        return $this->hasOne(master\CloudTeleMasterSmartPhoneWhose::className(), ['id' => 'smart_phone_whose']);
    }

    public function GetCallscneario()
    {
        return $this->hasOne(master\CloudTeleMasterCallScenario::className(), ['id' => 'upsrlm_call_scenario']);
    }

    public function GetApilog()
    {
        return $this->hasOne(CloudTeleApiLog::className(), ['id' => 'cloud_tele_api_log']);
    }

    /**
     * Previous Timegap
     *
     * @return void
     */
    public function getPreviouscall()
    {
        $prev = $this->find()
            ->where(['<', 'id', $this->id])
            ->andWhere(['upsrlm_user_id' => $this->upsrlm_user_id])
            ->andWhere(['>=', 'created_at', strtotime(date("Y-m-d", strtotime($this->api_request_datetime)) . ' 00:00:00')])
            ->andWhere(['<=', 'created_at', strtotime(date("Y-m-d", strtotime($this->api_request_datetime)) . ' 23:59:59')])
            ->orderBy('id desc')->one();
        if ($prev) {
            $timegap = round(abs(strtotime($prev->api_request_datetime) - strtotime($this->api_request_datetime)), 0);
            if ($timegap > $prev->ivrDuration) {
                $timegap = $timegap - $prev->ivrDuration;
            }
            return gmdate("H:i:s", $timegap);
        }
        return '';
    }

    public function getPreviouscallibd()
    {
        $prev = $this->find()
            ->where(['<', 'id', $this->id])
            ->andWhere(['upsrlm_user_id' => $this->upsrlm_user_id])
            ->andWhere(['>=', 'created_at', strtotime(date("Y-m-d", strtotime($this->api_request_datetime)) . ' 00:00:00')])
            ->andWhere(['<=', 'created_at', strtotime(date("Y-m-d", strtotime($this->api_request_datetime)) . ' 23:59:59')])
            ->orderBy('id desc')->one();
        if ($prev) {
            $timegap = round(abs(strtotime($prev->api_request_datetime) - strtotime($this->api_request_datetime)), 0);
            if ($timegap > $prev->talkDuration) {
                $timegap = $timegap - $prev->talkDuration;
            }
            return gmdate("H:i:s", $timegap);
        }
        return '';
    }

    public function getPreviouscallscneario()
    {
        $prev = $this->find()
            ->where(['<', 'id', $this->id])
            ->andWhere(['upsrlm_call_scenario' => $this->upsrlm_call_scenario])
            ->andWhere(['>=', 'created_at', strtotime(date("Y-m-d", strtotime($this->api_request_datetime)) . ' 00:00:00')])
            ->andWhere(['<=', 'created_at', strtotime(date("Y-m-d", strtotime($this->api_request_datetime)) . ' 23:59:59')])
            ->orderBy('id desc')->one();
        if ($prev) {
            $timegap = round(abs(strtotime($prev->api_request_datetime) - strtotime($this->api_request_datetime)), 0);
            if ($timegap > $prev->ivrDuration) {
                $timegap = $timegap - $prev->ivrDuration;
            }
            return gmdate("H:i:s", $timegap);
        }
        return '';
    }

    public function getIbdcallertype()
    {
        $member = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['mobile' => $this->customernumber, 'status' => 1])->one();
        if ($member != null) {
            return 'Registred';
        }
        return 'Unregistred';
    }

    public function GetCallinglist()
    {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\platform\CallingList::className(), ['id' => 'calling_list_id']);
    }

    public function getCboshg()
    {
        return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_shg_id']);
    }
}
