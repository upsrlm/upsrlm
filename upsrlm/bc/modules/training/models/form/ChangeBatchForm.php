<?php

namespace bc\modules\training\models\form;

use bc\modules\selection\models\base\GenralModel;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchTraining;
use bc\modules\training\models\RsetisCenterTraining;
use bc\modules\selection\models\SrlmBcApplication;

class ChangeBatchForm extends Model {

    public $id;
    public $training_id;
    public $current_training_model;
    public $new_training_model;
    public $new_trainig_option;
    public $participant_id;
    public $participant_model;
    public $bc_model;
    public $isNew;

    /**
     * {@inheritdoc}
     */
    public function __construct($model) {
        $this->participant_model = $model;
        $this->bc_model = $this->participant_model->participant;
        $this->current_training_model = $this->participant_model->training;
        $training = RsetisCenterTraining::find()->where(['!=', 'rsetis_center_training.status', -1])->andWhere(['district_code'=>$this->bc_model->district_code])->andWhere(['!=', 'rsetis_center_training.id', $this->participant_model->rsetis_center_training_id])->orderBy('training_start_date desc')->all();
        $this->new_trainig_option = ArrayHelper::map($training, 'id', function ($model) {
                    return date("d-m-Y", strtotime($model->training_start_date)) . " to " . date("d-m-Y", strtotime($model->training_start_date)) . ' (' . $model->tbatch->batch_name . ')';
                });
    }

    public function rules() {
        return [
            [['training_id', 'participant_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'training_id' => 'Batch',
        ];
    }

    public function save() {
        $this->new_training_model = RsetisCenterTraining::findOne($this->training_id);
        $this->participant_model->rsetis_center_training_id = $this->training_id;
        $this->participant_model->rsetis_center_id = $this->new_training_model->rsetis_center_id;
        $this->participant_model->rsetis_batch_id = $this->new_training_model->tbatch->id;
        $this->bc_model->training_id = $this->training_id;
        $this->bc_model->training_center_id = $this->new_training_model->rsetis_center_id;
        $this->bc_model->training_batch_id = $this->new_training_model->tbatch->id;
        $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_CHANGE_BATCH;
        if ($this->bc_model->save() and $this->participant_model->save()) {
            $this->new_training_model->save();
            $this->current_training_model->save();
            $modeln = new \bc\modules\training\models\TrainingEntity($this->new_training_model);
            $modeln->calendarpopulate();
            $modelc = new \bc\modules\training\models\TrainingEntity($this->current_training_model);
            $modelc->calendarpopulate();
            return $this;
        }
    }

}
