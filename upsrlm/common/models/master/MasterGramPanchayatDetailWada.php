<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_gram_panchayat_detail_wada".
 *
 * @property int $id
 * @property int $gram_panchayat_code
 * @property int $shg_count
 * @property int $no_of_wada_application
 */
class MasterGramPanchayatDetailWada extends \common\models\dynamicdb\cbo\CboactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_gram_panchayat_detail_wada';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['gram_panchayat_code'], 'required'],
            [['gram_panchayat_code', 'shg_count', 'no_of_wada_application'], 'integer'],
            [['gram_panchayat_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'shg_count' => 'Shg Count',
            'no_of_wada_application' => 'No Of Wada Application',
        ];
    }

    public function getGp() {
        return $this->hasOne(MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

}
