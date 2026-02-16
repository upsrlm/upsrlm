<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "relation_user_ultrapoor_block".
 *
 * @property int $id
 * @property int $user_id
 * @property int $district_code
 * @property int $block_code
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RelationUserUltrapoorBlock extends \common\models\dynamicdb\cbo\CboactiveRecord {

    use \common\traits\Signature;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'relation_user_ultrapoor_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'district_code', 'block_code'], 'required'],
            [['user_id', 'district_code', 'block_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['block_code', 'user_id'], 'unique', 'targetAttribute' => ['block_code', 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
    public function getBlock() {
        return $this->hasOne(\common\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getDistrict() {
        return $this->hasOne(\common\models\master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }
}
