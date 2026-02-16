<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "missed_call".
 *
 * @property int $id
 * @property string|null $customernumber
 * @property string|null $name
 * @property string|null $address
 * @property int $bcid
 * @property int $wadaid
 * @property int|null $user_id
 * @property int $rishta_member_id
 * @property int $district_code
 * @property int $block_code
 * @property int|null $gram_panchayat_code
 * @property int $village_code
 * @property int $role
 * @property string|null $role_name
 * @property string|null $api_request_datetime
 * @property string|null $date
 * @property int $no_attempt_call
 * @property int $no_talk
 * @property string|null $first_call
 * @property string|null $last_call
 * @property int $hhs_id
 * @property int $log_id
 * @property string|null $talk_start_datetime
 * @property int $talk_time
 * @property int $call_attempt_after_missed
 * @property int $project_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class MissedCall extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'missed_call';
    }

    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['address'], 'string'],
            [['district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'bcid', 'wadaid', 'user_id', 'rishta_member_id', 'role', 'no_attempt_call', 'no_talk', 'call_attempt_after_missed', 'project_id', 'hhs_id', 'log_id', 'created_at', 'updated_at', 'status','talk_time'], 'integer'],
            [['api_request_datetime', 'date', 'first_call', 'last_call','talk_start_datetime'], 'safe'],
            [['customernumber'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
            [['role_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'customernumber' => 'Customernumber',
            'name' => 'Name',
            'address' => 'Address',
            'bcid' => 'Bcid',
            'wadaid' => 'Wadaid',
            'user_id' => 'User ID',
            'rishta_member_id' => 'Rishta Member ID',
            'role' => 'Role',
            'role_name' => 'Role Name',
            'api_request_datetime' => 'Api Request Datetime',
            'date' => 'Date',
            'no_attempt_call' => 'No Attempt Call',
            'no_talk' => 'No Talk',
            'first_call' => 'First Call',
            'last_call' => 'Last Call',
            'call_attempt_after_missed' => 'Call Attempt After Missed',
            'project_id' => 'Project ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function GetUser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }
}
