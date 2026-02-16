<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "gram_pardhan_raw".
 *
 * @property int $id
 * @property string|null $name
 * @property string $mobile_no
 * @property string $whatsapp_no
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property int|null $state_code
 * @property string|null $state_name
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $sub_district_code
 * @property string|null $sub_district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 */
class GramPardhanRaw extends \common\models\dynamicdb\cbo\CboactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'gram_pardhan_raw';
    }

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
    public function rules() {
        return [
            [['mobile_no', 'whatsapp_no'], 'required'],
            [['gram_panchayat_code', 'state_code', 'division_code', 'district_code', 'sub_district_code', 'block_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['mobile_no', 'whatsapp_no'], 'string', 'max' => 15],
            [['gram_panchayat_name', 'state_name', 'division_name', 'district_name', 'sub_district_name', 'block_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'mobile_no' => 'Mobile No',
            'whatsapp_no' => 'Whatsapp No',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'sub_district_code' => 'Sub District Code',
            'sub_district_name' => 'Sub District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        if ($this->gram_panchayat_code != NULL) {
            $gp_model = \common\models\master\MasterGramPanchayat::find()->where(['gram_panchayat_code' => $this->gram_panchayat_code])->one();

            if (!empty($gp_model)) {
                $this->state_code = $gp_model->state_code;
                $this->state_name = $gp_model->state_name;
                $this->division_code = $gp_model->division_code;
                $this->division_name = $gp_model->division_name;
                $this->district_code = $gp_model->district_code;
                $this->district_name = $gp_model->district_name;
                $this->sub_district_code = $gp_model->sub_district_code;
                $this->sub_district_name = $gp_model->sub_district_name;
                $this->block_code = $gp_model->block_code;
                $this->block_name = $gp_model->block_name;
                $this->gram_panchayat_code = $gp_model->gram_panchayat_code;
                $this->gram_panchayat_name = $gp_model->gram_panchayat_name;
            }
        }
        return parent::beforeSave($insert);
    }

}
