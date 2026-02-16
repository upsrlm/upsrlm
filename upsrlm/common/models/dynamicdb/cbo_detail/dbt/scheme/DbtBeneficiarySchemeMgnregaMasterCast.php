<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use Yii;
use common\models\dynamicdb\cbo_detail\CboDetailactiveRecord;

/**
 * This is the model class for table "dbt_beneficiary_scheme_mgnrega_master_cast".
 *
 * @property int $id
 * @property string|null $name_eng
 * @property string|null $name_hi
 * @property float $rating_weightage
 * @property int $status
 */
class DbtBeneficiarySchemeMgnregaMasterCast extends CboDetailactiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbt_beneficiary_scheme_mgnrega_master_cast';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rating_weightage'], 'number'],
            [['status'], 'integer'],
            [['name_eng', 'name_hi'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_eng' => 'Name Eng',
            'name_hi' => 'Name Hi',
            'rating_weightage' => 'Rating Weightage',
            'status' => 'Status',
        ];
    }
}
