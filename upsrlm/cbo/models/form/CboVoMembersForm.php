<?php

namespace cbo\models\form;

use Yii;

/**
 * CboVoMembersForm is the model behind the CboVoMembers
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class CboVoMembersForm extends \yii\base\Model {

    public $id;
    public $cbo_vo_id;
    public $name;
    public $mobile_no;
    public $role;
    public $bank_operator;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $member_role_option = [];

    public function __construct($funds_model = null) {
        $this->member_role_option = \common\models\base\GenralModel::cbo_member_role_option($this);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['name', 'required', 'when' => function ($model) {
                    return $model->mobile_no != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#mobile_no').val() !== '';
            }"],
            ['name', 'required', 'when' => function ($model) {
                    return $model->role != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#role').val() !== '';
            }"],
            ['mobile_no', 'required', 'when' => function ($model) {
                    return $model->name != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#name').val() !== '';
            }"],
            ['mobile_no', 'required', 'when' => function ($model) {
                    return $model->role != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#role').val() !== '';
            }"],
            ['role', 'required', 'when' => function ($model) {
                    return $model->name != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#name').val() !== '';
            }"],
            ['role', 'required', 'when' => function ($model) {
                    return $model->mobile_no != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#mobile_no').val() !== '';
            }"],
            ['mobile_no', \common\validators\PhoneNoValidator::className(), 'message' => 'In valid Mobile No.'],
            [['cbo_vo_id', 'role', 'bank_operator', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
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

}
