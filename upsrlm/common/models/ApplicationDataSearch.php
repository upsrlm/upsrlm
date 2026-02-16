<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ApplicationData;

/**
 * ApplicationDataSearch represents the model behind the search form of `common\models\ApplicationData`.
 */
class ApplicationDataSearch extends ApplicationData
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bc_identify', 'bc_preselect', 'bc_trained', 'bc_trained_and_certified', 'bc_onboarded', 'bc_operational', 'clf_formed', 'clf_e_registered', 'vo_formed', 'vo_e_registered', 'vo_app_operated', 'shg_formed', 'shg_e_registered', 'shg_members', 'ga_total_users', 'ga_total_pageviews', 'created_at', 'updated_at', 'status'], 'integer'],
            [['clf_app_operated', 'clf_start_up_received', 'clf_cif_received', 'clf_isf_received', 'clf_infra_fund_received', 'clf_others_fund_received', 'clf_fund_utilization_efficiency', 'clf_stagnant_fund', 'vo_start_up_received', 'vo_vrf_received', 'vo_lf_received', 'vo_patb_received', 'vo_agey_received', 'vo_isf_received', 'shg_start_up_received', 'shg_cif_received', 'shg_repeated_bank_loan', 'shg_fund_3_received', 'shg_fund_4_received', 'shg_fund_utilization_efficiency', 'shg_stagnant_fund'], 'number'],
            [['ga_last_updated_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = ApplicationData::find();

        // add conditions that should always apply here

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
            'id' => $this->id,
            'bc_identify' => $this->bc_identify,
            'bc_preselect' => $this->bc_preselect,
            'bc_trained' => $this->bc_trained,
            'bc_trained_and_certified' => $this->bc_trained_and_certified,
            'bc_onboarded' => $this->bc_onboarded,
            'bc_operational' => $this->bc_operational,
            'clf_formed' => $this->clf_formed,
            'clf_e_registered' => $this->clf_e_registered,
            'clf_app_operated' => $this->clf_app_operated,
            'clf_start_up_received' => $this->clf_start_up_received,
            'clf_cif_received' => $this->clf_cif_received,
            'clf_isf_received' => $this->clf_isf_received,
            'clf_infra_fund_received' => $this->clf_infra_fund_received,
            'clf_others_fund_received' => $this->clf_others_fund_received,
            'clf_fund_utilization_efficiency' => $this->clf_fund_utilization_efficiency,
            'clf_stagnant_fund' => $this->clf_stagnant_fund,
            'vo_formed' => $this->vo_formed,
            'vo_e_registered' => $this->vo_e_registered,
            'vo_app_operated' => $this->vo_app_operated,
            'vo_start_up_received' => $this->vo_start_up_received,
            'vo_vrf_received' => $this->vo_vrf_received,
            'vo_lf_received' => $this->vo_lf_received,
            'vo_patb_received' => $this->vo_patb_received,
            'vo_agey_received' => $this->vo_agey_received,
            'vo_isf_received' => $this->vo_isf_received,
            'shg_formed' => $this->shg_formed,
            'shg_e_registered' => $this->shg_e_registered,
            'shg_members' => $this->shg_members,
            'shg_start_up_received' => $this->shg_start_up_received,
            'shg_cif_received' => $this->shg_cif_received,
            'shg_repeated_bank_loan' => $this->shg_repeated_bank_loan,
            'shg_fund_3_received' => $this->shg_fund_3_received,
            'shg_fund_4_received' => $this->shg_fund_4_received,
            'shg_fund_utilization_efficiency' => $this->shg_fund_utilization_efficiency,
            'shg_stagnant_fund' => $this->shg_stagnant_fund,
            'ga_total_users' => $this->ga_total_users,
            'ga_total_pageviews' => $this->ga_total_pageviews,
            'ga_last_updated_on' => $this->ga_last_updated_on,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
