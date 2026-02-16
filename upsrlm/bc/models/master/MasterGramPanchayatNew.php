<?php

namespace bc\models\master;

use Yii;

/**
 * This is the model class for table "master_gram_panchayat_new".
 *
 * @property int $id
 * @property string|null $district_name
 * @property int|null $district_code
 * @property string|null $block_name
 * @property int|null $block_code
 * @property string|null $gram_name
 * @property int|null $gram_code
 * @property string|null $old_gp_name
 * @property int|null $old_gp_code
 * @property int $old_status
 */
class MasterGramPanchayatNew extends \bc\modules\selection\models\BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_gram_panchayat_new';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['district_code', 'block_code', 'gram_code','old_gp_code', 'old_status'], 'integer'],
            [['district_name', 'block_name', 'gram_name','old_gp_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'district_name' => 'District Name',
            'district_code' => 'District Code',
            'block_name' => 'Block Name',
            'block_code' => 'Block Code',
            'gram_name' => 'Gram Name',
            'gram_code' => 'Gram Code',
            'old_status' => 'Old Status',
        ];
    }
}
