<?php

namespace common\models\dynamicdb\internalcallcenter\master;

use Yii;

/**
 * This is the model class for table "cloud_tele_master_call_scenario".
 *
 * @property int $id
 * @property string|null $call_scenario
 * @property string|null $scenario_description
 * @property string|null $scenario_form_file
 * @property string|null $form_id
 * @property int $status
 * @property string $created_at
 */
class CloudTeleMasterCallScenario extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cloud_tele_master_call_scenario';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('dbinternalcallcenter');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at'], 'required'],
            [['created_at'], 'safe'],
            [['call_scenario', 'scenario_description'], 'string', 'max' => 500],
            [['scenario_form_file', 'form_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'call_scenario' => 'Call Scenario',
            'scenario_description' => 'Scenario Description',
            'scenario_form_file' => 'Scenario Form File',
            'form_id' => 'Form ID',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
