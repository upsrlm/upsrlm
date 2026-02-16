<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;
use common\models\dynamicdb\cbo_detail\master\CboMasterMemberDesignation;

/**
 * This is the model class for table "calling_scenario_user_verification".
 *
 * @property int $id
 * @property int|null $calling_id
 * @property int|null $calling_agent_id
 * @property int|null $caller_group_id
 * @property int|null $rishta_shg_member_id
 * @property int|null $cbo_shg_id
 * @property string|null $member_mobile
 * @property int|null $member_role
 * @property int|null $shg_name_and_other_verify
 * @property int|null $smart_phone
 * @property int|null $agree_download_rishta_app
 * @property int|null $else_having_smart_phone
 * @property int|null $carry_smart_phone
 * @property int|null $user_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property CallingList $calling
 */
class CallingScenarioUserVerification extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calling_scenario_user_verification';
    }

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
            [['calling_id', 'calling_agent_id', 'caller_group_id', 'rishta_shg_member_id', 'cbo_shg_id', 'member_role', 'shg_name_and_other_verify', 'smart_phone', 'agree_download_rishta_app', 'else_having_smart_phone', 'carry_smart_phone', 'user_id', 'call_purpose_complete', 'call_purpose_complete_no_reason', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
            'member_mobile' => 'Member Mobile',
            'member_role' => 'Member Role',
            'shg_name_and_other_verify' => 'Shg Name And Other Verify',
            'smart_phone' => 'Smart Phone',
            'agree_download_rishta_app' => 'Agree Download Rishta App',
            'else_having_smart_phone' => 'Else Having Smart Phone',
            'carry_smart_phone' => 'Carry Smart Phone',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Calling]].
     *
     * @return \yii\db\ActiveQuery
     */
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

    /**
     * Yes or no
     *
     * @return void
     */
    public function yesnoanswer($column)
    {
        $option = [1 => 'Yes', 2 => 'No'];
        if ($this->$column) {
            if (isset($option[$this->$column])) {
                return $option[$this->$column];
            }
            return '';
        }
        return '';
    }

    public function getElsehavingsmartphone()
    {
        $option = [
            CboMasterMemberDesignation::SHG_CHAIRPERSON => 'Chairperson',
            CboMasterMemberDesignation::SHG_SECRETARY => 'Secretary',
            CboMasterMemberDesignation::SHG_TREASURER => 'Treasurer',
            0 => 'No one Have'
        ];
        if ($this->else_having_smart_phone) {
            if (isset($option[$this->else_having_smart_phone])) {
                return $option[$this->else_having_smart_phone];
            }
            return '';
        }
        return '';
    }
}
