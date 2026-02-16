<?php

namespace cbo\models\form;

use cbo\models\CboClf;
use cbo\models\CboVo;
use cbo\models\CboClfVoFunds;
use Yii;

/**
 * Clfvofundsform is the model behind the CboClfVoFunds
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Clfvofundsform extends \yii\base\Model {

    public $id;
    public $cbo_clf_id;
    public $name_of_vo;
    public $cbo_vo_id;
    public $date_fund_loan_provision;
    public $fund_type;
    public $loan_funds_amount;
    public $refund_amount;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $fundstype_option = [];
    public $cbo_vo_option = [];
    public $clf_model;
    public $vo_model;
    public $funds_model;

    public function __construct($clf_model, $vo_model, $funds_model = null) {
        $this->clf_model = $clf_model;
        $this->vo_model = $vo_model;
        $this->fundstype_option = \common\models\base\GenralModel::cbo_funds_type_option('vo');
        $this->funds_model = new CboClfVoFunds();
        $this->cbo_clf_id = $this->clf_model->id;
        $this->cbo_vo_id = $this->vo_model->id;
        $this->name_of_vo = $this->vo_model->name_of_vo;
        if ($funds_model != null) {
            $this->funds_model = $funds_model;
            $this->cbo_clf_id = $this->funds_model->cbo_clf_id;
            $this->cbo_vo_id = $this->funds_model->cbo_vo_id;
            $this->fund_type = $this->funds_model->fund_type;
            $this->date_fund_loan_provision = $this->funds_model->date_fund_loan_provision != null ? \Yii::$app->formatter->asDatetime($this->funds_model->date_fund_loan_provision, "php:d-m-Y") : "";
            $this->loan_funds_amount = $this->funds_model->loan_funds_amount;
            $this->refund_amount = $this->funds_model->refund_amount;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_clf_id', 'cbo_vo_id'], 'required'],
            [['fund_type', 'date_fund_loan_provision', 'loan_funds_amount'], 'required'],
            [['cbo_clf_id', 'cbo_vo_id', 'fund_type', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['date_fund_loan_provision'], 'safe'],
            [['loan_funds_amount', 'refund_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_clf_id' => 'CLF',
            'cbo_vo_id' => 'VO',
            'date_fund_loan_provision' => 'अगर उन्हें कोई फंड/ ऋण प्रदान की गई तो वह तिथि दर्ज करें',
            'fund_type' => 'किस थीमेटिक स्कीम के तहत ऋण/ फण्ड दी गयी',
            'loan_funds_amount' => 'कितनी ऋण/ फण्ड दी गयी',
            'refund_amount' => 'वापसी राशि',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {

        try {
            $this->funds_model->cbo_clf_id = $this->cbo_clf_id;
            $this->funds_model->cbo_vo_id = $this->cbo_vo_id;
            $this->funds_model->date_fund_loan_provision = $this->date_fund_loan_provision;
            $this->funds_model->fund_type = $this->fund_type;
            $this->funds_model->loan_funds_amount = $this->loan_funds_amount;
            $this->funds_model->refund_amount = $this->refund_amount;

            if ($this->funds_model->save()) {
                
            }

            return $this;
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

}
