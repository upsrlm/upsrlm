<?php

namespace common\models\dynamicdb\internalcallcenter;

use Yii;

/**
 * This is the model class for table "cloud_tele_api_log".
 *
 * @property int $id
 * @property int $bc_application_id
 * @property int|null $upsrlm_user_id
 * @property int $upsrlm_user_role
 * @property string|null $upsrlm_user_mobile_no
 * @property string|null $customernumber
 * @property int $cbo_shg_id
 * @property string|null $serviceuserid
 * @property string|null $token
 * @property string|null $api_response
 * @property string|null $api_request_datetime
 * @property string|null $callid
 * @property string|null $did
 * @property string|null $cType
 * @property string|null $CTC
 * @property string|null $ivrSTime
 * @property string|null $ivrETime
 * @property int|null $ivrDuration
 * @property string|null $userId
 * @property string|null $cNumber
 * @property string|null $masterNumCTC
 * @property int|null $masterAgent
 * @property string|null $masterAgentNumber
 * @property int|null $masterGroupId
 * @property int|null $talkDuration
 * @property int|null $agentOnCallDuration
 * @property string|null $firstAttended
 * @property string|null $firstAnswerTime
 * @property string|null $lastHangupTime
 * @property int|null $lastFirstDuration
 * @property string|null $custAnswerSTime
 * @property string|null $custAnswerETime
 * @property int|null $custAnswerDuration
 * @property int $callStatus
 * @property string|null $ivrExecuteFlow
 * @property int|null $HangupBySourceDetected
 * @property string|null $forward
 * @property int|null $totalHoldDuration
 * @property string|null $totalCreditsUsed
 * @property string|null $ivrIdArr
 * @property string|null $aAnsH
 * @property string|null $aH
 * @property string|null $nH
 * @property string|null $recordings
 * @property string|null $recording_file
 * @property string|null $cliArr
 * @property string|null $aHDetail
 * @property string|null $nHDetail
 * @property string|null $full_response
 * @property string|null $api_message
 * @property string|null $api_status
 * @property int $api_status_code
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
class CloudTeleApiLog extends InternalCallCenteractiveRecord {

    const CALL_TYPE_OUTBOUND = 1;
    const CALL_TYPE_INBOUND = 2;
    const CALL_SCENARIO_RSETHI_BATCH_CREATE = 1;
    const CALL_SCENARIO_SHG_MEMBER_CHAIRPERSION_VERIFY = 300;
    const CALL_SCENARIO_SHG_MEMBER_SECRETARY_VERIFY = 301;
    const CALL_SCENARIO_SHG_MEMBER_TREASURER_VERIFY = 301;

    public static $defaul_table = 'cloud_tele_api_log';
    protected static $table = 'cloud_tele_api_log';

    public function __construct($table = NULL) {
        if ($table === null || $table === '') {
            return self::$table;
        }
        self::$table = $table;
    }

    public static function tableName() {
        return self::$table;
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
//    public static function tableName() {
//        return 'cloud_tele_api_log';
//    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['serviceuserid'], 'required'],
            [['cbo_shg_id', 'bc_application_id', 'upsrlm_user_id', 'ivrDuration', 'masterAgent', 'masterGroupId', 'talkDuration', 'agentOnCallDuration', 'lastFirstDuration', 'custAnswerDuration', 'callStatus', 'HangupBySourceDetected', 'totalHoldDuration', 'api_status_code', 'upsrlm_connection_status', 'upsrlm_call_status', 'upsrlm_call_type', 'upsrlm_call_scenario', 'calling_list_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'project_id'], 'integer'],
            [['api_response', 'CTC', 'totalCreditsUsed', 'ivrIdArr', 'aAnsH', 'aH', 'nH', 'recordings', 'cliArr', 'aHDetail', 'nHDetail', 'full_response'], 'string'],
            [['ivrSTime', 'ivrETime', 'firstAnswerTime', 'lastHangupTime', 'custAnswerSTime', 'custAnswerETime'], 'safe'],
            [['customernumber', 'serviceuserid', 'token', 'did', 'cType', 'userId', 'cNumber', 'masterNumCTC', 'masterAgentNumber', 'firstAttended', 'ivrExecuteFlow', 'forward', 'api_message'], 'string', 'max' => 255],
            [['callid', 'recording_file'], 'string', 'max' => 1000],
            [['upsrlm_user_mobile_no'], 'string', 'max' => 15],
            [['upsrlm_user_mobile_no', 'api_request_datetime'], 'safe'],
            [['api_status'], 'string', 'max' => 155],
            [['upsrlm_connection_status'], 'default', 'value' => 0],
            [['upsrlm_call_status'], 'default', 'value' => 0],
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
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'bc_application_id',
            'upsrlm_user_id' => 'user_id',
            'upsrlm_user_mobile_no' => 'Caller No.',
            'customernumber' => 'Calling To.',
            'serviceuserid' => 'Serviceuserid',
            'token' => 'Token',
            'api_response' => 'Response',
            'callid' => 'Callid',
            'did' => 'Did',
            'cType' => 'C Type',
            'CTC' => 'Ctc',
            'ivrSTime' => 'Ivr S Time',
            'ivrETime' => 'Ivr E Time',
            'ivrDuration' => 'Ivr Duration',
            'userId' => 'User ID',
            'cNumber' => 'C Number',
            'masterNumCTC' => 'Master Num Ctc',
            'masterAgent' => 'Master Agent',
            'masterAgentNumber' => 'Master Agent Number',
            'masterGroupId' => 'Master Group ID',
            'talkDuration' => 'Talk Duration',
            'agentOnCallDuration' => 'Agent On Call Duration',
            'firstAttended' => 'First Attended',
            'firstAnswerTime' => 'First Answer Time',
            'lastHangupTime' => 'Last Hangup Time',
            'lastFirstDuration' => 'Last First Duration',
            'custAnswerSTime' => 'Cust Answer S Time',
            'custAnswerETime' => 'Cust Answer E Time',
            'custAnswerDuration' => 'Cust Answer Duration',
            'callStatus' => 'Call Status',
            'ivrExecuteFlow' => 'Ivr Execute Flow',
            'HangupBySourceDetected' => 'Hangup By Source Detected',
            'forward' => 'Forward',
            'totalHoldDuration' => 'Total Hold Duration',
            'totalCreditsUsed' => 'Total Credits Used',
            'ivrIdArr' => 'Ivr Id Arr',
            'aAnsH' => 'A Ans H',
            'aH' => 'A H',
            'nH' => 'N H',
            'recordings' => 'Recordings',
            'recording_file' => 'Recording File',
            'cliArr' => 'Cli Arr',
            'aHDetail' => 'A H Detail',
            'nHDetail' => 'N H Detail',
            'full_response' => 'Full Response',
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
        ];
    }

    public function GetApicallstatus() {
        return $this->hasOne(master\CloudTeleMasterApiCallStatus::className(), ['id' => 'callStatus']);
    }

    public function GetApicallerror() {
        return $this->hasOne(master\CloudTeleMasterApiErrorCode::className(), ['id' => 'api_status_code']);
    }

    public function GetCallstatus() {
        return $this->hasOne(master\CloudTeleMasterCallStatus::className(), ['id' => 'upsrlm_call_status']);
    }

    public function GetConnectionstatus() {
        return $this->hasOne(master\CloudTeleMasterConnectionStatus::className(), ['id' => 'upsrlm_connection_status']);
    }

    public function GetUser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'upsrlm_user_id']);
    }

    public function GetCallqullity() {
        return $this->hasOne(master\CloudTeleMasterCallQuality::className(), ['id' => 'upsrlm_call_quality']);
    }

    public function GetCalloutcome() {
        return $this->hasOne(master\CloudTeleMasterCallOutcome::className(), ['id' => 'upsrlm_call_outcome']);
    }

    public function GetCallagain() {
        return $this->hasOne(master\CloudTeleMasterCallAgain::className(), ['id' => 'upsrlm_call_again']);
    }

    public function GetCallscenario() {
        return $this->hasOne(master\CloudTeleMasterCallScenario::className(), ['id' => 'upsrlm_call_scenario']);
    }

    public function GetSmartwhose() {
        return $this->hasOne(master\CloudTeleMasterSmartPhoneWhose::className(), ['id' => 'smart_phone_whose']);
    }

    public function getSrvefile() {
        $date = new \DateTime('now');
        $date->modify('-3 month');
        $month = $date->format('Ym');
        $filepath = '';
        $audiofile = 'https://s-ct3.sarv.com/Audio/v1/recording?data={"userId":"' . $this->serviceuserid . '","token":"' . $this->token . '",';
        if ($this->serviceuserid==\Yii::$app->params['airphone_api_ctc_service_user_id']) {
            $filepath = $this->recording_file;
        } else {
            if ($this->recordings) {
                $recordings = json_decode($this->recordings, true);
                if ($recordings && $recordings[0]) {
                    $exploded = explode('/', $recordings[0]['file']);
                    if (date('Ym', strtotime($this->api_request_datetime)) <= $month) {
                        $audiofile = Yii::$app->params['awsbaseurl'] . '//callrecord/' . $exploded[1] . '/' . $exploded[2];
                    } else {
                        $audiofile = $audiofile . '"file":"/' . $exploded[1] . '/' . $exploded[2] . '"}';
                    }


                    $filepath = $audiofile;
                }
            } else {
                $filepath = $this->recording_file;
            }
        }
        return $filepath;
    }

    public function beforeSave($insert) {
        if ($this->upsrlm_user_mobile_no) {
            $user_model = \common\models\User::findOne(['username' => $this->upsrlm_user_mobile_no]);
            if ($user_model != null) {
                $this->upsrlm_user_id = $user_model->id;
                $this->upsrlm_user_role = $user_model->role;
            }
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        $attribute = CloudTeleApiLog::findOne($this->id);
        try {
            $call = new CloudTeleApiCall();
            $modelcall = $call::findOne(['cloud_tele_api_log' => $attribute->id]);

            if (empty($modelcall)) {
                $modelcall = new CloudTeleApiCall();
            }
            $modelcall->cloud_tele_api_log = $attribute->id;
            $modelcall->setAttributes($attribute->toArray());

            if ($modelcall->save()) {
                
            } else {
                //                print_r($modelbc->getErrors());
            }
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }


        return true;
    }

    public function getCallinglist() {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\platform\CallingList::className(), ['id' => 'calling_list_id']);
    }

    /**
     * Get Number of Calls Done After This Call to a Customer Number
     *
     * @return void
     */
    public function getAftermissedcallcount() {
        $next = self::find()
                ->where(['>', 'id', $this->id])
                ->andWhere(['>', 'api_request_datetime', $this->api_request_datetime])
                ->andWhere(['customernumber' => $this->customernumber])
                ->andWhere(['callStatus' => 3]) // both Answered
                ->count();
        if ($next > 0) {
            return 1;
        }
        return 0;
    }

    public function getIbdcallertype() {
        $member = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['mobile' => $this->customernumber, 'status' => 1])->one();
        if ($member != null) {
            return 'Registred';
        }
        return 'Unregistred';
    }

    public function GetMember() {
        return $this->hasOne(\common\models\dynamicdb\ultrapoor\nfsa\NfsaBaseSurvey::className(), ['mobile_no' => 'customernumber']);
    }

    public function GetMopupmember() {
        return $this->hasOne(\common\models\User::className(), ['username' => 'customernumber']);
    }
}
