<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;

class UploadIIBFCertificateForm extends \yii\base\Model {

    public $exam_score;
    public $certificate_code;
    public $participant_model;
    public $training_status;
    public $iibf_photo_status;
    public $iibf_photo_upload_by;
    public $iibf_photo_upload_date;
    public $iibf_photo_file_name;
    public $training_status_option = [];

    const PASS_MARKS = 40;

    public function __construct($participant_model) {
        $this->participant_model = $participant_model;
        $this->training_status = $this->participant_model->training_status;
    }

    public function rules() {
        return [
            [['iibf_photo_file_name'], 'required'],
            [['iibf_photo_file_name'], 'file', 'skipOnEmpty' => TRUE, 'extensions' => 'gif,jpg,jpeg,png', 'maxSize' => 1024 * 1024 * 1, 'tooBig' => 'File Size Limit is I MB'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iibf_photo_file_name' => 'IIBF Certificate Photo',
        ];
    }

}
