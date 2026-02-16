<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gram_pradhan_voice_sms".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $role
 * @property string|null $mobile_number
 * @property string|null $connect_time
 * @property string|null $duration
 * @property string|null $failure_reason
 */
class GramPradhanVoiceSms extends \common\models\dynamicdb\cbo\CboactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'gram_pradhan_voice_sms';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb() {
        return Yii::$app->get('dbcbo');
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'role'], 'integer'],
            [['mobile_number'], 'string', 'max' => 16],
            [['connect_time'], 'string', 'max' => 22],
            [['duration'], 'string', 'max' => 8],
            [['failure_reason'], 'string', 'max' => 18],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'role' => 'Role',
            'mobile_number' => 'Mobile Number',
            'connect_time' => 'Connect Time',
            'duration' => 'Duration',
            'failure_reason' => 'Failure Reason',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGrampanchayat() {
        return $this->hasMany(RelationUserGramPanchayat::className(), ['user_id' => 'user_id'])->where(['relation_user_gram_panchayat.status' => 1]);
    }
}
