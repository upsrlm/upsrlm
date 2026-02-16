<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "calling_scenario_samuh_sakhi_verification".
 *
 * @property int $id
 * @property int|null $calling_id
 * @property int|null $calling_agent_id
 * @property int|null $caller_group_id
 * @property int|null $rishta_shg_member_id
 * @property int|null $cbo_shg_id
 * @property int|null $cbo_vo_id
 * @property string|null $member_mobile
 * @property string|null $member_name
 * @property int|null $shg_name_and_other_verify
 * @property int|null $user_id
 * @property int|null $call_purpose_complete 1=yes,2=no
 * @property int|null $call_purpose_complete_no_reason if no(2) in call_purpose_complete then add any reason here 
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class CallingScenarioSamuhSakhiVerification extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calling_scenario_samuh_sakhi_verification';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['calling_id', 'calling_agent_id', 'caller_group_id', 'rishta_shg_member_id', 'cbo_shg_id', 'cbo_vo_id', 'shg_name_and_other_verify', 'user_id', 'call_purpose_complete', 'call_purpose_complete_no_reason', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['member_mobile'], 'string', 'max' => 15],
            [['member_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calling_id' => 'Calling ID',
            'calling_agent_id' => 'Calling Agent ID',
            'caller_group_id' => 'Caller Group ID',
            'rishta_shg_member_id' => 'Rishta Shg Member ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'cbo_vo_id' => 'Cbo Vo ID',
            'member_mobile' => 'Member Mobile',
            'member_name' => 'Member Name',
            'shg_name_and_other_verify' => 'Shg Name And Other Verify',
            'user_id' => 'User ID',
            'call_purpose_complete' => 'Call Purpose Complete',
            'call_purpose_complete_no_reason' => 'Call Purpose Complete No Reason',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
    public function getCalling()
    {
        return $this->hasOne(CallingList::className(), ['id' => 'calling_id']);
    }

    /**
     * User model
     *
     * @return void
     */
    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

    /**
     * Relation to Rishta SHG Member Table
     *
     * @return void
     */
    public function getRishtashgmember()
    {
        return $this->hasOne(\common\models\dynamicdb\cbo_detail\RishtaShgMember::className(), ['id' => 'rishta_shg_member_id']);
    }
}
