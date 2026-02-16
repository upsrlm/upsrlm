<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_shg_confirm_fund_return_recived".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property int|null $srlm_bc_selection_user_id
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property float|null $bc_return_amount
 * @property string|null $shg_confirm_funds_return_date
 * @property string|null $shg_confirm_funds_return_photo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcShgConfirmFundReturnRecived extends BcactiveRecord {

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
        return 'bc_shg_confirm_fund_return_recived';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['bc_return_amount'], 'number'],
            [['shg_confirm_funds_return_date'], 'safe'],
            [['shg_confirm_funds_return_photo'], 'string', 'max' => 500],
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
            'bc_return_amount' => 'Bc Return Amount',
            'shg_confirm_funds_return_date' => 'Shg Confirm Funds Return Date',
            'shg_confirm_funds_return_photo' => 'Shg Confirm Funds Return Photo',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getShg_confirm_funds_return_photo_url() {
        return "/getimage/bcprofile/" . $this->srlm_bc_selection_user_id . "/shg/" . $this->shg_confirm_funds_return_photo;
    }

    public function getBc() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }

    public function getDistrict() {
        return $this->hasOne(\bc\models\master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(\bc\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getGp() {
        return $this->hasOne(\bc\models\master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

}
