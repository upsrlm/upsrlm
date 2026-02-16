<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\GramPanchayatDetailUltraPoorHistory;

/**
 * GramPanchayatDetailUltraPoorHistorySearch represents the model behind the search form of `common\models\master\GramPanchayatDetailUltraPoorHistory`.
 */
class GramPanchayatDetailUltraPoorHistorySearch extends GramPanchayatDetailUltraPoorHistory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gram_panchayat_code', 'block_code', 'district_code', 'gram_pardhan', 'gram_pardhan_login', 'gram_pardhan_add_no_user', 'no_of_user', 'no_of_user_login', 'hhs_enumerated', 'hhs_enumerated_old', 'hhs_enumerated_mopup', 'gram_pardhan_return_hhs', 'gram_pardhan_verify_hhs', 'gram_pardhan_remain_verification', 'hhs_in_save_mode', 'digital_hhs_attempt', 'digital_hhs_remain_attempt', 'digital_hhs_verified', 'digital_hhs_unverified', 'digital_hhs_has_smartphone', 'digital_hhs_wrong_mobile_no', 'digital_hhs_wrong_mobile_no_does_not_exist', 'gp_covert_urban', 'updated_at', 'status'], 'integer'],
            [['date', 'gram_panchayat_name'], 'safe'],
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
        $query = GramPanchayatDetailUltraPoorHistory::find();

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
            'gram_panchayat_code' => $this->gram_panchayat_code,
            'block_code' => $this->block_code,
            'district_code' => $this->district_code,
            'date' => $this->date,
            'gram_pardhan' => $this->gram_pardhan,
            'gram_pardhan_login' => $this->gram_pardhan_login,
            'gram_pardhan_add_no_user' => $this->gram_pardhan_add_no_user,
            'no_of_user' => $this->no_of_user,
            'no_of_user_login' => $this->no_of_user_login,
            'hhs_enumerated' => $this->hhs_enumerated,
            'hhs_enumerated_old' => $this->hhs_enumerated_old,
            'hhs_enumerated_mopup' => $this->hhs_enumerated_mopup,
            'gram_pardhan_return_hhs' => $this->gram_pardhan_return_hhs,
            'gram_pardhan_verify_hhs' => $this->gram_pardhan_verify_hhs,
            'gram_pardhan_remain_verification' => $this->gram_pardhan_remain_verification,
            'hhs_in_save_mode' => $this->hhs_in_save_mode,
            'digital_hhs_attempt' => $this->digital_hhs_attempt,
            'digital_hhs_remain_attempt' => $this->digital_hhs_remain_attempt,
            'digital_hhs_verified' => $this->digital_hhs_verified,
            'digital_hhs_unverified' => $this->digital_hhs_unverified,
            'digital_hhs_has_smartphone' => $this->digital_hhs_has_smartphone,
            'digital_hhs_wrong_mobile_no' => $this->digital_hhs_wrong_mobile_no,
            'digital_hhs_wrong_mobile_no_does_not_exist' => $this->digital_hhs_wrong_mobile_no_does_not_exist,
            'gp_covert_urban' => $this->gp_covert_urban,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'gram_panchayat_name', $this->gram_panchayat_name]);

        return $dataProvider;
    }
}
