<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_provided_saree_history".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property int|null $srlm_bc_selection_user_id
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $saree1_provided
 * @property string|null $saree1_provided_date
 * @property int|null $saree1_provided_by
 * @property string|null $saree1_provided_datetime
 * @property int|null $saree1_acknowledge
 * @property string|null $get_saree1_date
 * @property string $get_saree1_packed_new
 * @property int $get_saree1_quality
 * @property int $get_saree1_quality_no_1
 * @property int $get_saree1_quality_no_2
 * @property int $get_saree1_quality_no_3
 * @property int $get_saree1_quality_no_4
 * @property int $get_saree1_quality_no_other
 * @property string|null $get_saree1_quality_no_other_text
 * @property string|null $get_saree1_quality_photo
 * @property string|null $saree1_acknowledge_datetime
 * @property int|null $saree2_provided
 * @property string|null $saree2_provided_date
 * @property int|null $saree2_provided_by
 * @property string|null $saree2_provided_datetime
 * @property int|null $saree2_acknowledge
 * @property string|null $get_saree2_date
 * @property string $get_saree2_packed_new
 * @property int $get_saree2_quality
 * @property int $get_saree2_quality_no_1
 * @property int $get_saree2_quality_no_2
 * @property int $get_saree2_quality_no_3
 * @property int $get_saree2_quality_no_4
 * @property int $get_saree2_quality_no_other
 * @property string|null $get_saree2_quality_no_other_text
 * @property string|null $get_saree2_quality_photo
 * @property string|null $saree2_acknowledge_datetime
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 * @property int|null $parent_id
 */
class BcProvidedSareeHistory extends BcactiveRecord {

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

    public static function tableName() {
        return 'bc_provided_saree_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'saree1_provided', 'saree1_provided_by', 'saree1_acknowledge', 'get_saree1_quality', 'get_saree1_quality_no_1', 'get_saree1_quality_no_2', 'get_saree1_quality_no_3', 'get_saree1_quality_no_4', 'get_saree1_quality_no_other', 'saree2_provided', 'saree2_provided_by', 'saree2_acknowledge', 'get_saree2_quality', 'get_saree2_quality_no_1', 'get_saree2_quality_no_2', 'get_saree2_quality_no_3', 'get_saree2_quality_no_4', 'get_saree2_quality_no_other', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status', 'parent_id'], 'integer'],
            [['saree1_provided_date', 'saree1_provided_datetime', 'get_saree1_date', 'saree1_acknowledge_datetime', 'saree2_provided_date', 'saree2_provided_datetime', 'get_saree2_date', 'saree2_acknowledge_datetime'], 'safe'],
            [['get_saree1_packed_new', 'get_saree2_packed_new'], 'string', 'max' => 1],
            [['get_saree1_quality_no_other_text', 'get_saree2_quality_no_other_text'], 'string', 'max' => 255],
            [['get_saree1_quality_photo', 'get_saree2_quality_photo'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Application ID',
            'srlm_bc_selection_user_id' => 'Srlm Bc Selection User ID',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'saree1_provided' => 'Saree1 Provided',
            'saree1_provided_date' => 'Saree1 Provided Date',
            'saree1_provided_by' => 'Saree1 Provided By',
            'saree1_provided_datetime' => 'Saree1 Provided Datetime',
            'saree1_acknowledge' => 'Saree1 Acknowledge',
            'get_saree1_date' => 'Get Saree1 Date',
            'get_saree1_packed_new' => 'Get Saree1 Packed New',
            'get_saree1_quality' => 'Get Saree1 Quality',
            'get_saree1_quality_no_1' => 'Get Saree1 Quality No 1',
            'get_saree1_quality_no_2' => 'Get Saree1 Quality No 2',
            'get_saree1_quality_no_3' => 'Get Saree1 Quality No 3',
            'get_saree1_quality_no_4' => 'Get Saree1 Quality No 4',
            'get_saree1_quality_no_other' => 'Get Saree1 Quality No Other',
            'get_saree1_quality_no_other_text' => 'Get Saree1 Quality No Other Text',
            'get_saree1_quality_photo' => 'Get Saree1 Quality Photo',
            'saree1_acknowledge_datetime' => 'Saree1 Acknowledge Datetime',
            'saree2_provided' => 'Saree2 Provided',
            'saree2_provided_date' => 'Saree2 Provided Date',
            'saree2_provided_by' => 'Saree2 Provided By',
            'saree2_provided_datetime' => 'Saree2 Provided Datetime',
            'saree2_acknowledge' => 'Saree2 Acknowledge',
            'get_saree2_date' => 'Get Saree2 Date',
            'get_saree2_packed_new' => 'Get Saree2 Packed New',
            'get_saree2_quality' => 'Get Saree2 Quality',
            'get_saree2_quality_no_1' => 'Get Saree2 Quality No 1',
            'get_saree2_quality_no_2' => 'Get Saree2 Quality No 2',
            'get_saree2_quality_no_3' => 'Get Saree2 Quality No 3',
            'get_saree2_quality_no_4' => 'Get Saree2 Quality No 4',
            'get_saree2_quality_no_other' => 'Get Saree2 Quality No Other',
            'get_saree2_quality_no_other_text' => 'Get Saree2 Quality No Other Text',
            'get_saree2_quality_photo' => 'Get Saree2 Quality Photo',
            'saree2_acknowledge_datetime' => 'Saree2 Acknowledge Datetime',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'parent_id' => 'Parent ID',
        ];
    }

}
