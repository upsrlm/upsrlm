<?php

namespace bc\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\training\models\RsetisBatchParticipants;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use common\models\CboMemberProfile;
use bc\models\master\MasterGramPanchayat;
use yii\base\Model;
use yii\web\UploadedFile;

class ChangeBankForm extends \yii\base\Model {

    public $id;
    public $master_partner_bank_id;
    public $old_master_partner_bank_id;
    public $bank_option = [];
    public $gp_model;

    public function __construct($model) {
        $this->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option();
        $this->gp_model = $model;
        if ($this->gp_model != null) {
            $this->old_master_partner_bank_id = $this->gp_model->master_partner_bank_id;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['master_partner_bank_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'master_partner_bank_id' => 'Partner Bank',
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }
        $this->gp_model->master_partner_bank_id = $this->master_partner_bank_id;
        $this->gp_model->previous_master_partner_bank_id = $this->old_master_partner_bank_id;
        if ($this->gp_model->bc_status == 1) {
            $this->gp_model->change_status = 1;
        } else {
            $bc_onboard = SrlmBcApplication::find()->select(['id'])->where(['gram_panchayat_code' => $this->gp_model->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.training_status' => 3])->andWhere(['not', ['srlm_bc_application.bankidbc' => null]])->count();
            if ($bc_onboard) {
                $this->gp_model->change_status = 1;
            } else {
                $this->gp_model->change_status = 2;
            }
        }
        $this->gp_model->updated_at = time();
        if ($this->gp_model->save()) {
            return $this->gp_model;
        }
        return $this;
    }
}
