<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "calling_scenario_notnominatedsamuhsakhi".
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
 * @property int|null $samuh_sakhi_not_nominated
 * @property int|null $call_purpose_complete 1=yes,2=no
 * @property int|null $call_purpose_complete_no_reason if no(2) in call_purpose_complete then add any reason here
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class CallingScenarioNotnominatedsamuhsakhi extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calling_scenario_notnominatedsamuhsakhi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['calling_id', 'calling_agent_id', 'caller_group_id', 'rishta_shg_member_id', 'cbo_shg_id', 'member_role', 'member_user_id', 'samuh_sakhi_not_nominated', 'have_otp_pin', 'call_purpose_complete', 'call_purpose_complete_no_reason', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['member_mobile'], 'string', 'max' => 15],
            [['member_name'], 'string', 'max' => 150],
        ];
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
            'samuh_sakhi_not_nominated' => 'Samuh Sakhi Not Nominated',
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
     * Samuh Sakhi Not Nomiated Option
     *
     * @return void
     */
    public static function notnominatedoption()
    {
        return [
            1 => 'Nominated very soon (आज नामित कर देंगे)',
            2 => 'Menu not showing in Rishta APP (रिश्ता ऐप में मेनू नहीं दिख रहा है)',
            3 => 'Dont\'t know how to use Rishta APP? (रिश्ता ऐप पर नाम कैसे नामित करे, पता नहीं है )',
            4 => 'No One Ready to become Samuh Sakhi (कोई भी समूह सखी बनने को कोई तैयार नहीं है )',
            5 => 'No Consensus (किसी की सहमति नहीं है )',
            6 => 'समूह की मीटिंग होने पर तय करेंगे कि किस सदस्य का नाम नामित करना है ',
            7 => 'जो मोबाइल नंबर रजिस्टर्ड है, वह अन्य सदस्य द्वारा उठाया जा रहा है जो कि 1-30 दिन में वापस घर पहुचेंगे',
            8 => 'फ़ोन में रिचार्ज नहीं है',
            9 => 'ऐप डिलीट हो गया है',
            10 => 'जिस पदाधिकारी को फ़ोन कर रहे है , उनके द्वारा फ़ोन न उठाकर किसी अन्य पदाधिकारी द्वारा फ़ोन उठाया जा रहा है',
            99 => 'Other (अन्य)'
        ];
    }


    /**
     * Not Nomiated 
     *
     * @return void
     */
    public function getSamuhsakhinotnominated()
    {
        $option = self::notnominatedoption();
        if ($this->samuh_sakhi_not_nominated) {
            if (isset($option[$this->samuh_sakhi_not_nominated])) {
                return $option[$this->samuh_sakhi_not_nominated];
            }
            return '';
        }
        return '';
    }

    /**
     * Yes or No 
     *
     * @param [type] $column
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
}
