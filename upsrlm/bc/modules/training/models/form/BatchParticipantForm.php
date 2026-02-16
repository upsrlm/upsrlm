<?php

namespace bc\modules\training\models\form;

use bc\modules\selection\models\base\GenralModel;
use Yii;
use yii\base\Model;
use bc\modules\training\models\RsetisBatchParticipants;

class BatchParticipantForm extends Model {

    public $rsetis_center_id;
    public $rsetis_batch_id;
    public $rsetis_center_training_id;
    public $district_code;
    public $bc_application_id;
    public $bc_selection_user_id;
    public $participant_ids;
    public $district_option;
    public $batch_model;
    public $block_option;
    public $block_code;
    public $block_model;
    public $center_option;
    public $isNew;
    public $max_batch_participant_alow = 7000;
    public $batch_participant_count;
    public $remaining_participant;

    /**
     * {@inheritdoc}
     */
    public function __construct($model = null) {

        $this->batch_model = $model;
        $this->rsetis_center_id = $this->batch_model->rsetis_center_id;
        $this->rsetis_batch_id = $this->batch_model->id;
        $this->rsetis_center_training_id = $this->batch_model->rsetis_center_training_id;
        $this->district_code = $this->batch_model->district_code;
        $this->block_option = GenralModel::blockoption($this);

        $this->batch_participant_count = \bc\modules\training\models\RsetisBatchParticipants::find()->where(['rsetis_batch_id' => $this->rsetis_batch_id])->count();
        $this->remaining_participant = ($this->max_batch_participant_alow - $this->batch_participant_count);
    }

    public function rules() {
        return [
            [['block_code', 'participant_ids'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'rsetis_center_id' => 'Venue',
            'rsetis_batch_id' => 'Batch',
            'block_code' => 'Block',
            'rsetis_center_training_id' => 'Training',
            'participant_ids' => 'Participants',
        ];
    }

}
