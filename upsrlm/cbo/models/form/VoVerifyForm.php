<?php

namespace cbo\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\master\MasterRole;
use cbo\models\CboVo;

/**
 * VOVerifyForm is the model behind the CboVo
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class VoVerifyForm extends \yii\base\Model {

    public $id;
    public $verify_vo_name_code_address;
    public $verify_vo_formation_date_no_shg;
    public $verify_vo_related_to_bank_account;
    public $verify_vo_total_amount;
    public $verify_vo_affiliated_shg_detail;
    public $verify_vo_members_detail;
    public $verify_vo_any_other_info;
    public $verification_status;
    public $verify_by;
    public $verify_datetime;
    public $option;
    public $vo_model;

    public function __construct($vo_model) {
        $this->vo_model = $vo_model;
        $this->option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'अपूर्ण'];
        if ($this->vo_model != null) {
            if ($this->vo_model->verify_vo_name_code_address)
                $this->verify_vo_name_code_address =$this->vo_model->verify_vo_name_code_address; 
            if ($this->vo_model->verify_vo_formation_date_no_shg)
                $this->verify_vo_formation_date_no_shg =$this->vo_model->verify_vo_formation_date_no_shg; 
            if ($this->vo_model->verify_vo_related_to_bank_account)
                $this->verify_vo_related_to_bank_account =$this->vo_model->verify_vo_related_to_bank_account; 
            if ($this->vo_model->verify_vo_total_amount)
                $this->verify_vo_total_amount =$this->vo_model->verify_vo_total_amount; 
            if ($this->vo_model->verify_vo_affiliated_shg_detail)
                $this->verify_vo_affiliated_shg_detail =$this->vo_model->verify_vo_affiliated_shg_detail; 
            if ($this->vo_model->verify_vo_members_detail)
                $this->verify_vo_members_detail =$this->vo_model->verify_vo_members_detail; 
            if ($this->vo_model->verify_vo_any_other_info)
                $this->verify_vo_any_other_info =$this->vo_model->verify_vo_any_other_info; 
            
        }
    }

    public function rules() {
        return [
            [['verify_vo_name_code_address', 'verify_vo_formation_date_no_shg', 'verify_vo_related_to_bank_account', 'verify_vo_total_amount', 'verify_vo_affiliated_shg_detail', 'verify_vo_members_detail', 'verify_vo_any_other_info', 'verification_status'], 'required', 'message' => 'Is required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'verify_vo_name_code_address' => 'VO के नाम, कोड, स्थान व पता ',
            'verify_vo_formation_date_no_shg' => 'VO गठन की तिथि एवं सम्बद्ध स्वयं सहायता समूह (एसएचजी) की संख्या ',
            'verify_vo_related_to_bank_account' => 'बैंक अकाउंट से जुड़े सभी विवरणा',
            'verify_vo_total_amount' => 'VO द्वारा योजना-वार अबतक प्राप्त कुल धनराशि एवं अद्यतन बैंक बैलेन्स',
            'verify_vo_affiliated_shg_detail' => 'VO के साथ सम्बद्ध सभी SHG के विवरण',
            'verify_vo_members_detail' => 'VO के सभी सदस्यों के नाम एवं पूर्ण विवरण',
            'verify_vo_any_other_info' => 'कोई अन्य सूचना ',
            'verification_status' => 'Verification Status',
            'verify_by' => 'Verify By',
            'verify_datetime' => 'Verify Datetime',
        ];
    }

}
