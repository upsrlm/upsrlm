<?php

namespace bc\modules\corona\models\form;

use Yii;
use yii\base\Model;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\corona\models\BcCoronaFeedback;

class CoronaFeedbackForm extends Model {

    public $id;
    public $bc_application_id;
    public $srlm_bc_selection_user_id;
    public $bc_name;
    public $division_code;
    public $division_name;
    public $district_code;
    public $district_name;
    public $block_code;
    public $block_name;
    public $gram_panchayat_code;
    public $gram_panchayat_name;
    public $village_code;
    public $village_name;
    public $hamlet;
    public $que1a;
    public $que2a;
    public $que3a;
    public $que4a;
    public $gps;
    public $gps_accuracy;
    public $created_at;
    public $updated_at;
    public $status;
    public $bc_user_model;
    public $feedback_model;

    public function __construct($model) {
        $this->bc_user_model = $model;
        if ($this->bc_user_model != null) {
            if (isset($this->bc_user_model->bcsapplication)) {
                $this->bc_application_id = $this->bc_user_model->bcsapplication->id;
                $this->srlm_bc_selection_user_id = $this->bc_user_model->bcsapplication->srlm_bc_selection_user_id;
                $this->bc_name = $this->bc_user_model->bcsapplication->name;
                $this->division_code = $this->bc_user_model->bcsapplication->division_code;
                $this->division_name = $this->bc_user_model->bcsapplication->division_name;
                $this->district_code = $this->bc_user_model->bcsapplication->district_code;
                $this->district_name = $this->bc_user_model->bcsapplication->district_name;
                $this->block_code = $this->bc_user_model->bcsapplication->block_code;
                $this->block_name = $this->bc_user_model->bcsapplication->block_name;
                $this->gram_panchayat_code = $this->bc_user_model->bcsapplication->gram_panchayat_code;
                $this->gram_panchayat_name = $this->bc_user_model->bcsapplication->gram_panchayat_name;
                $this->village_code = $this->bc_user_model->bcsapplication->village_code;
                $this->village_name = $this->bc_user_model->bcsapplication->village_name;
                $this->hamlet = $this->bc_user_model->bcsapplication->hamlet;
            }
        }
        
        
        $this->feedback_model = BcCoronaFeedback::findOne(['srlm_bc_selection_user_id' => $this->bc_user_model->id]);
        if (empty($this->feedback_model)) {
            $this->feedback_model = new BcCoronaFeedback();
        }
        $this->feedback_model->bc_application_id = $this->bc_application_id;
        $this->feedback_model->srlm_bc_selection_user_id = $this->srlm_bc_selection_user_id;
        $this->feedback_model->bc_name = $this->bc_name;
        $this->feedback_model->division_code = $this->division_code;
        $this->feedback_model->division_name = $this->division_name;
        $this->feedback_model->district_code = $this->district_code;
        $this->feedback_model->district_name = $this->district_name;
        $this->feedback_model->block_code = $this->block_code;
        $this->feedback_model->block_name = $this->block_name;
        $this->feedback_model->gram_panchayat_code = $this->gram_panchayat_code;
        $this->feedback_model->gram_panchayat_name = $this->gram_panchayat_name;
        $this->feedback_model->village_code = $this->village_code;
        $this->feedback_model->village_name = $this->village_name;
        $this->feedback_model->hamlet = $this->hamlet;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'srlm_bc_selection_user_id', 'que1a', 'que3a', 'que4a'], 'required'],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'que1a', 'que2a', 'que3a', 'que4a', 'created_at', 'updated_at', 'status'], 'integer'],
            [['bc_name'], 'string', 'max' => 255],
            [['bc_name'], 'trim'],
            [['division_name'], 'string', 'max' => 60],
            [['district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'hamlet'], 'string', 'max' => 100],
            [['gps'], 'safe'],
            [['gps_accuracy'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Application ID',
            'srlm_bc_selection_user_id' => 'Srlm Bc Selection User ID',
            'bc_name' => 'Bc Name',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'village_code' => 'Village Code',
            'village_name' => 'Village Name',
            'hamlet' => 'Hamlet',
            'que1a' => 'Que1a',
            'que2a' => 'Que2a',
            'que3a' => 'Que3a',
            'que4a' => 'Que4a',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getBcapplication() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }

    public function getBcuser() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcSelectionUser::className(), ['id' => 'srlm_bc_selection_user_id']);
    }

    public function getDivision() {
        return $this->hasOne(\bc\models\master\MasterDivision::className(), ['division_code' => 'division_code']);
    }

    public function getDistrict() {
        return $this->hasOne(\bc\models\master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(\bc\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getVillage() {
        return $this->hasOne(\bc\models\master\MasterVillage::className(), ['village_code' => 'village_code']);
    }

    public function getGp() {
        return $this->hasOne(\bc\models\master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getQ1a() {
        return $this->hasOne(master\CoronaFeedbackMasterQues1a::className(), ['id' => 'que1a']);
    }

    public function getQ2a() {
        return $this->hasOne(master\CoronaFeedbackMasterQues2a::className(), ['id' => 'que2a']);
    }

    public function getQ3a() {
        return $this->hasOne(master\CoronaFeedbackMasterQues3a::className(), ['id' => 'que3a']);
    }

    public function getQ4a() {
        return $this->hasOne(master\CoronaFeedbackMasterQues4a::className(), ['id' => 'que4a']);
    }

}
