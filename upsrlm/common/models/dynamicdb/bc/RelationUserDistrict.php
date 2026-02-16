<?php

namespace common\models\dynamicdb\bc;

use Yii;

/**
 * This is the model class for table "relation_user_district".
 *
 * @property int $id
 * @property int $user_id
 * @property string $district_code
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RelationUserDistrict extends BcactiveRecord {

    use \common\traits\Signature;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'relation_user_district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'district_code'], 'required'],
            [['user_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['district_code'], 'string', 'max' => 4],
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
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getDistrict() {
        return $this->hasOne(master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getProfile() {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'user_id']);
    }

}
