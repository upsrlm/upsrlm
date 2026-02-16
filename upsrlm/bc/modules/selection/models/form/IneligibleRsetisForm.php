<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\base\Model;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcIneligibleRsetis;
use bc\modules\training\models\RsetisBatchParticipants;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

class IneligibleRsetisForm extends Model {

    public $id;
    public $bc_application_id;
    public $bc_selection_user_id;
    public $ineligible_reason;
    public $ineligible_reason1;
    public $ineligible_reason2;
    public $ineligible_reason3;
    public $ineligible_reason4;
    public $ineligible_reason5;
    public $entry_by;
    public $entry_date;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $bc_model;
    public $participant_model;
    public $ineligible_model;
    public $ineligible_reason_option = [];
    public $yes_no_option = [];
    public $training_model;

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->ineligible_model = BcIneligibleRsetis::findOne(['bc_application_id' => $this->bc_model->id]);
        $this->participant_model = RsetisBatchParticipants::findOne(['bc_application_id' => $this->bc_model->id]);
        $this->training_model = \bc\modules\training\models\RsetisCenterTraining::findOne($this->bc_model->training_id);
        if ($this->ineligible_model == null)
            $this->ineligible_model = new BcIneligibleRsetis();
        if ($this->participant_model == null)
            $this->participant_model = new RsetisBatchParticipants();
        if ($this->bc_model != NULL) {
            $this->bc_application_id = $this->bc_model->id;
            $this->bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
        }
        $this->ineligible_reason_option = GenralModel::ineligible_reason_rsethis_option();
    }

    public function rules() {
        return [
            [['bc_application_id', 'bc_selection_user_id'], 'required', 'message' => 'Is required'],
            [['ineligible_reason'], 'required', 'message' => 'एक या एक से ज़्यादा अपात्र के कारण पर टिक कर सकते हैं'],
            [['ineligible_reason', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['entry_date'], 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ineligible_reason' => 'अगर हाँ, तो कृपया अपात्र के कारण बतायें -',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {

        $this->ineligible_model->setAttributes([
            'bc_application_id' => $this->bc_application_id,
            'bc_selection_user_id' => $this->bc_selection_user_id,
            'entry_by' => \Yii::$app->user->identity->id,
            'entry_date' => new Expression('NOW()'),
        ]);

        if (isset($this->ineligible_reason) and is_array($this->ineligible_reason)) {
            foreach ($this->ineligible_reason as $ineligible_reason_val) {
                $name = 'ineligible_reason' . $ineligible_reason_val;
                $this->ineligible_model->$name = 1;
            }
        }
        if ($this->ineligible_model->validate()) {
            $this->bc_model->training_id = 0;
            $this->bc_model->training_center_id = 0;
            $this->bc_model->training_batch_id = 0;
            $this->bc_model->training_status = SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE;
            $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_INELIGIBLE;
            $this->participant_model->setAttributes([
                'bc_application_id' => $this->bc_application_id,
                'rsetis_center_id' => 0,
                'rsetis_batch_id' => 0,
                'rsetis_center_training_id' => 0,
                'bc_selection_user_id' => $this->bc_selection_user_id,
                'training_status' => SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE,
                'status' => 1
            ]);
            if ($this->ineligible_model->save() and $this->bc_model->save() and $this->participant_model->save()) {
                if ($this->training_model != null) {
                    $model = new \bc\modules\training\models\TrainingEntity($this->training_model);
                    $model->calendarpopulate();
                    $this->training_model->save();
                }
                return $this->ineligible_model;
            } else {

                return false;
            }
        } else {

            return false;
        }
    }

}
