<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcSelectionUser;

/**
 * UploadPhotoForm
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class UploadPhotoForm extends Model {

    public $form_uuid;
    public $profile_photo;
    public $aadhar_front_photo;
    public $aadhar_back_photo;
    public $user_model;
    public $application_model;

    public function __construct($model) {
        $this->user_model = $model;
        $this->application_model = SrlmBcApplication::findOne(['srlm_bc_selection_user_id' => $this->user_model->id]);
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['profile_photo', 'aadhar_front_photo', 'aadhar_back_photo'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'form_uuid' => 'Form UUID',
            'profile_photo' => 'Profile Photo',
            'aadhar_front_photo' => 'Aadhar front photo',
            'aadhar_back_photo' => 'Aadhar back photo',
        ];
    }

}
