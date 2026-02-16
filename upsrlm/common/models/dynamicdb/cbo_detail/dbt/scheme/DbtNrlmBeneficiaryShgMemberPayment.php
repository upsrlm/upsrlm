<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use Yii;

/**
 * This is the model class for table "dbt_nrlm_beneficiary_shg_member_payment".
 *
 * @property int $id
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property int|null $village_code
 * @property string|null $village_name
 * @property string|null $shg_name
 * @property string|null $shg_code
 * @property int|null $cbo_shg_id
 * @property string|null $shg_member_name
 * @property string|null $husband_name
 * @property string|null $payment_date
 * @property float|null $payment_amt
 * @property string|null $type
 * @property int|null $type_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class DbtNrlmBeneficiaryShgMemberPayment extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'dbt_nrlm_beneficiary_shg_member_payment';
    }

    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['payment_amt'], 'required'],
            [['type'], 'required'],
            [['shg_code'], 'required'],
            [['shg_member_name'], 'required'],
            [['payment_amt'], 'trim'],
            [['type'], 'trim'],
            [['shg_code'], 'trim'],
            [['shg_member_name'], 'trim'],
            [['husband_name'], 'trim'],
            ['shg_code', 'exist', 'targetClass' => \cbo\models\Shg::class, 'targetAttribute' => ['shg_code' => 'shg_code']],
            [['division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'cbo_shg_id', 'type_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['payment_date'], 'safe'],
            [['payment_amt'], 'number'],
            [['division_name', 'district_name', 'block_name', 'gram_panchayat_name'], 'string', 'max' => 150],
            [['village_name', 'shg_name', 'shg_member_name', 'husband_name'], 'string', 'max' => 255],
            [['shg_code', 'type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'village_code' => 'Village Code',
            'village_name' => 'Village Name',
            'shg_name' => 'Shg Name',
            'shg_code' => 'Shg Code',
            'cbo_shg_id' => 'Cbo Shg ID',
            'shg_member_name' => 'Shg Member Name',
            'husband_name' => 'Husband Name',
            'payment_date' => 'Payment Date',
            'payment_amt' => 'Payment Amt',
            'type' => 'Type',
            'type_id' => 'Type ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        $shg_model = \cbo\models\Shg::find()->where(['shg_code' => $this->shg_code])->limit(1)->one();
        if ($shg_model != NULL) {
            $this->gram_panchayat_code = $shg_model->gram_panchayat_code;
            $this->village_code = $shg_model->village_code;
            $this->village_name = $shg_model->village_name;
            $this->shg_name = $shg_model->name_of_shg;
            $this->cbo_shg_id = $shg_model->id;
            if ($this->gram_panchayat_code != NULL) {
                $gp_model = \common\models\master\MasterGramPanchayat::find()->where(['gram_panchayat_code' => $this->gram_panchayat_code])->one();
                if (!empty($gp_model)) {
                    $this->division_code = $gp_model->division_code;
                    $this->division_name = $gp_model->division_name;
                    $this->district_code = $gp_model->district_code;
                    $this->district_name = $gp_model->district_name;
                    $this->block_code = $gp_model->block_code;
                    $this->block_name = $gp_model->block_name;
                    $this->gram_panchayat_code = $gp_model->gram_panchayat_code;
                    $this->gram_panchayat_name = $gp_model->gram_panchayat_name;
                }
            }
        }
        return parent::beforeSave($insert);
    }

}
