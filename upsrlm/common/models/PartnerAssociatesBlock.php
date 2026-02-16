<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partner_associates_block".
 *
 * @property int $id
 * @property int $partner_associates_id
 * @property int $district_code
 * @property int|null $block_code
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class PartnerAssociatesBlock extends \common\models\dynamicdb\cbo\CboactiveRecord {

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
        return 'partner_associates_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['partner_associates_id', 'district_code'], 'required'],
            [['partner_associates_id', 'district_code', 'block_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'partner_associates_id' => 'Partner Associates ID',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getParnerassociate() {
        return $this->hasOne(PartnerAssociates::className(), ['id' => 'partner_associates_id']);
    }

    public function getDistrict() {
        return $this->hasOne(master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

}
