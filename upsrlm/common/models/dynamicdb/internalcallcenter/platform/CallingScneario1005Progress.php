<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "calling_scneario_1005_progress".
 *
 * @property int $id
 * @property int $call_scenario_id
 * @property string $calling_date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int $work_hour
 * @property int $total_call
 * @property int $ctc_click Number of Times Call APi get Success
 * @property int $ibd_call
 * @property int $success_call
 * @property int $agent_call_recived Number of Times Agent Mark they recivied Call
 * @property int $upsrlm_connection_status1 Phone picked
 * @property int $upsrlm_connection_status21 Bell Ring
 * @property int $upsrlm_connection_status22 Busy
 * @property int $upsrlm_connection_status23 unreacheble
 * @property int $upsrlm_connection_status24 Mobile switch off
 * @property int $upsrlm_connection_status30 Wrong No does not exist
 * @property int $upsrlm_call_status10
 * @property int $upsrlm_call_status11
 * @property int $upsrlm_call_status12
 * @property int $upsrlm_call_status13
 * @property int $both_answered
 * @property int $from_unanswered agent not picked call
 * @property int $talk_duration talk duration in seconds
 * @property int $ivr_duration ivr duration in seconds
 * @property int $sce_q1_none
 * @property int $sce_q1_1
 * @property int $sce_q1_2
 * @property int $sce_q1_3
 * @property int $sce_q1_4
 * @property int $sce_q1_5
 * @property int $sce_q1_99
 * @property int $sce_q2_none
 * @property int $sce_q2_1
 * @property int $sce_q2_2
 * @property int $sce_q3_none
 * @property int $sce_q3_1
 * @property int $sce_q3_99
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int $status
 */
class CallingScneario1005Progress extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'calling_scneario_1005_progress';
    }

    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['call_scenario_id', 'work_hour', 'total_call', 'ctc_click', 'ibd_call', 'success_call', 'agent_call_recived', 'upsrlm_connection_status1', 'upsrlm_connection_status21', 'upsrlm_connection_status22', 'upsrlm_connection_status23', 'upsrlm_connection_status24', 'upsrlm_connection_status30', 'upsrlm_call_status10', 'upsrlm_call_status11', 'upsrlm_call_status12', 'upsrlm_call_status13', 'both_answered', 'from_unanswered', 'talk_duration', 'ivr_duration', 'sce_q1_none', 'sce_q1_1', 'sce_q1_2', 'sce_q1_3', 'sce_q1_4', 'sce_q1_5', 'sce_q1_99', 'sce_q2_none', 'sce_q2_1', 'sce_q2_2', 'sce_q3_none', 'sce_q3_1', 'sce_q3_99', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['calling_date'], 'required'],
            [['calling_date', 'start_time', 'end_time'], 'safe'],
            [['call_scenario_id', 'calling_date'], 'unique', 'targetAttribute' => ['call_scenario_id', 'calling_date']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'call_scenario_id' => 'Call Scenario ID',
            'calling_date' => 'Calling Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'work_hour' => 'Work Hour',
            'total_call' => 'Total Call',
            'ctc_click' => 'Ctc Click',
            'ibd_call' => 'Ibd Call',
            'success_call' => 'Success Call',
            'agent_call_recived' => 'Agent Call Recived',
            'upsrlm_connection_status1' => 'Upsrlm Connection Status1',
            'upsrlm_connection_status21' => 'Upsrlm Connection Status21',
            'upsrlm_connection_status22' => 'Upsrlm Connection Status22',
            'upsrlm_connection_status23' => 'Upsrlm Connection Status23',
            'upsrlm_connection_status24' => 'Upsrlm Connection Status24',
            'upsrlm_connection_status30' => 'Upsrlm Connection Status30',
            'upsrlm_call_status10' => 'Upsrlm Call Status10',
            'upsrlm_call_status11' => 'Upsrlm Call Status11',
            'upsrlm_call_status12' => 'Upsrlm Call Status12',
            'upsrlm_call_status13' => 'Upsrlm Call Status13',
            'both_answered' => 'Both Answered',
            'from_unanswered' => 'From Unanswered',
            'talk_duration' => 'Talk Duration',
            'ivr_duration' => 'Ivr Duration',
            'sce_q1_none' => 'Sce Q1 None',
            'sce_q1_1' => 'Sce Q1 1',
            'sce_q1_2' => 'Sce Q1 2',
            'sce_q1_3' => 'Sce Q1 3',
            'sce_q1_4' => 'Sce Q1 4',
            'sce_q1_5' => 'Sce Q1 5',
            'sce_q1_99' => 'Sce Q1 99',
            'sce_q2_none' => 'Sce Q2 None',
            'sce_q2_1' => 'Sce Q2 1',
            'sce_q2_2' => 'Sce Q2 2',
            'sce_q3_none' => 'Sce Q3 None',
            'sce_q3_1' => 'Sce Q3 1',
            'sce_q3_99' => 'Sce Q3 99',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

}
