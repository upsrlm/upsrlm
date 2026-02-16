<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "rishta_user_report".
 *
 * @property int $id
 * @property int $user_id
 * @property int $is_login
 * @property int $no_of_shg
 * @property int $making_shg_user
 * @property int $making_shg_user_no
 * @property int $making_shg_user_login
 * @property int $is_update_shg_profile
 * @property int $is_fill_shg_feedbak
 * @property int $is_shg_member_add
 * @property int $is_shg_funds_add
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class RishtaUserReport extends \yii\db\ActiveRecord {

    public function behaviors() {
        return [
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
    public static function tableName() {
        return 'rishta_user_report';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb() {
        return Yii::$app->get('dbcbodetail');
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id'], 'required'],
            [['user_id', 'is_login', 'no_of_shg', 'making_shg_user', 'making_shg_user_no', 'making_shg_user_login', 'is_update_shg_profile', 'is_fill_shg_feedbak', 'is_shg_member_add', 'is_shg_funds_add', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'is_login' => 'Is Login',
            'no_of_shg' => 'No Of Shg',
            'making_shg_user' => 'Making Shg User',
            'making_shg_user_no' => 'Making Shg User No',
            'making_shg_user_login' => 'Making Shg User Login',
            'is_update_shg_profile' => 'Is Update Shg Profile',
            'is_fill_shg_feedbak' => 'Is Fill Shg Feedbak',
            'is_shg_member_add' => 'Is Shg Member Add',
            'is_shg_funds_add' => 'Is Shg Funds Add',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
