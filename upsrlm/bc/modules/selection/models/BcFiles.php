<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_files".
 *
 * @property int $id
 * @property string|null $label
 * @property string $file_name
 * @property int $form
 * @property int|null $row_count
 * @property int|null $master_partner_bank_id
 * @property int|null $upload_by
 * @property string|null $upload_datetime
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcFiles extends BcactiveRecord {

    const FORM_ONBOARD = 1;
    const FORM_PAN = 2;
    const FORM_HANDHELD_MACHIN = 3;
    const FORM_BCNAME_MOBILE_NO = 4;
    const FORM_FUNDS_TRANSFER = 5;
    const FORM_PFMS = 6;
    const FORM_REPLACE_BC_PFMS = 7;

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
        return 'bc_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['file_name', 'form'], 'required'],
            [['form', 'row_count', 'master_partner_bank_id', 'upload_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['upload_datetime'], 'safe'],
            [['file_name'], 'string', 'max' => 500],
            [['label'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'master_partner_bank_id' => 'Partner Bank',
            'form' => 'Form',
            'row_count' => 'Row Count',
            'upload_by' => 'Upload By',
            'upload_datetime' => 'Upload Datetime',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getPartnerbank() {
        return $this->hasOne(\bc\models\master\MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }

    public function getFormname() {
        $arr = [self::FORM_ONBOARD => 'Upload CSV for onboarding', self::FORM_PAN => 'Upload CSV for PAN Available', self::FORM_HANDHELD_MACHIN => 'Upload CSV for Handheld Machine provided', self::FORM_BCNAME_MOBILE_NO => 'Upload CSV for BC Name and Mobile No. update', self::FORM_FUNDS_TRANSFER => 'Upload CSV for support funds transfer'];
        return isset($arr[$this->form]) ? $arr[$this->form] : '';
    }
}
