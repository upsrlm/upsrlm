<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;

class AlreadyCetifiedForm extends \yii\base\Model {

    public $exam_score;
    public $certificate_code;
    public $participant_model;
    public $training_status;
    public $iibf_date;
    public $iibf_by;
    public $iibf_photo_status;
    public $iibf_photo_upload_by;
    public $iibf_photo_upload_date;
    public $iibf_photo_file_name;
    public $training_status_option = [];

    const PASS_MARKS = 40;

    public function __construct($participant_model) {
        $this->participant_model = $participant_model;
    }

    public function rules() {
        return [
            [['training_status'], 'required'],
            ['exam_score', 'required'],
            ['exam_score', 'compare', 'compareValue' => 40, 'operator' => '>=', 'type' => 'number'],           
            ['certificate_code', 'required'],
            ['iibf_date', 'required'],
            [['exam_score'], 'trim'],
            [['certificate_code'], 'trim'],
            [['exam_score'], 'number'],
            [['certificate_code'], 'string', 'max' => 100],
            [['certificate_code'], 'string', 'min' => 8, 'message' => '{attribute} mimimum 8 digit number'],
            ['certificate_code', 'integer', 'min' => 0, 'max' => 99999999999999],
            [['iibf_photo_file_name'], 'file', 'skipOnEmpty' => TRUE, 'extensions' => 'gif,jpg,jpeg,png', 'maxSize' => 1024 * 1024 * 1, 'tooBig' => 'File Size Limit is I MB'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'exam_score' => 'Exam Score',
            'certificate_code' => 'IIBF membership No.',
            'training_status' => 'Status',
            'iibf_photo_file_name' => 'IIBF Certificate Photo',
            'iibf_date' => 'IIBF Date',
        ];
    }

}
