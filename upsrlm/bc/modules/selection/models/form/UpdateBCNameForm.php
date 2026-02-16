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

class UpdateBCNameForm extends \yii\base\Model {

    public $id;
    public $mobile_no;
    public $first_name;
    public $middle_name;
    public $sur_name;
    public $terms_and_condition;
    public $bc_model;
    public $bc_selection_user_model;
    public $bc_rs_model;
    public $bc_user_model;
    public $user_profile_model;

    public function __construct($model) {
        $this->bc_model = $model;
        $this->bc_selection_user_model = $model->user;

        $this->first_name = $this->bc_model->first_name;
        $this->middle_name = $this->bc_model->middle_name;
        $this->sur_name = $this->bc_model->sur_name;
        $this->bc_rs_model = RsetisBatchParticipants::findOne(['bc_application_id' => $this->bc_model->id]);
        $this->bc_user_model = User::findOne(['id' => $this->bc_model->user_id]);
        $this->user_profile_model = CboMemberProfile::findOne(['user_id' => $this->bc_model->user_id]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            
            [['first_name'], 'required'],
            [['first_name', 'middle_name', 'sur_name'], 'string', 'max' => 100],
            [['first_name'], 'string', 'min' => 3],
            [['first_name', 'middle_name', 'sur_name'], 'trim'],
            [['terms_and_condition'], 'compare', 'compareValue' => true, 'message' => 'Please tick authenticated'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'sur_name' => 'Surname',
            'terms_and_condition' => "I've checked and verified BC's new  Name. This name stands authenticated.",
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }

        $this->bc_model->first_name = ucfirst(strtolower($this->first_name));
        $this->bc_model->middle_name = ucfirst(strtolower($this->middle_name));
        $this->bc_model->sur_name = ucfirst(strtolower($this->sur_name));
        $this->bc_model->mobile_no_update_by = \Yii::$app->user->identity->id;
        $this->bc_model->mobile_no_update_date = new \yii\db\Expression('NOW()');
        $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_NAME_MOBILE_NO_UPDATE;
        if ($this->bc_model->save()) {

            if (isset($this->bc_rs_model) and $this->bc_rs_model != null) {
                $this->bc_rs_model->first_name = ucfirst(strtolower($this->first_name));
                $this->bc_rs_model->middle_name = ucfirst(strtolower($this->middle_name));
                $this->bc_rs_model->sur_name = ucfirst(strtolower($this->sur_name));

                $this->bc_rs_model->save();
            }
            if (isset($this->bc_user_model) and $this->bc_user_model != null) {
                $this->bc_user_model->name = ucwords(strtolower($this->bc_model->name));
                $this->bc_user_model->save();
            }
            if (isset($this->user_profile_model) and $this->user_profile_model != null) {
                $this->user_profile_model->first_name = ucfirst(strtolower($this->first_name));
                $this->user_profile_model->middle_name = ucfirst(strtolower($this->middle_name));
                $this->user_profile_model->sur_name = ucfirst(strtolower($this->sur_name));
                $this->user_profile_model->save();
            }
        } else {
            
        }

        return $this;
    }

}
