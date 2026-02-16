<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "relation_user_bdo_block".
 *
 * @property int $id
 * @property int $user_id
 * @property int $master_block_id
 * @property string $block_code
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RelationUserBdoBlock extends CboDetailactiveRecord {

    use \common\traits\Signature;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'relation_user_bdo_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'block_code'], 'required'],
            [['user_id', 'master_block_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['block_code'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'master_block_id' => 'Master Block ID',
            'block_code' => 'Block Code',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        if (isset($this->master_block_id) and $this->master_block_id) {
            $model = master\MasterBlock::findOne($this->master_block_id);
            if ($model != NULL) {
                $this->block_code = $model->block_code;
            }
        }
        if (isset($this->block_code) and $this->block_code) {
            $modelv = master\MasterBlock::find()->where(['block_code' => $this->block_code])->one();
            if ($modelv != NULL) {
                $this->master_block_id = $modelv->id;
            }
        }
        return parent::beforeSave($insert);
    }

    public function getUser_detail() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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

}
