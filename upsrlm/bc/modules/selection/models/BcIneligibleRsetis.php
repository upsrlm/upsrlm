<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_ineligible_rsetis".
 *
 * @property int $id
 * @property int $bc_application_id
 * @property int $bc_selection_user_id
 * @property int $ineligible_reason1
 * @property int $ineligible_reason2
 * @property int $ineligible_reason3
 * @property int $ineligible_reason4
 * @property int $ineligible_reason5
 * @property int|null $entry_by
 * @property string|null $entry_date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcIneligibleRsetis extends BcactiveRecord {

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
        return 'bc_ineligible_rsetis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'bc_selection_user_id'], 'required'],
            [['bc_application_id', 'bc_selection_user_id', 'ineligible_reason1', 'ineligible_reason2', 'ineligible_reason3', 'ineligible_reason4', 'ineligible_reason5', 'entry_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['entry_date'], 'safe'],
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
            'ineligible_reason1' => 'Ineligible Reason1',
            'ineligible_reason2' => 'Ineligible Reason2',
            'ineligible_reason3' => 'Ineligible Reason3',
            'ineligible_reason4' => 'Ineligible Reason4',
            'ineligible_reason5' => 'Ineligible Reason5',
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
