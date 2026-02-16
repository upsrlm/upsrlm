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

class UnwillingRsetisForm extends Model {

    public $id;
    public $bc_application_id;
    public $bc_selection_user_id;
    public $entry_type;
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
        $this->entry_type = SrlmBcApplication::UNWILLING_TYPE_RSETHIS;
        $this->unwilling_model = BcUnwillingRsetis::findOne(['bc_application_id' => $this->bc_model->id, 'entry_type' => $this->entry_type]);
        if ($this->unwilling_model == null)
            $this->unwilling_model = new BcUnwillingRsetis();
        if ($this->bc_model != NULL) {
            $this->bc_application_id = $this->bc_model->id;
            $this->bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
        }
        $this->unwilling_reason_option = GenralModel::unwilling_reason_rsethis_option();
        $this->yes_no_option = [1 => 'हाँ', 0 => 'नहीं'];
    }

    public function rules() {
        return [
            [['bc_application_id', 'bc_selection_user_id'], 'required', 'message' => 'Is required'],
            [['unwilling_reason'], 'required', 'message' => 'एक से ज़्यादा कारण पर टिक कर सकते हैं'],
//            ['unwilling_reason', 'each', 'rule' => ['integer']],
            [['unwilling_reason1', 'unwilling_reason2', 'unwilling_reason3', 'unwilling_reason4', 'unwilling_reason5', 'unwilling_reason6', 'unwilling_reason7', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['entry_date'], 'safe'],
            [['unwilling_reason7_text'], 'string', 'max' => 500],
            [['unwilling_reason7_text'], 'trim'],
            ['unwilling_reason', \common\validators\UnwillingReasionValidator::className()],
            ['training_status', 'in', 'range' => [0]],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
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
            'entry_by' => \Yii::$app->user->identity->id,
            'entry_date' => new Expression('NOW()'),
            'entry_type' => $this->entry_type,
        ]);

        if (isset($this->unwilling_reason) and is_array($this->unwilling_reason)) {
            foreach ($this->unwilling_reason as $unwilling_reason_val) {
                $name = 'unwilling_reason' . $unwilling_reason_val;
                $this->unwilling_model->$name = 1;
            }
        }
        if ($this->unwilling_model->validate()) {
            if ($this->unwilling_model->save()) {
                if ($this->unwilling_model->unwilling_reason1 or $this->unwilling_model->unwilling_reason2 or $this->unwilling_model->unwilling_reason3 or $this->unwilling_model->unwilling_reason4 or $this->unwilling_model->unwilling_reason5 or $this->unwilling_model->unwilling_reason6) {
                    $this->bc_model->bc_unwilling_rsetis = 1;
                } else {
                    $this->bc_model->bc_unwilling_rsetis = 0;
                }
                $this->bc_model->bc_unwilling_rsetis_by = \Yii::$app->user->identity->id;
                $this->bc_model->bc_unwilling_rsetis_date = new Expression('NOW()');
                $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_RSETHIS_UNWILLING;
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
