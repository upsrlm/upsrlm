<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\base\Model;
use bc\modules\training\models\RsetisCenter;
use bc\modules\selection\models\base\GenralModel;

class RsetisCenterForm extends Model {

    /**
     * {@inheritdoc}
     */
    public $id;
    public $name;
    public $district_code;
    public $district_name;
    public $venue;
    public $gps;
    public $center_model;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $district_option = [];
    public $isNew;

    public function __construct($model = null) {
        $this->center_model = \Yii::createObject([
                    'class' => RsetisCenter::className()
        ]);
        $this->district_option = GenralModel::districtoption();

        $this->isNew = true;

        if ($model != '') {
            $this->isNew = false;
            $this->center_model = $model;
            $this->name = $this->center_model->name;
            $this->district_code = $this->center_model->district_code;
            $this->venue = $this->center_model->venue;
            $this->gps = $this->center_model->gps;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'district_code', 'venue'], 'required'],
            [['district_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name', 'district_name', 'gps'], 'string', 'max' => 255],
            [['venue'], 'string', 'max' => 500],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['name', 'district_code', 'venue'];
        $scenarios['update'] = ['name', 'district_code', 'venue'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Venue',
            'district_code' => 'District',
            'district_name' => 'District Name',
            'venue' => 'Venue Address',
            'gps' => 'Gps',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
