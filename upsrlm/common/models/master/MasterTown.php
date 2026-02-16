<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_town".
 *
 * @property int $id
 * @property string|null $state_code
 * @property string|null $state_name
 * @property string|null $district_code
 * @property string|null $district_name
 * @property string|null $sub_district_code
 * @property string|null $sub_district_name
 * @property string|null $town_code
 * @property string|null $town_name
 * @property int|null $town_type 1=M Corp.,2=NP,3=NPP,4=CT
 */
class MasterTown extends \yii\db\ActiveRecord {

    const TOWN_TYPE_MCORP = 1;
    const TOWN_TYPE_NPP = 2;
    const TOWN_TYPE_NP = 3;
    const TOWN_TYPE_CT = 4;
    const TOWN_TYPE_CB = 5;
    const TOWN_TYPE_ITS = 6;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_town';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['town_name', 'state_name', 'district_name', 'sub_district_name'], 'required', 'message' => 'Is required'],
            [['town_type'], 'integer'],
            [['state_code'], 'string', 'max' => 2],
            [['state_name'], 'string', 'max' => 13],
            [['district_code'], 'string', 'max' => 3],
            [['district_name'], 'string', 'max' => 28],
            [['sub_district_code'], 'string', 'max' => 5],
            [['sub_district_name'], 'string', 'max' => 19],
            [['town_code'], 'string', 'max' => 6],
            [['town_name'], 'string', 'max' => 55],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'sub_district_code' => 'Sub District Code',
            'sub_district_name' => 'Sub District Name',
            'town_code' => 'Town Code',
            'town_name' => 'Town Name',
            'town_type' => 'Town Type',
        ];
    }

}
