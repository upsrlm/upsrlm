<?php

namespace frontend\models\form;

use Yii;
use common\models\master\MasterGramPanchayat;
use yii\base\Model;

/**
 * AddGPForm is the model behind the MasterGramPanchayat
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class AddGPForm extends Model {

    /**
     * {@inheritdoc}
     */
    public $id;
    public $division_code;
    public $division_name;
    public $district_code;
    public $district_name;
    public $sub_district_code;
    public $sub_district_name;
    public $block_code;
    public $block_name;
    public $gram_panchayat_code;
    public $gram_panchayat_name;
    public $gp_covert_urban;
    public $bc_selection_application_receive;
    public $selected_application_id;
    public $bc_selection_sc_st_application_receive;
    public $bc_selection_obc_application_receive;
    public $bc_selection_general_application_receive;
    public $group_member;
    public $updated_by;
    public $updated_at;
    public $gp_model;
    public $district_option = [];
    public $block_option = [];

    /**
     * {@inheritdoc}
     */
    public function __construct($model = null) {
        $this->district_option = \common\models\base\GenralModel::district_options();
        $this->gp_model = \Yii::createObject([
                    'class' => MasterGramPanchayat::className()
        ]);
        if ($model != null) {
            $this->gp_model = $model;
            $this->district_code = $this->gp_model->district_code;
            $this->block_option = \common\models\base\GenralModel::blockopption($this);
            $this->block_code = $this->gp_model->block_code;
            $this->gram_panchayat_code = $this->gp_model->gram_panchayat_code;
            $this->gram_panchayat_name = $this->gp_model->gram_panchayat_name;
        }
    }

    public function rules() {
        return [
            [['district_code', 'block_code', 'gram_panchayat_code', 'gram_panchayat_name'], 'required'],
            [['division_code', 'district_code', 'sub_district_code', 'block_code', 'gram_panchayat_code', 'bc_selection_application_receive', 'selected_application_id', 'bc_selection_sc_st_application_receive', 'bc_selection_obc_application_receive', 'bc_selection_general_application_receive', 'group_member'], 'integer'],
            [['division_name', 'district_name', 'sub_district_name', 'block_name'], 'string', 'max' => 150],
            [['gram_panchayat_name'], 'string', 'max' => 132],
            [['gram_panchayat_code'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->gp_model->$attribute != $model->$attribute;
                }, 'targetClass' => MasterGramPanchayat::className(), 'message' => 'This Gram Panchayat Code has already been taken', 'targetAttribute' => 'gram_panchayat_code'],
            [['bc_selection_application_receive'], 'default', 'value' => 0],
            [['selected_application_id'], 'default', 'value' => 0],
            [['bc_selection_sc_st_application_receive'], 'default', 'value' => 0],
            [['bc_selection_obc_application_receive'], 'default', 'value' => 0],
            [['bc_selection_general_application_receive'], 'default', 'value' => 0],
            [['group_member'], 'default', 'value' => 0],
            [['gp_covert_urban'], 'default', 'value' => 0],
            [['updated_by', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'sub_district_code' => 'Sub District Code',
            'sub_district_name' => 'Sub District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'gp_covert_urban' => 'GP covert urban',
        ];
    }

    public function save() {
        $block_model = \common\models\master\MasterBlock::findOne(['block_code' => $this->block_code]);
        $this->gp_model->division_code = $block_model->division_code;
        $this->gp_model->division_name = $block_model->division_name;
        $this->gp_model->district_code = $this->district_code;
        $this->gp_model->district_name = $block_model->district_name;
        $this->gp_model->sub_district_code = $block_model->sub_district_code;
        $this->gp_model->sub_district_name = $block_model->sub_district_name;
        $this->gp_model->block_code = $this->block_code;
        $this->gp_model->block_name = $block_model->block_name;
        $this->gp_model->gram_panchayat_code = $this->gram_panchayat_code;
        $this->gp_model->gram_panchayat_name = trim($this->gram_panchayat_name);
        $this->gp_model->new = 1;
        if (!$this->validate()) {
            return false;
        }
        if (!$this->gp_model->validate()) {
            return false;
        }
        if ($this->gp_model->save()) {
            return $this->gp_model;
        }
    }

}
