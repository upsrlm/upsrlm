<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_list_saachiv".
 *
 * @property int $id
 * @property string|null $district
 * @property string|null $block
 * @property string|null $gp
 * @property string|null $sachiv_name
 * @property string|null $sachiv_mob
 * @property int $status
 */
class MasterListSaachiv extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_list_saachiv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['status'], 'integer'],
            [['district'], 'string', 'max' => 19],
            [['block'], 'string', 'max' => 21],
            [['gp'], 'string', 'max' => 47],
            [['sachiv_name'], 'string', 'max' => 39],
            [['sachiv_mob'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'district' => 'District',
            'block' => 'Block',
            'gp' => 'Gp',
            'sachiv_name' => 'Sachiv Name',
            'sachiv_mob' => 'Sachiv Mob',
            'status' => 'Status',
        ];
    }

    public function getMaster_block() {
        return $this->hasOne(MasterBlock::className(), ['block_name' => 'block']);
    }

    public function getMaster_gp() {
        return $this->hasOne(MasterGramPanchayat::className(), ['gram_panchayat_name' => 'gp', 'block_name' => 'block']);
    }

}
