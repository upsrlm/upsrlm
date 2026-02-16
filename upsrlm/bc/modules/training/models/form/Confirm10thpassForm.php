<?php

namespace bc\modules\training\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\training\models\RsetisBatchParticipants;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use common\models\CboMemberProfile;
use yii\base\Model;
use yii\web\UploadedFile;

class Confirm10thpassForm extends \yii\base\Model {

    public $id;
    public $confirm_10th_pass;
    public $bc_model;

    public function __construct($model) {
        $this->bc_model = $model;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['confirm_10th_pass'], 'compare', 'compareValue' => true, 'message' => 'Please tick BC is 10th pass'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'confirm_10th_pass' => "I've checked and Confirm  BC is 10th pass",
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }
        $this->bc_model->reading_skills = 1;
        if (in_array($this->bc_model->blocked, [3])) {
            $this->bc_model->blocked = 0;
        }
        $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_CONFIRM_10TH_PASS;
        if ($this->bc_model->save()) {
            
        }

        return $this;
    }

}
