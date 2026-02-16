<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\base\Model;
use bc\modules\training\models\RsetisBatchTraining;

/**
 * This is the model class for table "rsetis_center".
 *
 * @property int $id
 * @property string $batch_name
 * @property int $rsetis_center_id
 * @property int $rsetis_center_training_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 */
class RsetisBatchTrainingForm extends Model {

    /**
     * {@inheritdoc}
     */
    public $id;
    public $batch_name;
    public $rsetis_center_id;
    public $rsetis_center_training_id;
    public $batch_training_model;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    // public $district_option=[];
    public $isNew;

    public function __construct($model = null) {
        $this->batch_training_model = \Yii::createObject([
                    'class' => RsetisBatchTraining::className()
        ]);

        $this->isNew = true;

        if ($model != '') {
            // $batchs=RsetisBatchTraining::find()->andWhere(['created_by'=>Yii::$app->user->identity->id,'rsetis_center_id'=>$model->batch_training_model->rsetis_center_id])->all();
            //     foreach($batchs as $batch){
            //         $this->batch_1_name=$batch->name;
            //     }
            $this->isNew = false;
            $this->batch_training_model = $model;
            $this->batch_name = $this->batch_training_model->batch_name;
            $this->rsetis_center_id = $this->batch_training_model->rsetis_center_id;
            $this->rsetis_center_training_id = $this->batch_training_model->rsetis_center_training_id;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['batch_name', 'rsetis_center_id', 'rsetis_center_training_id'], 'required'],
            [['rsetis_center_id', 'rsetis_center_training_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['batch_name'], 'string', 'max' => 255],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['batch_name', 'rsetis_center_id', 'rsetis_center_training_id'];
        $scenarios['update'] = ['batch_name', 'rsetis_center_id', 'rsetis_center_training_id'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'batch_name' => 'Batch Name',
            'rsetis_center_id' => 'Center Id',
            'rsetis_center_training_id' => 'Center Training Id',
        ];
    }

}
