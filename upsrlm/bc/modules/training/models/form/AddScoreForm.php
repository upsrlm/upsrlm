<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;

class AddScoreForm extends \yii\base\Model {

    public $exam_score;
    public $certificate_code;
    public $participant_model;
    public $training_status;
    public $iibf_photo_status;
    public $iibf_photo_upload_by;
    public $iibf_photo_upload_date;
    public $iibf_photo_file_name;
    public $training_status_option = [];
    public $confirm_10th_pass;
    public $tenth_not_pass;

    const PASS_MARKS = 40;

    public function __construct($participant_model) {
        $this->participant_model = $participant_model;
//        $this->training_status_option = [34 => 'Add Score', 5 => 'Ineligible', 6 => 'Absent'];
        $this->training_status_option = [34 => 'Add Score', 6 => 'Absent'];
        if (in_array($this->participant_model->training_status, [3, 4])) {
            $this->training_status = 34;
        }
        if (in_array($this->participant_model->training_status, [5, 6])) {
            $this->training_status = $this->participant_model->training_status;
        }
        $this->exam_score = $this->participant_model->exam_score;
        $this->certificate_code = $this->participant_model->certificate_code;
        if (!in_array($this->participant_model->participant->reading_skills, [1, 2])) {
            $this->tenth_not_pass = 1;
        }
    }

    public function rules() {
        return [
            [['training_status'], 'required'],
            [['training_status'], \common\validators\BCTrainingStatusValidator::className()],
            ['exam_score', 'required', 'when' => function ($model) {
                    return $model->training_status == '34';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#training_status').val() == '34';
            }"],
            ['certificate_code', 'required', 'when' => function ($model) {
                    return $model->exam_score >= self::PASS_MARKS;
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#exam_score').val() >= '2';
            }"],
            [['exam_score'], 'trim'],
            [['certificate_code'], 'trim'],
            [['exam_score'], 'number'],
            [['certificate_code'], 'string', 'max' => 100],
            [['certificate_code'], 'string', 'min' => 8, 'message' => '{attribute} mimimum 8 digit number'],
            ['certificate_code', 'integer', 'min' => 0, 'max' => 99999999999999],
            [['iibf_photo_file_name'], 'file', 'skipOnEmpty' => TRUE, 'extensions' => 'gif,jpg,jpeg,png', 'maxSize' => 1024 * 1024 * 1, 'tooBig' => 'File Size Limit is I MB'],
            [['confirm_10th_pass'], 'compare', 'compareValue' => true, 'message' => 'Please tick BC is 10th pass'],
            [['tenth_not_pass'], 'safe']
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
            'confirm_10th_pass' => "I've checked and Confirm  BC is 10th pass",
        ];
    }

    public function checkgpapplicationstatus() {
        $return = true;
        $rest_gp_application = SrlmBcApplication::find()->where(['gram_panchayat_code' => $this->participant_model->participant->gram_panchayat_code, 'status' => 2])->andWhere(['!=', 'id', $this->participant_model->participant->id])->all();
        foreach ($rest_gp_application as $bc_model) {
            if (in_array($bc_model->training_status, [0, 1, 2, 3])) {
                $return = false;
                return $return;
            }
        }
        return $return;
    }

}
