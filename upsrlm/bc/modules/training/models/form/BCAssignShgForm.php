<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\base\Model;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use cbo\models\CboBc;
use common\models\User;
use common\models\CboMembers;
use common\models\CboMemberProfile;
use cbo\models\Shg;

class BCAssignShgForm extends Model {

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
    public $cbo_bc_id;
    public $user_id;
    public $cbo_shg_id;
    public $shg_option = [];
    public $bc_application_model;
    public $user_model;
    public $cbo_member_model;
    public $cbo_member_profile_model;
    public $bmmu_models;

    /**
     * {@inheritdoc}
     */
    public function __construct($model) {

        $this->bc_application_model = $model;
        $this->user_model = User::findOne(['username' => $this->bc_application_model->user->mobile_no]);

        $this->district_code = $this->bc_application_model->district_code;

        $this->block_code = $this->bc_application_model->block_code;
        $this->gram_panchayat_code = $this->bc_application_model->gram_panchayat_code;
        $this->shg_option = \yii\helpers\ArrayHelper::map(Shg::find()->where(['!=', 'status', -1])->andWhere(['gram_panchayat_code' => $this->gram_panchayat_code, 'dummy_column' => 0])->orderBy('name_of_shg asc')->all(), 'id', 'name_of_shg');
        $this->division_code = $this->bc_application_model->division_code;
        $this->division_name = $this->bc_application_model->division_name;
        $this->village_code = $this->bc_application_model->village_code;
        $this->gram_panchayat_name = $this->bc_application_model->gram_panchayat_name;
        $this->village_name = $this->bc_application_model->village_name;
        if ($this->bc_application_model != null) {
            $this->cbo_shg_id = $this->bc_application_model->cbo_shg_id;
        }
        $this->bmmu_models = User::find()->joinWith(['blocks'])->where(['user.status' => User::STATUS_ACTIVE, 'user.role' => \common\models\master\MasterRole::ROLE_BMMU])->andWhere(['relation_user_bdo_block.block_code' => $this->block_code])->all();
    }

    public function rules() {
        return [
            [['cbo_shg_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'SHG',
        ];
    }

}
