<?php

namespace bc\modules\transaction\models\summary;

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
 * @property int $urban_shg
 * @property int $blocked
 * @property int $no_of_transaction
 * @property int|null $master_partner_bank_id
 * @property int|null $training_status
 * @property int $status
 * @property int|null $last_updated_at
 */
class SrlmBcApplication extends SummaryActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'srlm_bc_application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'cbo_shg_id', 'user_id', 'onboarding', 'urban_shg', 'blocked', 'no_of_transaction', 'master_partner_bank_id', 'training_status', 'status', 'last_updated_at'], 'integer'],
            [['status'], 'required'],
            [['first_name', 'middle_name', 'sur_name'], 'string', 'max' => 100],
            [['application_id', 'bankidbc'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
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
            'last_updated_at' => 'Last Updated At',
        ];
    }
}
