<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "relation_user_department_scheme".
 *
 * @property int $id
 * @property int $user_id
 * @property int $scheme_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RelationUserDepartmentScheme extends \common\models\dynamicdb\cbo\CboactiveRecord {
    use \common\traits\Signature;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relation_user_department_scheme';
    }

   

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'scheme_id'], 'required'],
            [['user_id', 'scheme_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'scheme_id' => 'Scheme ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
     public function getScheme() {
        return $this->hasOne(master\DbtMasterDepartmenScheme::className(), ['id' => 'scheme_id']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
