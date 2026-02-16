<?php

namespace bc\models\transaction;

use Yii;

/**
 * This is the model class for table "srlm_bc_application".
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $sur_name
 * @property int|null $division_code
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $village_code
 * @property string|null $application_id
 * @property int|null $cbo_shg_id
 * @property int|null $user_id
 * @property int $onboarding
 * @property string|null $bankidbc
 * @property string|null $bc_email_id
 * @property int $urban_shg
 * @property int $blocked
 * @property int $no_of_transaction
 * @property int|null $master_partner_bank_id
 * @property int|null $training_status
 * @property int $status
 * @property int|null $last_updated_at
 */
class SrlmBcApplication extends \bc\models\transaction\BctransactionactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'srlm_bc_application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'cbo_shg_id', 'user_id', 'onboarding', 'urban_shg', 'blocked', 'no_of_transaction', 'master_partner_bank_id', 'training_status', 'status'], 'integer'],
            [['status'], 'required'],
            [['first_name', 'middle_name', 'sur_name'], 'string', 'max' => 100],
            [['application_id', 'bankidbc'], 'string', 'max' => 20],
            [['last_updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'sur_name' => 'Sur Name',
            'division_code' => 'Division Code',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'village_code' => 'Village Code',
            'application_id' => 'Application ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'user_id' => 'User ID',
            'onboarding' => 'Onboarding',
            'bankidbc' => 'Bankidbc',
            'urban_shg' => 'Urban Shg',
            'blocked' => 'Blocked',
            'no_of_transaction' => 'No Of Transaction',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'training_status' => 'Training Status',
            'status' => 'Status',
        ];
    }

    public function getName() {
        $html = '';
        if ($this->first_name)
            $html .= $this->first_name . ' ';
        if ($this->middle_name)
            $html .= $this->middle_name . ' ';
        if ($this->sur_name)
            $html .= $this->sur_name;
        return trim($html);
    }

    public function getDistrict() {
        return $this->hasOne(master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getVillage() {
        return $this->hasOne(master\MasterVillage::className(), ['village_code' => 'village_code']);
    }

    public function getGp() {
        return $this->hasOne(master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getPbank() {
        return $this->hasOne(master\MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }

}
