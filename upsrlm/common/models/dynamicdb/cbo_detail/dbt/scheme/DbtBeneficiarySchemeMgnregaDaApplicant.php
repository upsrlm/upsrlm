<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use Yii;

/**
 * This is the model class for table "dbt_beneficiary_scheme_mgnrega_da_applicant".
 *
 * @property int $id
 * @property int|null $dbt_beneficiary_scheme_mgnrega_da_id
 * @property int|null $dbt_beneficiary_scheme_mgnrega_applicant_id
 */
class DbtBeneficiarySchemeMgnregaDaApplicant extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbt_beneficiary_scheme_mgnrega_da_applicant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dbt_beneficiary_scheme_mgnrega_da_id', 'dbt_beneficiary_scheme_mgnrega_applicant_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dbt_beneficiary_scheme_mgnrega_da_id' => 'Dbt Beneficiary Scheme Mgnrega Da ID',
            'dbt_beneficiary_scheme_mgnrega_applicant_id' => 'Dbt Beneficiary Scheme Mgnrega Applicant ID',
        ];
    }

    public function getMgnregaapplicant()
    {
        return $this->hasOne(DbtBeneficiarySchemeMgnregaApplicant::className(), ['id' => 'dbt_beneficiary_scheme_mgnrega_applicant_id']);
    }
}
