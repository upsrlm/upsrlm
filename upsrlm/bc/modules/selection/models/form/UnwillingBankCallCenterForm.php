<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\base\Model;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcUnwillingCallCenter;
use bc\modules\training\models\RsetisBatchParticipants;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

class UnwillingBankCallCenterForm extends Model {

    public $id;
    public $bc_application_id;
    public $bc_selection_user_id;
    public $rsetis_call;
    public $express_reluctance;
    public $unwilling_reason;
    public $unwilling_reason1;
    public $unwilling_reason2;
    public $unwilling_reason3;
    public $unwilling_reason4;
    public $unwilling_reason5;
    public $unwilling_reason6;
    public $unwilling_reason7;
    public $unwilling_reason7_text;
    public $entry_by;
    public $entry_date;
    public $entry_type;
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
    public $participant_model;
    public $training_model;

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->training_status = $this->bc_model->training_status;
        $this->entry_type = SrlmBcApplication::UNWILLING_TYPE_BANK;
        $this->unwilling_model = BcUnwillingCallCenter::findOne(['bc_application_id' => $this->bc_model->id, 'entry_type' => $this->entry_type]);
        $this->participant_model = RsetisBatchParticipants::findOne(['bc_application_id' => $this->bc_model->id]);
        $this->training_model = \bc\modules\training\models\RsetisCenterTraining::findOne($this->bc_model->training_id);
        if ($this->participant_model == null)
            $this->participant_model = new RsetisBatchParticipants();
        if ($this->unwilling_model == null)
            $this->unwilling_model = new BcUnwillingCallCenter();
        if ($this->bc_model != NULL) {
            $this->bc_application_id = $this->bc_model->id;
            $this->bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
        }
        $this->unwilling_reason_option = GenralModel::unwilling_reason_call_center_option();
        $this->yes_no_option = [1 => 'हाँ', 0 => 'नहीं'];
    }

    public function rules() {
        return [
            [['bc_application_id', 'bc_selection_user_id', 'rsetis_call'], 'required', 'message' => 'Is required'],
            [
                'express_reluctance',
                'required',
                'when' => function ($model) {
                    return $model->rsetis_call == 1;
                },
                'whenClient' => "function (attribute, value) { 
              return $('#rsetis_call').val() == '1'; 
          }"
            ],
            [
                'unwilling_reason',
                'required',
                'when' => function ($model) {
                    return $model->express_reluctance == 1;
                },
                'whenClient' => "function (attribute, value) { 
              return $('#express_reluctance').val() == '1'; 
          }"
            ],
            [['unwilling_reason1', 'unwilling_reason2', 'unwilling_reason3', 'unwilling_reason4', 'unwilling_reason5', 'unwilling_reason6', 'unwilling_reason7', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['entry_date'], 'safe'],
            [['unwilling_reason7_text'], 'string', 'max' => 500],
            [['unwilling_reason7_text'], 'trim'],
            ['unwilling_reason', \common\validators\UnwillingReasionValidator::className()],
            ['training_status', 'in', 'range' => [3]],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'rsetis_call' => 'क्या आपको Partner agency bank से जुड़ने के लिए फ़ोन किया गया था?',
            'express_reluctance' => 'अगर हाँ, तो क्या आपने जुड़ने में अपनी अनिच्छा ज़ाहिर की ?',
            'unwilling_reason' => 'अगर हाँ, तो कृपया अपने अनिच्छा के कारण बतायें -',
            'unwilling_reason7_text' => 'कोई अन्य कारण;',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {

        $this->unwilling_model->setAttributes([
            'bc_application_id' => $this->bc_application_id,
            'bc_selection_user_id' => $this->bc_selection_user_id,
            'rsetis_call' => $this->rsetis_call,
            'express_reluctance' => $this->express_reluctance,
            'entry_by' => \Yii::$app->user->identity->id,
            'entry_date' => new Expression('NOW()'),
            'entry_type' => $this->entry_type,
        ]);
        if ($this->express_reluctance) {
            if (isset($this->unwilling_reason) and is_array($this->unwilling_reason)) {
                foreach ($this->unwilling_reason as $unwilling_reason_val) {
                    $name = 'unwilling_reason' . $unwilling_reason_val;
                    $this->unwilling_model->$name = 1;
                }
            }
        }
        if ($this->unwilling_model->validate()) {
            if ($this->unwilling_model->save()) {
                if ($this->unwilling_model->unwilling_reason1 or $this->unwilling_model->unwilling_reason2 or $this->unwilling_model->unwilling_reason3 or $this->unwilling_model->unwilling_reason4 or $this->unwilling_model->unwilling_reason5 or $this->unwilling_model->unwilling_reason6) {
                    $this->bc_model->bc_unwilling_bank_call_center = 1;
                } else {
                    $this->bc_model->bc_unwilling_bank_call_center = 0;
                }

                $this->bc_model->bc_unwilling_bank_call_center_by = \Yii::$app->user->identity->id;
                $this->bc_model->bc_unwilling_bank_call_center_date = new Expression('NOW()');
                $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_BANK_CALL_CENTER_UNWILLING;
                $this->bc_model->save();
                $this->markunwilling();
                return $this->unwilling_model;
            } else {

                return false;
            }
        } else {

            return false;
        }
    }

    public function markunwilling() {
        if ($this->bc_model->bc_unwilling_bank == 1 and $this->bc_model->bc_unwilling_bank_call_center == 1 and in_array($this->bc_model->training_status, [SrlmBcApplication::TRAINING_STATUS_PASS])) {

            if ($this->bc_model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) {
                $this->bc_model->training_status = SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING;
                $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_FINAL_UNWILLING;
                $this->participant_model->setAttributes([
                    'bc_application_id' => $this->bc_model->id,
                    'bc_selection_user_id' => $this->bc_model->srlm_bc_selection_user_id,
                    'training_status' => SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING,
                    'status' => 1
                ]);
                if ($this->bc_model->save() and $this->participant_model->save()) {
                    if ($this->training_model != null) {
                        $model = new \bc\modules\training\models\TrainingEntity($this->training_model);
                        $model->calendarpopulate();
                        $this->training_model->save();
                    }
                }
            }
        }
    }

}
