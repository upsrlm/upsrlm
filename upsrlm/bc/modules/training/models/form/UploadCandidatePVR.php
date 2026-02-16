<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\training\models\RsetisBatchParticipants;

/**
 * UploadCandidatePVR
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class UploadCandidatePVR extends Model {

    public $pvr_upload_by;
    public $pvr_upload_file_name;
    public $pvr_upload_date;
    public $pvr_status;
    public $training_participant_model;
    public $application_model;

    public function __construct($training_participant_model) {
        $this->training_participant_model = $training_participant_model;
        $this->application_model = SrlmBcApplication::findOne(['id' => $this->training_participant_model->bc_application_id]);
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['pvr_upload_file_name'], 'required'],
            [['pvr_upload_file_name'], 'file', 'skipOnEmpty' => TRUE, 'extensions' => 'gif,jpg,jpeg,png', 'maxSize' => 1024 * 1024 * 1, 'tooBig' => 'File Size Limit is I MB'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'pvr_upload_by' => 'Upload By',
            'pvr_upload_file_name' => 'Select PVR File',
            'pvr_upload_date' => 'Upload Date',
            'pvr_status' => 'police verification status',
        ];
    }

}
