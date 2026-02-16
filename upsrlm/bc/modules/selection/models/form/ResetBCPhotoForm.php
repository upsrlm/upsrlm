<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;

class ResetBCPhotoForm extends \yii\base\Model {

    public $bc_photo_status;
    public $bc_model;

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
    }

    public function rules() {
        return [
            [['bc_photo_status'], 'compare', 'compareValue' => true, 'message' => 'Please tick Reset profile photo of BC'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'bc_photo_status' => 'Reset profile photo of BC',
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }
        if ($this->bc_photo_status) {
            $this->bc_model->bc_photo_status = 0;

            if ($this->bc_model->save()) {
                
            }
        }
        return $this;
    }

}
