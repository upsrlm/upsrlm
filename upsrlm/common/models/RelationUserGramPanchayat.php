<?php

namespace common\models;

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
class RelationUserGramPanchayat extends \common\models\dynamicdb\bc\BcactiveRecord {

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

    public function beforeSave($insert) {
        if (isset($this->gram_panchayat_code) and $this->gram_panchayat_code) {
            $model = \common\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $this->gram_panchayat_code]);
            if ($model != NULL) {
                $this->master_gram_panchayat_id = $model->id;
            }
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        $attribute = $this;
        try {
            $bc = new \common\models\dynamicdb\bc\RelationUserGramPanchayat();
            $modelbc = $bc::findOne($attribute->id);

            if (empty($modelbc)) {
                $modelbc = new \common\models\dynamicdb\bc\RelationUserGramPanchayat();
            }
            $modelbc->setAttributes($attribute->attributes);
            $modelbc->id = $attribute->id;
            $modelbc->user_id = $attribute->user_id;
            $modelbc->primary_user_id = $attribute->primary_user_id;
            $modelbc->master_gram_panchayat_id = $attribute->master_gram_panchayat_id;
            $modelbc->gram_panchayat_code = $attribute->gram_panchayat_code;
            $modelbc->block_code = $attribute->block_code;
            $modelbc->district_code = $attribute->district_code;
            $modelbc->created_at = $attribute->created_at;
            $modelbc->updated_at = $attribute->updated_at;
            $modelbc->created_by = $attribute->created_by;
            $modelbc->updated_by = $attribute->updated_by;
            $modelbc->status = $attribute->status;

            if ($modelbc->save()) {
                
            } else {
                
            }
        } catch (\Exception $ex) {
            
        }


        return true;
    }

    public function getUser_detail() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGp() {
        return $this->hasOne(master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getBlock() {
        return $this->hasOne(master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getDistrict() {
        return $this->hasOne(master\MasterDistrict::className(), ['district_code' => 'district_code'])->via('block');
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPrimaryuser() {
        return $this->hasOne(User::className(), ['id' => 'primary_user_id']);
    }

}
