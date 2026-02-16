<?php

namespace cbo\models\form;

use cbo\models\CboClf;
use cbo\models\CboClfMembers;
use Yii;

/**
 * CboClfMembersForm is the model behind the CboClfMembers
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Clfmemberform extends \yii\base\Model {

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
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $member_role_option = [];
    public $cbo_vo_option = [];
    public $cbo_shg_option = [];
    public $off_berrer_option = [];
    public $clf_model;
    public $clf_member_model;

    public function __construct($clf_member_model) {
        $this->clf_member_model = $clf_member_model;
        $this->clf_model = $this->clf_member_model->clf;
        $this->off_berrer_option = [0 => 'No', 1 => 'Yes'];
        $this->cbo_vo_option = \yii\helpers\ArrayHelper::map($this->clf_model->vos, 'id', 'name_of_vo');
        $this->name = $this->clf_member_model->name;
        $this->mobile_no = $this->clf_member_model->mobile_no;
        $this->role = $this->clf_member_model->role;
        $this->bank_operator = $this->clf_member_model->bank_operator;
        $this->cbo_vo_id = $this->clf_member_model->cbo_vo_id;
        $this->cbo_vo_off_bearer = $this->clf_member_model->cbo_vo_off_bearer;
        $this->cbo_shg_id = $this->clf_member_model->cbo_shg_id;
        $this->cbo_shg_off_bearer = $this->clf_member_model->cbo_shg_off_bearer;
        $this->member_role_option = \common\models\base\GenralModel::cbo_member_role_option($this);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'mobile_no', 'role', 'bank_operator'], 'required'],
            ['mobile_no', \common\validators\PhoneNoValidator::className(), 'message' => 'In valid Mobile No.'],
            [['cbo_clf_id', 'role', 'bank_operator', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['mobile_no'], 'string', 'max' => 15],
            [['name'], 'trim'],
            [['mobile_no'], 'trim'],
            [['cbo_vo_id', 'cbo_vo_off_bearer', 'cbo_shg_id', 'cbo_shg_off_bearer'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_clf_id' => 'Cbo CLF ID',
            'name' => 'Name सदस्य का नाम',
            'mobile_no' => 'Mobile No मोबाइल नंबर',
            'role' => 'Role CLF में भूमिका',
            'bank_operator' => 'Bank Operator क्या बैंक अकाउंट संचालक हैं?',
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

    public function save() {

        try {
            $this->clf_member_model->name = $this->name;
            $this->clf_member_model->mobile_no = $this->mobile_no;
            $this->clf_member_model->role = $this->role;
            $this->clf_member_model->bank_operator = $this->bank_operator;
            $this->clf_member_model->cbo_vo_id = $this->cbo_vo_id;
            $this->clf_member_model->cbo_vo_off_bearer = $this->cbo_vo_off_bearer;
            $this->clf_member_model->cbo_shg_id = $this->cbo_shg_id;
            $this->clf_member_model->cbo_shg_off_bearer = $this->cbo_shg_off_bearer;
            if ($this->clf_member_model->save()) {
                
            }

            return $this;
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

}
