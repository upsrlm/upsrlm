<?php

namespace common\models\dynamicdb\mopup;

use Yii;

/**
 * This is the model class for table "relation_user_gram_panchayat".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $primary_user_id
 * @property int $master_gram_panchayat_id
 * @property string $gram_panchayat_code
 * @property string $block_code
 * @property string $district_code
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RelationUserGramPanchayat extends MopupactiveRecord { 

    use \common\traits\Signature;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'relation_user_gram_panchayat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'master_gram_panchayat_id', 'gram_panchayat_code', 'block_code', 'district_code'], 'required'],
            [['user_id', 'primary_user_id', 'master_gram_panchayat_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['gram_panchayat_code'], 'safe'],
            [['block_code'], 'safe'],
            [['district_code'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'primary_user_id' => 'Primary User',
            'master_gram_panchayat_id' => 'Gram Panchayat',
            'gram_panchayat_code' => 'Gram Panchayat',
            'block_code' => 'Block',
            'district_code' => 'District',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    

    public function getUser_detail() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

    public function getGp() {
        return $this->hasOne(\common\models\master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getBlock() {
        return $this->hasOne(\common\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getDistrict() {
        return $this->hasOne(\common\models\master\MasterDistrict::className(), ['district_code' => 'district_code'])->via('block');
    }

    public function getUser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

    public function getPrimaryuser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'primary_user_id']);
    }

}
