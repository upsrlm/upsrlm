<?php

namespace bc\models\master;

use Yii;

/**
 * This is the model class for table "master_partner_bank".
 *
 * @property int $id
 * @property string|null $bank_name
 * @property string|null $bank_short_name
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class MasterPartnerBank extends \bc\modules\selection\models\BcactiveRecord {

    const BOB = 1;
    const FINO = 2;
    const NEARBY = 3;
    const MANIPAL = 4;
    const MFSL_AIRTEl = 5;
    const PTM = 6;
    const SBI = 7;
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
        return 'master_partner_bank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['bank_name'], 'string', 'max' => 100],
            [['bank_short_name'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bank_name' => 'Partner agencies',
            'bank_short_name' => 'Partner agencies',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getParnerbankdistrict() {
        return $this->hasMany(MasterPartnerBankDistrict::className(), ['master_partner_bank_id' => 'id']);
    }

    public function getDistrict() {
        return $this->hasMany(MasterDistrict::className(), ['district_code' => 'district_code'])->orderBy('district_name asc')->via('parnerbankdistrict');
    }

}
