<?php

namespace backend\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use common\models\base\GenralModel;
use common\models\RelationUserDistrict;
use common\models\User;
use common\models\master\MasterRole;

/**
 * GPConvertUrbanForm is the model behind the User
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class GPConvertUrbanForm extends Model {

    public $id;
    public $gp_covert_urban;
    public $gp1_model;
    public $gp2_model;

    public function __construct($gp_model) {
        $this->gp1_model = $gp_model;
        if ($this->gp1_model->gp_covert_urban) {
            $this->gp_covert_urban = $this->gp1_model->gp_covert_urban;
        }
        $this->gp2_model = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $this->gp1_model->gram_panchayat_code]);
//        print_r($this->gp2_model);
//        exit;
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['gp_covert_urban'], 'required', 'message' => 'Is requred'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'gp_covert_urban' => 'GP covert urban',
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }
        $this->gp1_model->gp_covert_urban = $this->gp_covert_urban;
        $this->gp2_model->gp_covert_urban = $this->gp_covert_urban;
        if ($this->gp1_model->save() and $this->gp2_model->save()) {
            return $this;
        }
        return $this;
    }

}
