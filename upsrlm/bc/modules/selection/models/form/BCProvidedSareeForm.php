<?php

namespace bc\modules\selection\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcProvidedSaree;

/**
 * BCProvidedSareeForm is the model behind the BcHonorariumPayment
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BCProvidedSareeForm extends \yii\base\Model {

    public $id;
    public $bc_application_id;
    public $srlm_bc_selection_user_id;
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;
    public $saree1_provided;
    public $saree1_provided_date;
    public $saree1_provided_by;
    public $saree1_provided_datetime;
    public $saree1_acknowledge;
    public $saree1_acknowledge_datetime;
    public $saree2_provided;
    public $saree2_provided_date;
    public $saree2_provided_by;
    public $saree12_provided_datetime;
    public $saree2_acknowledge;
    public $saree2_acknowledge_datetime;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $bc_model;
    public $bc_saree_model;

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->bc_application_id = $this->bc_model->id;
        if ($this->bc_model->bcsaree != null) {
            $this->bc_saree_model = $this->bc_model->bcsaree;
            $this->saree1_acknowledge = $this->bc_saree_model->saree1_acknowledge;
            $this->saree2_acknowledge = $this->bc_saree_model->saree2_acknowledge;
            if ($this->bc_saree_model->saree1_provided) {
                $this->saree1_provided = $this->bc_saree_model->saree1_provided;
                if ($this->saree1_acknowledge == 1) {
                    $this->saree1_provided_date = $this->bc_saree_model->saree1_provided_date;
                }
            }
            if ($this->bc_saree_model->saree2_provided) {
                $this->saree2_provided = $this->bc_saree_model->saree2_provided;
                if ($this->saree2_acknowledge == 1) {
                    $this->saree2_provided_date = $this->bc_saree_model->saree2_provided_date;
                }
            }
        } else {
            $this->bc_saree_model = new BcProvidedSaree();
            $this->bc_saree_model->bc_application_id = $this->bc_model->id;
            $this->bc_saree_model->srlm_bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
            $this->bc_saree_model->district_code = $this->bc_model->district_code;
            $this->bc_saree_model->block_code = $this->bc_model->block_code;
            $this->bc_saree_model->gram_panchayat_code = $this->bc_model->gram_panchayat_code;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'saree1_provided', 'saree1_provided_by', 'saree1_acknowledge', 'saree2_provided', 'saree2_provided_by', 'saree2_acknowledge', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['saree1_provided_date', 'saree1_provided_datetime', 'saree1_acknowledge_datetime', 'saree2_provided_date', 'saree2_provided_datetime', 'saree2_acknowledge_datetime'], 'safe'],
            ['saree1_provided_date', 'required', 'when' => function ($model) {
                    return $model->saree1_provided == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#saree1_provided').val() == '1';
            }"],
            ['saree2_provided_date', 'required', 'when' => function ($model) {
                    return $model->saree2_provided == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#saree2_provided').val() == '1';
            }"],
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
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'saree1_provided' => 'Saree1 Provided',
            'saree1_provided_date' => 'Saree1 Provided Date',
            'saree1_provided_by' => 'Saree1 Provided By',
            'saree1_provided_datetime' => 'Saree1 Provided Datetime',
            'saree1_acknowledge' => 'Saree1 Acknowledge',
            'saree1_acknowledge_datetime' => 'Saree1 Acknowledge Datetime',
            'saree2_provided' => 'Saree2 Provided',
            'saree2_provided_date' => 'Saree2 Provided Date',
            'saree2_provided_by' => 'Saree2 Provided By',
            'saree2_provided_datetime' => 'Saree2 Provided Datetime',
            'saree2_acknowledge' => 'Saree2 Acknowledge',
            'saree2_acknowledge_datetime' => 'Saree2 Acknowledge Datetime',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {
        if ($this->saree1_provided) {
            $this->bc_saree_model->saree1_provided = $this->saree1_provided;
            $this->bc_saree_model->saree1_provided_date = $this->saree1_provided_date;
            if ($this->saree1_acknowledge == '2') {
                $this->bc_saree_model->saree1_acknowledge = null;
            }
            if ($this->bc_saree_model->saree1_provided_by == null)
                $this->bc_saree_model->saree1_provided_by = \Yii::$app->user->identity->id;
            if ($this->bc_saree_model->saree1_provided_datetime == null)
                $this->bc_saree_model->saree1_provided_datetime = new \yii\db\Expression('NOW()');
        } else {
            $this->bc_saree_model->saree1_provided = null;
            $this->bc_saree_model->saree1_provided_date = null;
            $this->bc_saree_model->saree1_provided_by = null;
            $this->bc_saree_model->saree1_provided_datetime = null;
        }
        if ($this->saree2_provided) {
            $this->bc_saree_model->saree2_provided = $this->saree2_provided;
            $this->bc_saree_model->saree2_provided_date = $this->saree2_provided_date;
            if ($this->saree2_acknowledge == '2') {
                $this->bc_saree_model->saree2_acknowledge = null;
            }
            if ($this->bc_saree_model->saree2_provided_by == null)
                $this->bc_saree_model->saree2_provided_by = \Yii::$app->user->identity->id;
            if ($this->bc_saree_model->saree2_provided_datetime == null)
                $this->bc_saree_model->saree2_provided_datetime = new \yii\db\Expression('NOW()');
        } else {
            $this->bc_saree_model->saree2_provided = null;
            $this->bc_saree_model->saree2_provided_date = null;
            $this->bc_saree_model->saree2_provided_by = null;
            $this->bc_saree_model->saree2_provided_datetime = null;
        }

        $this->bc_saree_model->save();
        return $this->bc_saree_model;
    }

}
