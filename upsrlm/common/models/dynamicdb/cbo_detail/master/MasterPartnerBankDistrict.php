<?php

namespace common\models\dynamicdb\cbo_detail\master;

use Yii;

/**
 * This is the model class for table "master_partner_bank_district".
 *
 * @property int $id
 * @property int|null $master_partner_bank_id
 * @property int $district_code
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class MasterPartnerBankDistrict extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

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
        return 'master_partner_bank_district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['master_partner_bank_id', 'district_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['district_code'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'district_code' => 'District Code',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getParnerbank() {
        return $this->hasOne(MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }

    public function getDistrict() {
        return $this->hasOne(MasterDistrict::className(), ['district_code' => 'district_code']);
    }

}
