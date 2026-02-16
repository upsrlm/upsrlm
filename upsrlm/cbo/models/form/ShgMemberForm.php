<?php

namespace cbo\models\form;

use Yii;
use common\models\dynamicdb\cbo_detail\RishtaShgMember;

class ShgMemberForm extends \yii\base\Model {

    public $id;
    public $cbo_shg_id;
    public $name;
    public $mobile;
    public $old_name;
    public $old_mobile;
    public $user_id;
    public $verified;
    public $mobile_verified;
    public $source;
    public $role;
    public $bc;
    public $parent_id;
    public $ucount;
    public $name_lable;
    public $mobile_lable;

    public function rules() {
        return [
            [['name', 'mobile', 'role'], 'required', 'message' => "{attribute} खाली नहीं हो सकता."],
            [['cbo_shg_id', 'user_id', 'verified', 'mobile_verified', 'role', 'bc', 'parent_id', 'ucount'], 'integer'],
            [['mobile'], \common\validators\MobileNoValidator::className()],
            [['mobile'], 'string', 'max' => 10],
            [['name'], 'trim'],
            [['name'], 'string', 'min' => 2, 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'name' => 'सदस्यों के नाम',
            'mobile' => 'मोबाइल न0',
            'role' => 'Role',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
