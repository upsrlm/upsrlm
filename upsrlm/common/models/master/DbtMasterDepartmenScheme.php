<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "dbt_master_departmen_scheme".
 *
 * @property int $id
 * @property int|null $department_id
 * @property string|null $scheme_name_hi
 * @property string|null $scheme_name_en
 * @property int $status
 */
class DbtMasterDepartmenScheme extends \common\models\dynamicdb\cbo\CboactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbt_master_departmen_scheme';
    }

   

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department_id', 'status'], 'integer'],
            [['scheme_name_hi', 'scheme_name_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'department_id' => 'Department ID',
            'scheme_name_hi' => 'Scheme Name Hi',
            'scheme_name_en' => 'Scheme Name En',
            'status' => 'Status',
        ];
    }
}
