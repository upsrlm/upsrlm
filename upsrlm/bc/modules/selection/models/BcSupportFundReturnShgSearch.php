<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\BcSupportFundReturnShg;
use common\models\master\MasterRole;

/**
 * BcSupportFundReturnShgSearch represents the model behind the search form of `bc\modules\selection\models\BcSupportFundReturnShg`.
 */
class BcSupportFundReturnShgSearch extends BcSupportFundReturnShg {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'srlm_bc_selection_user_id', 'user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'shg_has_received_refund', 'time_left_full_loan_repay', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['retrun_amount', 'due_amount', 'due_after_installment'], 'number'],
            [['date'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $columns = null, $select = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = BcSupportFundReturnShg::find();
        $query->joinWith(['bc']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([BcSupportFundReturnShg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $query->andWhere([BcSupportFundReturnShg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([BcSupportFundReturnShg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([BcSupportFundReturnShg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([BcSupportFundReturnShg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([BcSupportFundReturnShg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([BcSupportFundReturnShg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([BcSupportFundReturnShg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([BcSupportFundReturnShg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([BcSupportFundReturnShg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
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
                BcSupportFundReturnShg::getTableSchema()->fullName . '.id' => $this->id,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.srlm_bc_selection_user_id' => $this->srlm_bc_selection_user_id,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.user_id' => $this->user_id,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.district_code' => $this->district_code,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.block_code' => $this->block_code,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.retrun_amount' => $this->retrun_amount,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.due_amount' => $this->due_amount,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.due_after_installment' => $this->due_after_installment,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.shg_has_received_refund' => $this->shg_has_received_refund,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.time_left_full_loan_repay' => $this->time_left_full_loan_repay,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.date' => $this->date,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.created_by' => $this->created_by,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.created_at' => $this->created_at,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
                BcSupportFundReturnShg::getTableSchema()->fullName . '.status' => $this->status,
            ]);

            return $dataProvider;
        }
    }

}
