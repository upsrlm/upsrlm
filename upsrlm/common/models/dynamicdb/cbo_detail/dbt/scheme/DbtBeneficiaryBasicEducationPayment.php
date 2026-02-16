<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use Yii;
use common\models\dynamicdb\cbo_detail\CboDetailactiveRecord;

/**
 * This is the model class for table "dbt_beneficiary_basic_education_payment".
 *
 * @property int $id
 * @property string|null $name_of_beneficiary
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
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property string|null $mobile_no
 * @property string|null $bank_name
 * @property int|null $bank_id
 * @property string|null $bank_account_number
 * @property float|null $amount_remited
 * @property string|null $payment_date
 * @property string|null $transactionId
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property int $status
 */
class DbtBeneficiaryBasicEducationPayment extends CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'dbt_beneficiary_basic_education_payment';
    }

    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['state_code', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'bank_id', 'created_at', 'created_by', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['amount_remited'], 'number'],
            [['payment_date'], 'safe'],
            ['gram_panchayat_code', 'exist', 'targetClass' => \common\models\master\MasterGramPanchayat::class, 'targetAttribute' => ['gram_panchayat_code' => 'gram_panchayat_code']],
            [['name_of_beneficiary', 'bank_name'], 'string', 'max' => 255],
            [['state_name', 'division_name', 'district_name', 'block_name', 'gram_panchayat_name'], 'string', 'max' => 150],
            [['mobile_no', 'bank_account_number', 'transactionId'], 'string', 'max' => 50],
            [['transactionId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name_of_beneficiary' => 'Name Of Beneficiary',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'mobile_no' => 'Mobile No',
            'bank_name' => 'Bank Name',
            'bank_id' => 'Bank ID',
            'bank_account_number' => 'Bank Account Number',
            'amount_remited' => 'Amount Remited',
            'payment_date' => 'Payment Date',
            'transactionId' => 'Transaction ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
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
