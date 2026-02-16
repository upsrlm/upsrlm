<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "calling_scenario_samuhsakhinotfillform".
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
 * @property int|null $member_user_id
 * @property int|null $samuh_sakhi_not_fillform
 * @property int|null $have_otp_pin
 * @property int|null $call_purpose_complete 1=yes,2=no
 * @property int|null $call_purpose_complete_no_reason if no(2) in call_purpose_complete then add any reason here
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class CallingScenarioSamuhsakhinotfillform extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calling_scenario_samuhsakhinotfillform';
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
            [['calling_id', 'calling_agent_id', 'caller_group_id', 'rishta_shg_member_id', 'cbo_shg_id', 'member_role', 'member_user_id', 'samuh_sakhi_not_fillform', 'have_otp_pin', 'call_purpose_complete', 'call_purpose_complete_no_reason', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
            'member_user_id' => 'Member User ID',
            'samuh_sakhi_not_fillform' => 'Samuh Sakhi Not Fillform',
            'have_otp_pin' => 'Have Otp Pin',
            'call_purpose_complete' => 'Call Purpose Complete',
            'call_purpose_complete_no_reason' => 'Call Purpose Complete No Reason',
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
        return $this->hasOne(\common\models\User::className(), ['id' => 'member_user_id']);
    }

    /**
     * Not Filling the Form Options
     *
     * @return void
     */
    public static function samuhsakhinotfillformoption()
    {
        return [
            1 => 'Fill very soon',
            2 => 'Menu not showing in Rishta APP',
            3 => 'Dont\'t know how to use Rishta APP?',
            4 => 'Don\'t Want to Fill this form',
            5 => 'No Consensus',
            99 => 'Other'
        ];
    }

    /**
     * Not Filling Form
     *
     * @return void
     */
    public function getSamuhsakhinotfillform()
    {
        $option = self::samuhsakhinotfillformoption();
        if ($this->samuh_sakhi_not_fillform) {
            if (isset($option[$this->samuh_sakhi_not_fillform])) {
                return $option[$this->samuh_sakhi_not_fillform];
            }
            return '';
        }
        return '';
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
}
