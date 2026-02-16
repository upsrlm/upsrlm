<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;


/**
 * This is the model class for table "calling_scenario_missedcall".
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
 * @property int|null $missedcall_reason
 * @property string|null $have_query
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */

class CallingScenarioMissedcall extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calling_scenario_missedcall';
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
            [['calling_id', 'calling_agent_id', 'caller_group_id', 'rishta_shg_member_id', 'cbo_shg_id', 'member_role', 'missedcall_reason', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['have_query'], 'string'],
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
            'missedcall_reason' => 'Missedcall Reason',
            'have_query' => 'Have Query',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Calling List
     *
     * @return void
     */
    public function getCalling()
    {
        return $this->hasOne(CallingList::className(), ['id' => 'calling_id']);
    }

    /**
     * Options for Missedcall Reason
     *
     * @return void
     */
    public static function missedcallreasonoption()
    {
        return [
            1 => 'Recived Call From Us',
            2 => 'Have Some Query',
            3 => 'Other'
        ];
    }

    /**
     * Missed Call Reason
     *
     * @return void
     */
    public function getMissedcallreason()
    {
        $option = self::missedcallreasonoption();
        if ($this->missedcall_reason) {
            if (isset($option[$this->missedcall_reason])) {
                return $option[$this->missedcall_reason];
            }
            return '';
        }
        return '';
    }
}
