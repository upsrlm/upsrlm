<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\BcTrackingFeedback;
use common\models\master\MasterRole;
/**
 * BcTrackingFeedbackSearch represents the model behind the search form of `bc\modules\selection\models\BcTrackingFeedback`.
 */
class BcTrackingFeedbackSearch extends BcTrackingFeedback {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'user_id', 'ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5', 'ques_6', 'ques_7', 'ques_8', 'ques_9', 'ques_10', 'ques_11', 'ques_12', 'ques_13', 'ques_14', 'ques_15', 'ques_16', 'ques_17', 'ques_18', 'ques_19', 'ques_20', 'handheld_device', 'handheld_device_ques_1', 'handheld_device_ques_2', 'handheld_device_ques_3', 'handheld_device_ques_4', 'handheld_device_ques_5', 'fraud_transaction', 'fraud_transaction_ques_1', 'fraud_transaction_ques_2', 'fraud_transaction_ques_3', 'fraud_transaction_ques_4', 'problems_with_bank', 'problems_with_bank_ques_1', 'problems_with_bank_ques_2', 'bc_commissions_payment', 'bc_commissions_payment_ques_1', 'bc_commissions_payment_ques_2', 'bc_commissions_payment_ques_3', 'section', 'feedback_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['feedback_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = BcTrackingFeedback::find();

        $query->joinWith(['bc']);
        $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => 3]);
        if ($user_model == NULL) {
//            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([BcTrackingFeedback::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([BcTrackingFeedback::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([BcTrackingFeedback::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([BcTrackingFeedback::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTrackingFeedback::getTableSchema()->fullName . '.id' => $this->id,
            BcTrackingFeedback::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTrackingFeedback::getTableSchema()->fullName . '.srlm_bc_selection_user_id' => $this->srlm_bc_selection_user_id,
            BcTrackingFeedback::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTrackingFeedback::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTrackingFeedback::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTrackingFeedback::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTrackingFeedback::getTableSchema()->fullName . '.user_id' => $this->user_id,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_1' => $this->ques_1,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_2' => $this->ques_2,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_3' => $this->ques_3,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_4' => $this->ques_4,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_5' => $this->ques_5,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_6' => $this->ques_6,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_7' => $this->ques_7,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_8' => $this->ques_8,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_9' => $this->ques_9,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_10' => $this->ques_10,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_11' => $this->ques_11,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_12' => $this->ques_12,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_13' => $this->ques_13,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_14' => $this->ques_14,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_15' => $this->ques_15,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_16' => $this->ques_16,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_17' => $this->ques_17,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_18' => $this->ques_18,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_19' => $this->ques_19,
            BcTrackingFeedback::getTableSchema()->fullName . '.ques_20' => $this->ques_20,
            BcTrackingFeedback::getTableSchema()->fullName . '.handheld_device' => $this->handheld_device,
            BcTrackingFeedback::getTableSchema()->fullName . '.handheld_device_ques_1' => $this->handheld_device_ques_1,
            BcTrackingFeedback::getTableSchema()->fullName . '.handheld_device_ques_2' => $this->handheld_device_ques_2,
            BcTrackingFeedback::getTableSchema()->fullName . '.handheld_device_ques_3' => $this->handheld_device_ques_3,
            BcTrackingFeedback::getTableSchema()->fullName . '.handheld_device_ques_4' => $this->handheld_device_ques_4,
            BcTrackingFeedback::getTableSchema()->fullName . '.handheld_device_ques_5' => $this->handheld_device_ques_5,
            BcTrackingFeedback::getTableSchema()->fullName . '.fraud_transaction' => $this->fraud_transaction,
            BcTrackingFeedback::getTableSchema()->fullName . '.fraud_transaction_ques_1' => $this->fraud_transaction_ques_1,
            BcTrackingFeedback::getTableSchema()->fullName . '.fraud_transaction_ques_2' => $this->fraud_transaction_ques_2,
            BcTrackingFeedback::getTableSchema()->fullName . '.fraud_transaction_ques_3' => $this->fraud_transaction_ques_3,
            BcTrackingFeedback::getTableSchema()->fullName . '.fraud_transaction_ques_4' => $this->fraud_transaction_ques_4,
            BcTrackingFeedback::getTableSchema()->fullName . '.problems_with_bank' => $this->problems_with_bank,
            BcTrackingFeedback::getTableSchema()->fullName . '.problems_with_bank_ques_1' => $this->problems_with_bank_ques_1,
            BcTrackingFeedback::getTableSchema()->fullName . '.problems_with_bank_ques_2' => $this->problems_with_bank_ques_2,
            BcTrackingFeedback::getTableSchema()->fullName . '.bc_commissions_payment' => $this->bc_commissions_payment,
            BcTrackingFeedback::getTableSchema()->fullName . '.bc_commissions_payment_ques_1' => $this->bc_commissions_payment_ques_1,
            BcTrackingFeedback::getTableSchema()->fullName . '.bc_commissions_payment_ques_2' => $this->bc_commissions_payment_ques_2,
            BcTrackingFeedback::getTableSchema()->fullName . '.bc_commissions_payment_ques_3' => $this->bc_commissions_payment_ques_3,
            BcTrackingFeedback::getTableSchema()->fullName . '.section' => $this->section,
            BcTrackingFeedback::getTableSchema()->fullName . '.feedback_by' => $this->feedback_by,
            BcTrackingFeedback::getTableSchema()->fullName . '.feedback_date' => $this->feedback_date,
            BcTrackingFeedback::getTableSchema()->fullName . '.created_by' => $this->created_by,
            BcTrackingFeedback::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            BcTrackingFeedback::getTableSchema()->fullName . '.created_at' => $this->created_at,
            BcTrackingFeedback::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            BcTrackingFeedback::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        return $dataProvider;
    }
}
