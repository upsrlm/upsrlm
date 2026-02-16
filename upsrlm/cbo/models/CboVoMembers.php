<?php

namespace cbo\models;

use Yii;

/**
 * This is the model class for table "cbo_vo_members".
 *
 * @property int $id
 * @property int|null $cbo_vo_id
 * @property string $name
 * @property string|null $mobile_no
 * @property int|null $role
 * @property int|null $bank_operator
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class CboVoMembers extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

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
        return 'cbo_vo_members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_vo_id', 'role', 'bank_operator', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 150],
            [['mobile_no'], 'string', 'max' => 15],
            [['name'], 'trim'],
            [['mobile_no'], 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_vo_id' => 'Cbo Vo ID',
            'name' => 'Name',
            'mobile_no' => 'Mobile No',
            'role' => 'Role',
            'bank_operator' => 'Bank Operator',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getMemberrole() {
        return $this->hasOne(master\CboMasterMemberRole::className(), ['id' => 'role']);
    }

    public function getVo() {
        return $this->hasOne(CboVo::className(), ['id' => 'cbo_vo_id']);
    }

    public function getOperator() {
        $op = [0 => 'No', 1 => 'Yes'];
        return isset($op[$this->bank_operator]) ? $op[$this->bank_operator] : '';
    }

}
