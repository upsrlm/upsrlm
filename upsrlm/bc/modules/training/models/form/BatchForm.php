<?php

namespace bc\modules\training\models\form;

use bc\modules\selection\models\base\GenralModel;
use Yii;
use yii\base\Model;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchTraining;

class BatchForm extends Model {

    public $id;
    public $batch_name;
    public $rsetis_center_training_id;
    public $rsetis_center_id;
    public $district_code;
    public $batch_model;
    public $district_option = [];
    public $isNew;

    /**
     * {@inheritdoc}
     */
    public function __construct($model = null) {
        $this->batch_model = \Yii::createObject([
                    'class' => RsetisBatchTraining::className()
        ]);
        $this->district_option = GenralModel::districtoption();
        if ($model != null) {
            $this->batch_model = $model;
            $this->batch_name = $this->batch_model->batch_name;
            $this->rsetis_center_id = $this->batch_model->rsetis_center_id;
            $this->rsetis_center_training_id = $this->batch_model->rsetis_center_training_id;
            $this->district_code = $this->batch_model->district_code;
        }
    }

    public function rules() {
        return [
            [['batch_name', 'district_code'], 'required'],
            [['batch_name'], 'trim'],
            [['batch_name'], 'string', 'min' => 4, 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'batch_name' => 'Batch Name',
            'district_code' => 'District',
            'rsetis_center_training_id' => 'Training',
        ];
    }

}
