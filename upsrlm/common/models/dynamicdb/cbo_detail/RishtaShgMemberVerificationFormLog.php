<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "rishta_shg_member_verification_form_log".
 *
 * @property int $id
 * @property int $cbo_shg_id
 * @property string|null $mobile_no
 * @property int $designation
 * @property int|null $call_log_id
 * @property int $upsrlm_connection_status
 * @property int $upsrlm_call_status
 * @property int $verify_ques1
 * @property int $verify_ques2
 * @property int $verify_ques3
 * @property int $verify
 * @property int $talk_with_shg_member
 * @property int $talk_with_shg_member_yes
 * @property int $talk_with_call_center
 * @property int $how_many_time_for_suggest_samuh_sakhi
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class RishtaShgMemberVerificationFormLog extends CboDetailactiveRecord {

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
    public static function tableName() {
        return 'rishta_shg_member_verification_form_log';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_shg_id'], 'required'],
            [['cbo_shg_id', 'call_log_id', 'upsrlm_connection_status', 'upsrlm_call_status', 'verify_ques1', 'verify_ques2', 'verify_ques3', 'verify', 'talk_with_shg_member', 'talk_with_shg_member_yes', 'talk_with_call_center', 'how_many_time_for_suggest_samuh_sakhi', 'designation', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['mobile_no'], 'string', 'max' => 15],
            ['call_log_id', 'default', 'value' => 0],
            ['upsrlm_connection_status', 'default', 'value' => 0],
            ['upsrlm_call_status', 'default', 'value' => 0],
            ['upsrlm_connection_status', 'default', 'value' => 0],
            ['verify_ques1', 'default', 'value' => 0],
            ['verify_ques2', 'default', 'value' => 0],
            ['verify_ques3', 'default', 'value' => 0],
            ['verify', 'default', 'value' => 0],
            ['talk_with_shg_member', 'default', 'value' => 0],
            ['talk_with_shg_member_yes', 'default', 'value' => 0],
            ['talk_with_call_center', 'default', 'value' => 0],
            ['how_many_time_for_suggest_samuh_sakhi', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'mobile_no' => 'Mobile No',
            'call_log_id' => 'Call Log ID',
            'upsrlm_connection_status' => 'Upsrlm Connection Status',
            'upsrlm_call_status' => 'Upsrlm Call Status',
            'verify_ques1' => 'Verify Ques1',
            'verify_ques2' => 'Verify Ques2',
            'verify_ques3' => 'Verify Ques3',
            'verify' => 'Verify',
            'talk_with_shg_member' => 'Talk With Shg Member',
            'talk_with_shg_member_yes' => 'Talk With Shg Member Yes',
            'talk_with_call_center' => 'Talk With Call Center',
            'how_many_time_for_suggest_samuh_sakhi' => 'How Many Time For Suggest Samuh Sakhi',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
