<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\base\Model;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\selection\models\BcUnwillingRsetis;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

class UnwillingUpsrlmNewForm extends Model {

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
    public $participant_model;
    public $training_model;
    public $unwilling_reason_option = [];
    public $yes_no_option = [];

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->training_status = $this->bc_model->training_status;
        $this->entry_type = SrlmBcApplication::UNWILLING_TYPE_BANK;
        $this->participant_model = RsetisBatchParticipants::findOne(['bc_application_id' => $this->bc_model->id]);
        $this->training_model = \bc\modules\training\models\RsetisCenterTraining::findOne($this->bc_model->training_id);
        $this->unwilling_model = BcUnwillingRsetis::findOne(['bc_application_id' => $this->bc_model->id, 'entry_type' => $this->entry_type]);
        $this->status = $this->unwilling_model->status;
        if ($this->bc_model != NULL) {
            $this->bc_application_id = $this->bc_model->id;
            $this->bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
        }
        $this->unwilling_reason_option = GenralModel::unwilling_reason_upsrlm_option_new();
        $this->yes_no_option = [1 => 'हाँ', 2 => 'नहीं'];
    }

    public function rules() {
        return [
            [['bc_application_id', 'bc_selection_user_id'], 'required', 'message' => 'Is required'],
            [['unwilling_reason'], 'required', 'message' => 'एक से ज़्यादा कारण पर टिक कर सकते हैं'],
            ['unwilling_reason', \common\validators\BankUnwillingValidator::className()],
            ['training_status', 'in', 'range' => [3]],
            ['status', 'in', 'range' => [3]],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'unwilling_reason' => 'अगर हाँ, तो कृपया अपने अनिच्छा के कारण बतायें -',
            'status' => 'Status',
        ];
    }

    public function save() {

        $this->unwilling_model->setAttributes([
            'bc_application_id' => $this->bc_application_id,
            'bc_selection_user_id' => $this->bc_selection_user_id,
            'upsrlm_entry_by' => \Yii::$app->user->identity->id,
            'upsrlm_entry_date' => new Expression('NOW()'),
            'entry_type' => $this->entry_type,
        ]);

        if (isset($this->unwilling_reason) and is_array($this->unwilling_reason)) {
            foreach ($this->unwilling_reason as $unwilling_reason_val) {
                $name = 'upsrlm_unwilling_reason' . $unwilling_reason_val;
                $this->unwilling_model->$name = 1;
            }
        }
        if (isset($this->unwilling_model->status) and $this->unwilling_model->status == 3) {
            $this->unwilling_model->status = 4;
        }
        if ($this->unwilling_model->validate()) {
            if ($this->unwilling_model->save()) {
                $this->bc_model->bc_unwilling_upsrlm = $this->bc_unwilling;
                $this->bc_model->bc_unwilling_upsrlm_by = \Yii::$app->user->identity->id;
                $this->bc_model->bc_unwilling_upsrlm_date = new Expression('NOW()');
                $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_UNWILLING_UPSRLM;
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
        if ($this->bc_model->bc_unwilling_bank == 1 and $this->bc_model->bc_unwilling_bc == 1 and $this->bc_model->bc_unwilling_cdo == 1 and in_array($this->bc_model->training_status, [SrlmBcApplication::TRAINING_STATUS_PASS])) {

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
