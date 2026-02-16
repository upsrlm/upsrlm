<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\base\Model;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcUnwillingRsetis;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

class UnwillingBCNewForm extends Model {

    public $id;
    public $bc_application_id;
    public $bc_selection_user_id;
    public $entry_type;
    public $unwilling_reason;
    public $bc_unwilling;
    public $entry_by;
    public $entry_date;
    public $training_status;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $bc_model;
    public $unwilling_model;
    public $unwilling_reason_option = [];
    public $yes_no_option = [];

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->training_status = $this->bc_model->training_status;
        $this->entry_type = SrlmBcApplication::UNWILLING_TYPE_BANK;
        $this->unwilling_model = BcUnwillingRsetis::findOne(['bc_application_id' => $this->bc_model->id, 'entry_type' => $this->entry_type]);
        if ($this->unwilling_model == null){
            $this->bc_unwilling=1;
            $this->unwilling_model = new BcUnwillingRsetis();
        }else{
            
        }   
        if ($this->bc_model != NULL) {
            $this->bc_application_id = $this->bc_model->id;
            $this->bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
        }
        $this->unwilling_reason_option = GenralModel::unwilling_reason_bc_option_new();
        $this->yes_no_option = [1 => 'हाँ', 2 => 'नहीं'];
//        print_r($this->unwilling_model);exit;
    }

    public function rules() {
        return [
            [['bc_application_id', 'bc_selection_user_id', 'bc_unwilling'], 'required', 'message' => 'Is required'],
            //[['unwilling_reason'], 'required', 'message' => 'एक से ज़्यादा कारण पर टिक कर सकते हैं'],
            [
                'unwilling_reason',
                'required',
                'when' => function ($model) {
                    return $model->bc_unwilling == 1;
                },
                'whenClient' => "function (attribute, value) { 
              return $('#bc_unwilling').val() == '1'; 
          }"
            ],
            ['unwilling_reason', \common\validators\BankUnwillingValidator::className()],
            ['training_status', 'in', 'range' => [3]],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_unwilling'=>'बीसी सखी द्वारा अनिच्छा',
            'unwilling_reason' => 'अगर हाँ, तो कृपया अपने अनिच्छा के कारण बतायें -',
            'status' => 'Status',
        ];
    }

    public function save() {

        $this->unwilling_model->setAttributes([
            'bc_application_id' => $this->bc_application_id,
            'bc_selection_user_id' => $this->bc_selection_user_id,
            'bc_entry_by' => \Yii::$app->user->identity->id,
            'bc_entry_date' => new Expression('NOW()'),
            'entry_type' => $this->entry_type,
        ]);
        $this->unwilling_model->bc_unwilling=$this->bc_unwilling;
        if ($this->bc_unwilling==1) {
            if (isset($this->unwilling_reason) and is_array($this->unwilling_reason)) {
                foreach ($this->unwilling_reason as $unwilling_reason_val) {
                    $name = 'bc_unwilling_reason' . $unwilling_reason_val;
                    $this->unwilling_model->$name = 1;
                }
            }
        }
        if (isset($this->unwilling_model->status) and $this->unwilling_model->status == 1) {
            $this->unwilling_model->status = 2;
        }
        if ($this->unwilling_model->validate()) {
            if ($this->unwilling_model->save()) {
                $this->bc_model->bc_unwilling_bc = $this->bc_unwilling;
                $this->bc_model->bc_unwilling_bc_by = \Yii::$app->user->identity->id;
                $this->bc_model->bc_unwilling_bc_date = new Expression('NOW()');
                $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_UNWILLING_BC;
                $this->bc_model->save();
                return $this->unwilling_model;
            } else {

                return false;
            }
        } else {
            
            return false;
        }
    }
}
