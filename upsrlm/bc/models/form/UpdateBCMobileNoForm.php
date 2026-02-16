<?php

namespace bc\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\training\models\RsetisBatchParticipants;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use common\models\CboMemberProfile;
use yii\base\Model;
use yii\web\UploadedFile;

class UpdateBCMobileNoForm extends \yii\base\Model {

    public $id;
    public $mobile_no;
    public $old_mobile_no;
    public $first_name;
    public $middle_name;
    public $sur_name;
    public $terms_and_condition;
    public $bc_model;
    public $bc_selection_user_model;
    public $bc_rs_model;
    public $bc_user_model;
    public $user_profile_model;

    public function __construct($model) {
        $this->bc_model = $model;
        $this->bc_selection_user_model = SrlmBcSelectionUser::findOne($this->bc_model->srlm_bc_selection_user_id);
        $this->old_mobile_no = $model->user->mobile_no;
        $this->mobile_no = $model->user->mobile_no;
        $this->first_name = $this->bc_model->first_name;
        $this->middle_name = $this->bc_model->middle_name;
        $this->sur_name = $this->bc_model->sur_name;
        $this->bc_rs_model = RsetisBatchParticipants::findOne(['bc_application_id' => $this->bc_model->id]);
        $this->bc_user_model = User::findOne(['id' => $this->bc_model->user_id]);
        $this->user_profile_model = CboMemberProfile::findOne(['user_id' => $this->bc_model->user_id]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['mobile_no'], 'required'],
            [['first_name'], 'required'],
            [['mobile_no'], \common\validators\MobileNoValidator::className(), 'message' => 'Invalid Mobile No'],
            [['mobile_no'], \common\validators\BcMobileNoValidator::className()],
            [['first_name', 'middle_name', 'sur_name'], 'string', 'max' => 100],
            [['first_name'], 'string', 'min' => 3],
            [['first_name', 'middle_name', 'sur_name'], 'trim'],
            [['terms_and_condition'], 'compare', 'compareValue' => true, 'message' => 'Please tick authenticated'],
//            [['old_mobile_no']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'mobile_no' => 'New mobile no',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'sur_name' => 'Surname',
            'terms_and_condition' => "I've checked and verified BC's new mobile number and Name. This mob. number stands authenticated.",
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }

        $this->bc_selection_user_model->mobile_no = $this->mobile_no;
        if ($this->bc_selection_user_model->validate()) {

            $this->bc_model->first_name = ucfirst(strtolower($this->first_name));
            $this->bc_model->middle_name = ucfirst(strtolower($this->middle_name));
            $this->bc_model->sur_name = ucfirst(strtolower($this->sur_name));
            $this->bc_model->mobile_no = $this->mobile_no;
            $this->bc_model->mobile_no_update_by = \Yii::$app->user->identity->id;
            $this->bc_model->mobile_no_update_date = new \yii\db\Expression('NOW()');
            $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_NAME_MOBILE_NO_UPDATE;

            if ($this->bc_selection_user_model->save() and $this->bc_model->save()) {
                if ($this->bc_model->user_id and $this->bc_model->cbo_shg_id) {
                    if ($this->mobile_no != $this->old_mobile_no) {
                        $rishta_member = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['mobile' => $this->old_mobile_no, 'cbo_shg_id' => $this->bc_model->cbo_shg_id, 'status' => 1])->one();
                        if (isset($rishta_member) and $rishta_member != null) {
                            $rishta_member->mobile = $this->mobile_no;
                            $rishta_member->save();
                        }
                    }
                }
                if (isset($this->bc_rs_model) and $this->bc_rs_model != null) {
                    $this->bc_rs_model->first_name = ucfirst(strtolower($this->first_name));
                    $this->bc_rs_model->middle_name = ucfirst(strtolower($this->middle_name));
                    $this->bc_rs_model->sur_name = ucfirst(strtolower($this->sur_name));
                    $this->bc_rs_model->otp_mobile_no = $this->mobile_no;
                    $this->bc_rs_model->save();
                }
                if (isset($this->bc_user_model) and $this->bc_user_model != null) {
                    $this->bc_user_model->name = ucwords(strtolower($this->bc_model->name));
                    $this->bc_user_model->username = $this->mobile_no;
                    $this->bc_user_model->mobile_no = $this->mobile_no;
                    $this->bc_user_model->password = $this->mobile_no;
                    $this->bc_user_model->setPassword($this->mobile_no);
                    $this->bc_user_model->setUpd($this->mobile_no);
                    $this->bc_user_model->save();
                }
                if (isset($this->user_profile_model) and $this->user_profile_model != null) {
                    $this->user_profile_model->first_name = ucfirst(strtolower($this->first_name));
                    $this->user_profile_model->middle_name = ucfirst(strtolower($this->middle_name));
                    $this->user_profile_model->sur_name = ucfirst(strtolower($this->sur_name));
                    $this->user_profile_model->primary_phone_no = $this->mobile_no;
                    $this->user_profile_model->save();
                }
            } else {
                
            }
        }
        return $this;
    }

}
