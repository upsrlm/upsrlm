<?php

namespace cbo\models;

use Yii;

/**
 * This is the model class for table "cbo_clf_members".
 *
 * @property int $id
 * @property int|null $cbo_clf_id
 * @property string $name
 * @property string|null $mobile_no
 * @property int|null $role
 * @property int|null $bank_operator
 * @property int|null $cbo_vo_id
 * @property int|null $cbo_vo_off_bearer
 * @property int|null $cbo_shg_id
 * @property int|null $cbo_shg_off_bearer
 * @property int|null $user_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class CboClfMembers extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

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
                'value' => function() {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cbo_clf_members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_clf_id', 'role', 'bank_operator', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['cbo_vo_id', 'cbo_vo_off_bearer', 'cbo_shg_id', 'cbo_shg_off_bearer', 'user_id'], 'integer'],
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
            'cbo_clf_id' => 'CLF',
            'name' => 'Name',
            'mobile_no' => 'Mobile No',
            'role' => 'Role',
            'bank_operator' => 'Bank Operator',
            'cbo_vo_id' => 'प्रतिनिधि VO का नाम',
            'cbo_vo_off_bearer' => 'क्या VO पदाधिकारी हैं',
            'cbo_shg_id' => 'प्रतिनिधि SHG का नाम',
            'cbo_shg_off_bearer' => 'क्या SHG पदाधिकारी हैं?',
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

    public function getClf() {
        return $this->hasOne(CboClf::className(), ['id' => 'cbo_clf_id']);
    }

    public function getVo() {
        return $this->hasOne(CboVo::className(), ['id' => 'cbo_vo_id']);
    }

    public function getVooffbearer() {
        $op = [0 => 'No', 1 => 'Yes'];
        return isset($op[$this->cbo_vo_off_bearer]) ? $op[$this->cbo_vo_off_bearer] : '';
    }

    public function getShgoffbearer() {
        $op = [0 => 'No', 1 => 'Yes'];
        return isset($op[$this->cbo_shg_off_bearer]) ? $op[$this->cbo_shg_off_bearer] : '';
    }

    public function getShg() {
        return $this->hasOne(Shg::className(), ['id' => 'cbo_shg_id']);
    }

    public function getOperator() {
        $op = [0 => 'No', 1 => 'Yes'];
        return isset($op[$this->bank_operator]) ? $op[$this->bank_operator] : '';
    }

    public function getUser() {
        return $this->hasOne(\common\models\User::className(), ['username' => 'mobile_no']);
    }

}
