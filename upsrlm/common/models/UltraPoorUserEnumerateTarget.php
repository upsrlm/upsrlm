<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ultra_poor_user_enumerate_target".
 *
 * @property int $id
 * @property int $user_id
 * @property int $enumerate
 * @property int $target
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class UltraPoorUserEnumerateTarget extends \common\models\dynamicdb\cbo\CboactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ultra_poor_user_enumerate_target';
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id'], 'required'],
            [['user_id', 'enumerate', 'target', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'enumerate' => 'Enumerate',
            'target' => 'Target',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getGps() {
        return $this->hasMany(RelationUserGramPanchayat::className(), ['user_id' => 'user_id'])->where(['relation_user_gram_panchayat.status' => 1]);
    }
}
