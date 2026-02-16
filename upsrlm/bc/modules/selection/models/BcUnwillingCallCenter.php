<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_unwilling_call_center".
 *
 * @property int $id
 * @property int $bc_application_id
 * @property int $bc_selection_user_id
 * @property int $entry_type
 * @property int $call_center_call_status
 * @property int|null $rsetis_call
 * @property int|null $express_reluctance
 * @property int $unwilling_reason1
 * @property int $unwilling_reason2
 * @property int $unwilling_reason3
 * @property int $unwilling_reason4
 * @property int $unwilling_reason5
 * @property int $unwilling_reason6
 * @property int $unwilling_reason7
 * @property string|null $unwilling_reason7_text
 * @property int|null $entry_by
 * @property string|null $entry_date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcUnwillingCallCenter extends BcactiveRecord {

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
        return 'bc_unwilling_call_center';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'bc_selection_user_id'], 'required'],
            [['bc_application_id', 'bc_selection_user_id', 'rsetis_call', 'express_reluctance', 'unwilling_reason1', 'unwilling_reason2', 'unwilling_reason3', 'unwilling_reason4', 'unwilling_reason5', 'unwilling_reason6', 'unwilling_reason7', 'entry_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['entry_date'], 'safe'],
            [['entry_type','call_center_call_status'], 'integer'],
            [['unwilling_reason7_text'], 'string', 'max' => 500],
            [['call_center_call_status'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Application ID',
            'bc_selection_user_id' => 'Bc Selection User ID',
            'rsetis_call' => 'Rsetis Call',
            'express_reluctance' => 'Express Reluctance',
            'unwilling_reason1' => 'Unwilling Reason1',
            'unwilling_reason2' => 'Unwilling Reason2',
            'unwilling_reason3' => 'Unwilling Reason3',
            'unwilling_reason4' => 'Unwilling Reason4',
            'unwilling_reason5' => 'Unwilling Reason5',
            'unwilling_reason6' => 'Unwilling Reason6',
            'unwilling_reason7' => 'Unwilling Reason7',
            'unwilling_reason7_text' => 'Unwilling Reason7 Text',
            'entry_by' => 'Entry By',
            'entry_date' => 'Entry Date',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
