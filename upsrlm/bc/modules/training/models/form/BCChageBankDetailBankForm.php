<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\training\models\RsetisBatchParticipants;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use bc\models\master\CboMasterBank;
use common\models\CboMemberProfile;
use yii\base\Model;
use yii\web\UploadedFile;

class BCChageBankDetailBankForm extends \yii\base\Model {

    public $id;
    public $bc_settlement_account_bank_id;
    public $bank_id;
    public $name_of_bank;
    public $bc_model;
    public $bank_option = [];

    public function __construct($model) {
        $this->bc_model = $model;
        $this->bank_option = ArrayHelper::map(CboMasterBank::find()->where(['status' => 1])->orderBy('display_order asc')->all(), 'id', 'bank_name');
        $this->bank_id = $this->bc_model->bank_id;
        $this->name_of_bank = $this->bc_model->name_of_bank;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bank_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bank_id' => "BC Account Bank",
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }
        $this->bc_model->bank_id = $this->bank_id;
        $bank_model = CboMasterBank::findOne($this->bank_id);
        if ($bank_model != null) {
            if ($this->bc_model->bc_settlement_account_bank_confirm == '0') {
                $this->bc_model->bc_settlement_account_bank_name = $bank_model->bank_name;
                $this->bc_model->bc_settlement_account_bank_id = $this->bank_id;
            }
            $this->bc_model->name_of_bank = $bank_model->bank_name;
        }
        $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_BANK_CHANGE;
        if ($this->bc_model->save()) {
            
        }

        return $this;
    }
}
