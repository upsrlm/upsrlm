<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "calling_scenario_user_not_used_rishtaapp".
 *
 * @property int $id
 * @property int|null $calling_id
 * @property int|null $calling_agent_id
 * @property int|null $caller_group_id
 * @property int|null $rishta_shg_member_id
 * @property int|null $cbo_shg_id
 * @property string|null $member_mobile
 * @property int|null $member_role
 * @property string|null $member_name
 * @property int|null $install_rishta_app
 * @property int|null $have_username
 * @property int|null $have_otp_pin
 * @property int|null $smart_phone
 * @property int|null $have_app_link
 * @property int|null $user_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class CallingScenarioUserNotUsedRishtaapp extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calling_scenario_user_not_used_rishtaapp';
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
            [['calling_id', 'calling_agent_id', 'caller_group_id', 'rishta_shg_member_id', 'cbo_shg_id', 'member_role', 'install_rishta_app', 'have_username', 'have_otp_pin', 'smart_phone', 'have_app_link', 'user_id', 'call_purpose_complete', 'call_purpose_complete_no_reason', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
            'member_name' => 'Member Name',
            'install_rishta_app' => 'Install Rishta App',
            'have_username' => 'Have Username',
            'have_otp_pin' => 'Have Otp Pin',
            'smart_phone' => 'Smart Phone',
            'have_app_link' => 'Have App Link',
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

    /**
     * Smart Phone Availaibility Option
     *
     * @return void
     */
    public static function smartphoneavailaibilityoption()
    {

        return [1 => 'हां', 3 => 'परिवार के सदस्य', 4 => 'सीबीओ सदस्यों का', 2 => 'नहीं'];
    }

    /**
     * Smart Phone Availaibility
     *
     * @return void
     */
    public function getSmartphoneavailaibility()
    {
        $option = self::smartphoneavailaibilityoption();
        if ($this->smart_phone) {
            if (isset($option[$this->smart_phone])) {
                return $option[$this->smart_phone];
            }
            return '';
        }
        return '';
    }
}
