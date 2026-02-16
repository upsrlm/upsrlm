<?php

namespace cbo\models\form;

use cbo\models\CboClf;
use cbo\models\CboClfMembers;
use Yii;

/**
 * CboClfMembersForm is the model behind the CboClfMembers
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class CboClfMembersForm extends \yii\base\Model {

    public $id;
    public $cbo_clf_id;
    public $name;
    public $mobile_no;
    public $role;
    public $bank_operator;
    public $cbo_vo_id;
    public $cbo_vo_off_bearer;
    public $cbo_shg_id;
    public $cbo_shg_off_bearer;
    public $clf_model;
    public $clf_member_model;
    public $sakhi;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $member_role_option = [];

    public function __construct() {
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
            ['mobile_no', 'checkmobile', 'when' => function ($model) {
                    return $model->sakhi == '1';
                }, 'message' => 'मोबाइल नंबर पहले से मौजूद है', 'whenClient' => "function (attribute, value) {
                  return $('#sakhi').val() == '1';
            }"],
            ['mobile_no', \common\validators\PhoneNoValidator::className(), 'message' => 'In valid Mobile No.'],
            [['cbo_clf_id', 'role', 'bank_operator', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['mobile_no'], 'string', 'max' => 15],
            [['name'], 'trim'],
            [['mobile_no'], 'trim'],
            ['sakhi', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_clf_id' => 'Cbo CLF ID',
            'name' => 'Name',
            'mobpublic $cbo_clf_model;ile_no' => 'Mobile No',
            'role' => 'Role',
            'bank_operator' => 'Bank Operator',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function checkmobile() {
        if (isset($this->mobile_no) and $this->mobile_no != '') {
            if (in_array($this->mobile_no, \yii\helpers\ArrayHelper::getColumn($this->clf_model->members, 'mobile_no'))) {
                $this->addError('mobile_no', "मोबाइल नंबर पहले से मौजूद है ");
                $valid = false;
            }
        }
        
    }

}
