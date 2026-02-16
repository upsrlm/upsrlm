<?php

namespace common\models\dynamicdb\internalcallcenter;

use Yii;

/**
 * This is the model class for table "cloud_tele_user_report".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $role
 * @property string|null $date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int $no_of_call
 * @property int $no_of_call_ctc
 * @property int $no_of_call_ibd
 * @property int $no_of_call_success
 * @property int $total_call_duration
 * @property int $api_status_code0
 * @property int $api_status_code111
 * @property int $api_status_code150
 * @property int $api_status_code200
 * @property int $api_call_status3
 * @property int $api_call_status4
 * @property int $api_call_status5
 * @property int $api_call_status6
 * @property int $api_call_status7
 * @property int $api_call_status8
 * @property int $api_call_status9
 * @property int $api_call_status10
 * @property int $api_call_status11
 * @property int $api_call_status12
 * @property int $api_call_status13
 * @property int $api_call_status14
 * @property int $api_call_status15
 * @property int $api_call_status16
 * @property int $upsrlm_call_status10
 * @property int $upsrlm_call_status11
 * @property int $upsrlm_call_status12
 * @property int $upsrlm_call_status13
 * @property int|null $upsrlm_connection_status1
 * @property int|null $upsrlm_connection_status21
 * @property int $upsrlm_connection_status22
 * @property int $upsrlm_connection_status23
 * @property int $upsrlm_connection_status24
 * @property int $upsrlm_connection_status30
 * @property int|null $last_updated_at
 */
class CloudTeleUserReport extends InternalCallCenteractiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cloud_tele_user_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'role', 'no_of_call', 'no_of_call_success', 'total_call_duration', 'api_call_status3', 'api_call_status4', 'api_call_status5', 'api_call_status6', 'api_call_status7', 'api_call_status8', 'api_call_status9', 'api_call_status10', 'api_call_status11', 'api_call_status12', 'api_call_status13', 'api_call_status14', 'api_call_status15', 'api_call_status16', 'upsrlm_call_status10', 'upsrlm_call_status11', 'upsrlm_call_status12', 'upsrlm_call_status13', 'upsrlm_connection_status1', 'upsrlm_connection_status21', 'upsrlm_connection_status22', 'upsrlm_connection_status23', 'upsrlm_connection_status24', 'upsrlm_connection_status30', 'last_updated_at'], 'integer'],
            [['date', 'start_time', 'end_time'], 'safe'],
            [['no_of_call_ctc', 'no_of_call_ibd'], 'integer'],
            ['no_of_call_ctc', 'default', 'value' => 0],
            ['no_of_call_ibd', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'Caller Name',
            'role' => 'Role',
            'date' => 'Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'no_of_call' => 'No Of Call',
            'no_of_call_success' => 'No Of Call Success',
            'total_call_duration' => 'Total Call Duration',
            'api_status_code0' => 'No Api responce code',
            'api_status_code200' => 'Api responce success',
            'api_status_code111' => 'invalid mobile number in to parameter',
            'api_status_code150' => 'Connection Issue',
            'api_call_status3' => 'Both Answered',
            'api_call_status4' => 'To Ans. - From Unans.',
            'api_call_status5' => 'To Ans',
            'api_call_status6' => 'To Unans - From Ans.',
            'api_call_status7' => 'From Unanswered',
            'api_call_status8' => 'To Unans.',
            'api_call_status9' => 'Both Unanswered',
            'api_call_status10' => 'From Ans.',
            'api_call_status11' => 'Rejected Call',
            'api_call_status12' => 'Skipped',
            'api_call_status13' => 'From Failed',
            'api_call_status14' => 'To Failed - From Ans.',
            'api_call_status15' => 'To Failed',
            'api_call_status16' => 'To Ans - From Failed',
            'upsrlm_call_status10' => 'Call Continued',
            'upsrlm_call_status11' => 'Wrong Number',
            'upsrlm_call_status12' => 'Other Family Member',
            'upsrlm_call_status13' => 'Did not talk',
            'upsrlm_connection_status1' => 'Phone picked',
            'upsrlm_connection_status21' => 'Bell Ring',
            'upsrlm_connection_status22' => 'Busy',
            'upsrlm_connection_status23' => 'Unreacheble',
            'upsrlm_connection_status24' => 'Mobile switch off',
            'upsrlm_connection_status30' => 'Wrong No does not exist',
            'last_updated_at' => 'Last Updated At',
        ];
    }

    public function GetUser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

    public static function getTotal($provider, $columnName) {
        $total = 0;
        foreach ($provider as $item) {
            $total += $item->$columnName;
        }

        return $total;
    }

}
