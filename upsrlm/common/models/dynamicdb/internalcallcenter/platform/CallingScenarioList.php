<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "calling_scenario_list".
 *
 * @property int $id
 * @property int|null $calling_id
 * @property int|null $scenario_id this will be come from master table
 * @property string|null $scenario_response full response of scnerio based form
 * @property int|null $calling_agent_id caller user id or caller id
 * @property int|null $caller_group_id
 * @property string|null $scenario_date date of scenario when this happens
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property CallingList $calling
 * @property RemovedMasterCallScenario $scenario0
 */
class CallingScenarioList extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calling_scenario_list';
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
            [['calling_id', 'scenario_id', 'calling_agent_id', 'caller_group_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['scenario_response', 'scenario_date'], 'safe'],
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
            'scenario_id' => 'Scenario ID',
            'scenario_response' => 'Scenario Response',
            'calling_agent_id' => 'Calling Agent ID',
            'caller_group_id' => 'Caller Group ID',
            'scenario_date' => 'Scenario Date',
            'entity_id' => 'Entity ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Calling
     *
     * @return void
     */
    public function getCalling()
    {
        return $this->hasOne(CallingList::className(), ['id' => 'calling_id']);
    }

    /**
     * Calling Scneario 
     *
     * @return void
     */
    public function getCallingscenario()
    {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallScenario::className(), ['id' => 'scenario_id']);
    }
}
