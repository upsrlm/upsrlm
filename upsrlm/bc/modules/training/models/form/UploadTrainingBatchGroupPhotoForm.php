<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\base\GenralModel;
use bc\modules\training\models\RsetisCenterTraining;

/**
 * UploadCandidatePVR
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class UploadTrainingBatchGroupPhotoForm extends Model {

    public $group_photo_upload_by;
    public $group_photo_file_name;
    public $group_photo_upload_date;
    public $group_photo_status;
    public $training_model;

    public function __construct($training_model) {
        $this->training_model = $training_model;
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['group_photo_file_name'], 'required'],
            [['group_photo_file_name'], 'file', 'skipOnEmpty' => TRUE, 'extensions' => 'gif,jpg,jpeg,png', 'maxSize' => 1024 * 1024 * 1, 'tooBig' => 'File Size Limit is I MB'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'group_photo_upload_by' => 'Upload By',
            'group_photo_file_name' => 'Select Batch group photo',
            'group_photo_upload_date' => 'Upload Date',
            'group_photo_status' => 'status',
        ];
    }

}
