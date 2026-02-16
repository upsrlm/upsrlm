<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "department_user_profile".
 *
 * @property int $id
 * @property string|null $department
 * @property string|null $name
 * @property string|null $post
 * @property string|null $mobile_no
 * @property string|null $email_id
 * @property int|null $user_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class DepartmentUserProfile extends \common\models\dynamicdb\cbo\CboactiveRecord {

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
    public static function tableName() {
        return 'department_user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['department', 'name', 'post', 'email_id'], 'string', 'max' => 255],
            [['mobile_no'], 'string', 'max' => 20],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'department' => 'Department',
            'name' => 'Name',
            'post' => 'Post',
            'mobile_no' => 'Mobile No',
            'email_id' => 'Email ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
