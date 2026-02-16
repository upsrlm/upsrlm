<?php

namespace bc\modules\selection\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\training\models\RsetisBatchParticipants;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use common\models\CboMemberProfile;
use yii\base\Model;
use yii\web\UploadedFile;

class AgeUpdateForm extends \yii\base\Model {

    public $id;
    public $age;
    public $terms_and_condition;
    public $bc_model;
    public $bc_selection_user_model;
    public $bc_rs_model;
    public $bc_user_model;
    public $user_profile_model;

    public function __construct($model) {
        $this->bc_model = $model;

        $this->age = $this->bc_model->age;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['age'], 'required'],
            [['age'], 'trim'],
            [['age'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'age' => 'Age',
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }

        $this->bc_model->age = $this->age;
        if ($this->bc_model->save()) {
            
        } else {
            
        }

        return $this;
    }

}
