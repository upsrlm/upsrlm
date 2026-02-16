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

class BCSettelmentBankConfirmForm extends \yii\base\Model {

    public $id;
    public $bc_settlement_account_bank_id;
    public $bc_settlement_account_bank_confirm;
    public $bc_settlement_account_bank_name;
    public $bc_settlement_account_ifsc_code;
    public $bc_settlement_account_no;
    public $bc_model;
    public $bank_option = [];

    public function __construct($model) {
        $this->bc_model = $model;
        $this->bank_option = ArrayHelper::map(CboMasterBank::find()->where(['status' => 1])->orderBy('display_order asc')->all(), 'id', 'bank_name');
        $this->bc_settlement_account_bank_id = $this->bc_model->bc_settlement_account_bank_id;
        $this->bc_settlement_account_no = $this->bc_model->bc_settlement_account_no;
        $this->bc_settlement_account_ifsc_code = $this->bc_model->bc_settlement_account_ifsc_code;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_settlement_account_bank_id'], 'required'],
            [['bc_settlement_account_bank_confirm'], 'required'],
            [['bc_settlement_account_ifsc_code'], 'trim'],
            [['bc_settlement_account_no'], 'trim'],
            [['bc_settlement_account_ifsc_code'], 'required'],
            [['bc_settlement_account_no'], 'required'],
            [['bc_settlement_account_no'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->bc_model->$attribute != $model->$attribute;
                }, 'targetClass' => SrlmBcApplication::className(), 'message' => 'This Settelment Account No of BC has already been taken', 'targetAttribute' => 'bc_settlement_account_no'],
            [['bc_settlement_account_bank_confirm'], 'compare', 'compareValue' => true, 'message' => 'Please tick BC settelment bank'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_settlement_account_bank_id' => "BC settelment bank",
            'bc_settlement_account_bank_name' => "BC settelment bank",
            'bc_settlement_account_ifsc_code' => "BC settelment bank IFSC Code",
            'bc_settlement_account_no' => "BC settelment Account No.",
            'bc_settlement_account_bank_confirm' => "I've checked and Confirm  BC settelment bank",
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }
        $this->bc_model->bc_settlement_account_bank_id = $this->bc_settlement_account_bank_id;
        $bank_model = CboMasterBank::findOne($this->bc_settlement_account_bank_id);
        if ($bank_model != null) {
            $this->bc_model->bc_settlement_account_bank_name = $bank_model->bank_name;
        }
        $this->bc_model->bc_settlement_account_ifsc_code = $this->bc_settlement_account_ifsc_code;
        $this->bc_model->bc_settlement_account_no = $this->bc_settlement_account_no;
        $this->bc_model->bc_settlement_account_bank_confirm = $this->bc_settlement_account_bank_confirm;

        $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_SETTELMENT_BANK_CONFIRM;
        if ($this->bc_model->save()) {
            
        }

        return $this;
    }
}
