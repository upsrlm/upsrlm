<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\base\Model;
use bc\modules\training\models\RsetisBatchTraining;

class TrainingBatchForm extends Model {

    public $id;
    public $batch_name;
    public $rsetis_center_id;
    public $rsetis_center_training_id;
    public $batch_training_model;
    public $check;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $isNew;

    public function __construct($model = null) {
        $this->batch_training_model = \Yii::createObject([
                    'class' => RsetisBatchTraining::className()
        ]);
    }

    public function rules() {
        return [
            [['batch_name', 'rsetis_center_id', 'rsetis_center_training_id'], 'safe'],
            ['batch_name', 'required', 'when' => function ($model) {
                    return $model->check == true;
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#check').val() === 'true';
            }"],
            ['check', 'compare',
                'compareValue' => true,
                'operator' => '==', 'when' => function ($model) {
                    return $model->batch_name != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#batch_name').val() !== '';
            }"],
            [['rsetis_center_id', 'rsetis_center_training_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['batch_name'], 'string', 'max' => 255],
            [['batch_name'], 'string', 'min' => 3],
            [['batch_name'], 'trim'],
            [['status'], 'default', 'value' => 1],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'batch_name' => 'Batch Name',
            'rsetis_center_id' => 'Center Id',
            'rsetis_center_training_id' => 'Training',
        ];
    }

}
