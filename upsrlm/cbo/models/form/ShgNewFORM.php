<?php

namespace cbo\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\master\MasterRole;
use cbo\models\Shg;
use common\models\dynamicdb\cbo_detail\RishtaShgMemberAppPin;
use common\models\base\GenralModel;
use yii\web\UploadedFile;

/**
 * ShgForm is the model behind the Shg
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ShgNewFORM extends \yii\base\Model {

    public $id;
    public $division_code;
    public $division_name;
    public $district_code;
    public $district_name;
    public $block_code;
    public $block_name;
    public $gram_panchayat_code;
    public $gram_panchayat_name;
    public $village_code;
    public $village_name;
    public $hamlet;
    public $name_of_shg;
    public $shg_code;
    public $no_of_members;
    public $chaire_person_name;
    public $chaire_person_mobile_no;
    public $secretary_name;
    public $secretary_mobile_no;
    public $treasurer_name;
    public $treasurer_mobile_no;
    public $bank_account_no_of_the_shg;
    public $bank_id;
    public $name_of_bank;
    public $branch;
    public $branch_code_or_ifsc;
    public $date_of_opening_the_bank_account;
    public $passbook_photo;
    public $return;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $repeated_error;
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $bank_option = [];
    public $shg_model;
    public $shg_member_model;

    public function __construct($shg_model = null) {
        $this->block_option = GenralModel::blockopption($this);
        $this->district_option = GenralModel::nfsaoptiondistrict($this);
        $this->gp_option = GenralModel::nfsaoptiongp($this);
        $this->bank_option = \common\models\base\GenralModel::cbo_bank_option($this);
        $this->return = 0;
        $this->village_option = GenralModel::optionvillage($this);
        $this->shg_model = Yii::createObject([
                    'class' => Shg::className()
        ]);
        $shg_role = \common\models\dynamicdb\cbo_detail\master\CboMasterMemberDesignation::find()->where(['id' => [1, 2, 3]])->orderBy('id asc')->all();
        foreach ($shg_role as $mrole) {
            $this->shg_member_model[$mrole->id] = new ShgMemberForm();
            $this->shg_member_model[$mrole->id]->role = $mrole->id;
            $this->shg_member_model[$mrole->id]->name_lable = $mrole->role . ' name';
            $this->shg_member_model[$mrole->id]->mobile_lable = $mrole->role . ' mobile no';
        }

        if ($shg_model != null) {
            $this->shg_model = $shg_model;
            $this->division_code = $this->shg_model->division_code;
            $this->division_name = $this->shg_model->division_name;
            $this->district_code = $this->shg_model->district_code;
            $this->district_name = $this->shg_model->district_name;
            $this->block_code = $this->shg_model->block_code;
            $this->gram_panchayat_code = $this->shg_model->gram_panchayat_code;
            $this->gram_panchayat_name = $this->shg_model->gram_panchayat_name;
            $this->village_option = GenralModel::optionvillage($this);
            $this->village_code = $this->shg_model->village_code;
            $this->village_name = $this->shg_model->village_name;
            $this->hamlet = $this->shg_model->hamlet;
            $this->name_of_shg = $this->shg_model->name_of_shg;
            $this->shg_code = $this->shg_model->shg_code;
            $this->no_of_members = $this->shg_model->no_of_members;
            $this->repeated_error = $this->shg_model->repeated_error;
            if (isset($this->shg_model)) {
                $members = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['role' => [1, 2, 3], 'cbo_shg_id' => $this->shg_model->id, 'status' => 1])->all();
                foreach ($members as $member) {

                    $this->shg_member_model[$member->role] = new ShgMemberForm();
                    $this->shg_member_model[$member->role]->id = $member->id;
                    $this->shg_member_model[$member->role]->cbo_shg_id = $member->cbo_shg_id;
                    $this->shg_member_model[$member->role]->name = $member->name;
                    $this->shg_member_model[$member->role]->mobile = $member->mobile;
                    $this->shg_member_model[$member->role]->old_name = $member->name;
                    $this->shg_member_model[$member->role]->old_mobile = $member->mobile;
                    $this->shg_member_model[$member->role]->role = $member->role;
                    $this->shg_member_model[$member->role]->name_lable = $member->shgrole->role . ' name';
                    $this->shg_member_model[$member->role]->mobile_lable = $member->shgrole->role . ' mobile no';
                    $this->shg_member_model[$member->role]->user_id = $member->user_id;
                    $this->shg_member_model[$member->role]->verified = $member->verified;
                    $this->shg_member_model[$member->role]->mobile_verified = $member->mobile_verified;
                    $this->shg_member_model[$member->role]->source = $member->source;
                    $this->shg_member_model[$member->role]->bc = $member->bc;
                    $this->shg_member_model[$member->role]->parent_id = $member->parent_id;
                    $this->shg_member_model[$member->role]->ucount = $member->ucount;
                }
            }
        }
    }

    public function rules() {
        return [
            [['gram_panchayat_code', 'village_code'], 'required'],
            [['gram_panchayat_code'], \common\validators\SHGBCValidator::className()],
            [['hamlet', 'name_of_shg', 'no_of_members'], 'required'],
            [['name_of_shg'], 'trim'],
            [['shg_code'], 'required'],
            [['shg_code'], 'string', 'max' => 50],
            [['shg_code'], 'trim'],
            [['shg_code'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->shg_model->$attribute != $model->$attribute;
                }, 'targetClass' => Shg::className(), 'message' => 'This SHG code has already been taken'],
            [['division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'no_of_members', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['division_name', 'hamlet', 'name_of_shg'], 'string', 'max' => 150],
            [['district_name', 'block_name'], 'string', 'max' => 30],
            [['gram_panchayat_name', 'village_name'], 'string', 'max' => 125],
            ['no_of_members', 'integer', 'min' => 0, 'max' => 99],
            ['return', 'default', 'value' => 0],
            [['shg_member_model'], 'checkMobileNumber'],
            ['repeated_error', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'division_code' => 'Division',
            'division_name' => 'Division Name',
            'district_code' => 'District',
            'district_name' => 'District Name',
            'block_code' => 'Block',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'village_code' => 'Village',
            'village_name' => 'Village Name',
            'hamlet' => 'Hamlet',
            'name_of_shg' => 'Name of SHG',
            'shg_code' => 'SHG Code',
            'no_of_members' => 'No. of members',
            'chaire_person_name' => 'Chairperson Name',
            'chaire_person_mobile_no' => 'Chairperson Mobile No',
            'secretary_name' => 'Secretary Name',
            'secretary_mobile_no' => 'Secretary Mobile No',
            'treasurer_name' => 'Treasurer Name',
            'treasurer_mobile_no' => 'Treasurer Mobile No',
            'bank_account_no_of_the_shg' => 'Bank Account No Of The Shg',
            'bank_id' => 'Bank ID',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'passbook_photo' => 'Passbook Photo',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'repeated_error' => 'Repeated/Error',
        ];
    }

    public function save() {

        $this->shg_model->gram_panchayat_code = $this->gram_panchayat_code;
        $this->shg_model->village_code = $this->village_code;
        $this->shg_model->hamlet = $this->hamlet;
        $this->shg_model->name_of_shg = $this->name_of_shg;
        $this->shg_model->shg_code = $this->shg_code;
        $this->shg_model->no_of_members = $this->no_of_members;
        $this->shg_model->return = $this->return;
        $this->shg_model->status = 1;
        $this->shg_model->repeated_error = $this->repeated_error;
        if (!$this->shg_model->isNewRecord) {
            foreach ($this->shg_member_model as $key => $member) {
                if ($member->mobile != $member->old_mobile) {
                    $app_pin_ack_model = RishtaShgMemberAppPin::find()->where(['cbo_shg_id' => $this->shg_model->id, 'role' => $member->role, 'mobile_no' => $member->old_mobile])->one();
                    if ($app_pin_ack_model != null) {
                        $app_pin_ack_model->mobile_no = $member->mobile;
                        $app_pin_ack_model->save();
                    }
                }
            }
        }
        if ($this->shg_model->save()) {
            foreach ($this->shg_member_model as $key => $member) {
                if ($member->id) {
                    if (!$member->user_id) {
                        $shgmember = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['id' => $member->id])->one();
                        if ($member->mobile != $member->old_mobile) {
                            $shgmember->status = -1;
                            if ($shgmember->save()) {
                                $shgmemberc = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
                                $shgmemberc->cbo_shg_id = $this->shg_model->id;
                                $shgmemberc->name = $member->name;
                                $shgmemberc->mobile = $member->mobile;
                                $shgmemberc->role = $member->role;
                                $shgmemberc->source = GenralModel::SHG_MEMBER_SOURCE_BMMU;
                                $shgmemberc->role = $member->role;
                                $shgmemberc->status = 1;
                                $shgmemberc->parent_id = $shgmember->id;
                                $shgmemberc->ucount = ($shgmember->ucount + 1);
                                if ($shgmemberc->save()) {
                                    
                                }
                            }
                        } else {
                            $shgmember->cbo_shg_id = $this->shg_model->id;
                            $shgmember->name = $member->name;
                            $shgmember->mobile = $member->mobile;
                            $shgmember->role = $member->role;
                            $shgmember->source = GenralModel::SHG_MEMBER_SOURCE_BMMU;
                            $shgmember->role = $member->role;
                            $shgmember->status = 1;
                            if ($shgmember->save()) {
                                $shgmember->parent_id = $shgmember->id;
                                $shgmember->save();
                            }
                        }
                    }
                } else {
                    $shgmember = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
                    $shgmember->cbo_shg_id = $this->shg_model->id;
                    $shgmember->name = $member->name;
                    $shgmember->mobile = $member->mobile;
                    $shgmember->role = $member->role;
                    $shgmember->source = GenralModel::SHG_MEMBER_SOURCE_BMMU;
                    $shgmember->role = $member->role;
                    $shgmember->status = 1;
                    if ($shgmember->save()) {
                        $shgmember->parent_id = $shgmember->id;
                        $shgmember->save();
                    }
                }
            }
            return $this->shg_model;
        } else {
            return false;
        }
    }

    public function checkMobileNumber($attribute, $params) {
        $valid = true;
        $dulicate_entry_array = [];
//        foreach ($this->shg_member_model as $key => $member) {
//            $member[$key] = new ShgMemberForm();
//            if (in_array($member['mobile'], $dulicate_entry_array)) {
//                $valid = FALSE;
//            }
//            if (!$valid) {
//                $member[$key]->addError("mobile", "Mobile Number repeat");
//            }
//            array_push($dulicate_entry_array, $member['mobile']);
//        }
    }

}
