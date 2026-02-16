<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeBocwPayment;

/**
 * DbtBeneficiarySchemeBocwPaymentSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeBocwPayment`.
 */
class DbtBeneficiarySchemeBocwPaymentSearch extends DbtBeneficiarySchemeBocwPayment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'uplmis_gram_panchayat_code', 'scheme_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'created_at', 'updated_at', 'status'], 'integer'],
            [['uplmis_app_no', 'uplmis_lab_reg_no', 'uplmis_app_date', 'uplmis_payment_date', 'uplmis_scheme_name', 'uplmis_payment_amt', 'uplmis_Labour_name', 'uplmis_labour_name_eng', 'uplmis_father_husb_name', 'uplmis_father_husb_name_eng', 'uplmis_mother_name', 'uplmis_mother_name_eng', 'uplmis_dob', 'uplmis_temp_house_no', 'uplmis_village_name', 'uplmis_temp_pincode', 'uplmis_temp_post', 'uplmis_temp_thana', 'uplmis_temp_address', 'uplmis_vw_district_name', 'uplmis_vw_division_name', 'app_date', 'payment_date', 'dob', 'division_name', 'district_name', 'block_name', 'gram_panchayat_name'], 'safe'],
            [['payment_amt'], 'number'],
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
        $query = DbtBeneficiarySchemeBocwPayment::find();

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
            'uplmis_gram_panchayat_code' => $this->uplmis_gram_panchayat_code,
            'scheme_id' => $this->scheme_id,
            'app_date' => $this->app_date,
            'payment_date' => $this->payment_date,
            'dob' => $this->dob,
            'payment_amt' => $this->payment_amt,
            'division_code' => $this->division_code,
            'district_code' => $this->district_code,
            'block_code' => $this->block_code,
            'gram_panchayat_code' => $this->gram_panchayat_code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'uplmis_app_no', $this->uplmis_app_no])
            ->andFilterWhere(['like', 'uplmis_lab_reg_no', $this->uplmis_lab_reg_no])
            ->andFilterWhere(['like', 'uplmis_app_date', $this->uplmis_app_date])
            ->andFilterWhere(['like', 'uplmis_payment_date', $this->uplmis_payment_date])
            ->andFilterWhere(['like', 'uplmis_scheme_name', $this->uplmis_scheme_name])
            ->andFilterWhere(['like', 'uplmis_payment_amt', $this->uplmis_payment_amt])
            ->andFilterWhere(['like', 'uplmis_Labour_name', $this->uplmis_Labour_name])
            ->andFilterWhere(['like', 'uplmis_labour_name_eng', $this->uplmis_labour_name_eng])
            ->andFilterWhere(['like', 'uplmis_father_husb_name', $this->uplmis_father_husb_name])
            ->andFilterWhere(['like', 'uplmis_father_husb_name_eng', $this->uplmis_father_husb_name_eng])
            ->andFilterWhere(['like', 'uplmis_mother_name', $this->uplmis_mother_name])
            ->andFilterWhere(['like', 'uplmis_mother_name_eng', $this->uplmis_mother_name_eng])
            ->andFilterWhere(['like', 'uplmis_dob', $this->uplmis_dob])
            ->andFilterWhere(['like', 'uplmis_temp_house_no', $this->uplmis_temp_house_no])
            ->andFilterWhere(['like', 'uplmis_village_name', $this->uplmis_village_name])
            ->andFilterWhere(['like', 'uplmis_temp_pincode', $this->uplmis_temp_pincode])
            ->andFilterWhere(['like', 'uplmis_temp_post', $this->uplmis_temp_post])
            ->andFilterWhere(['like', 'uplmis_temp_thana', $this->uplmis_temp_thana])
            ->andFilterWhere(['like', 'uplmis_temp_address', $this->uplmis_temp_address])
            ->andFilterWhere(['like', 'uplmis_vw_district_name', $this->uplmis_vw_district_name])
            ->andFilterWhere(['like', 'uplmis_vw_division_name', $this->uplmis_vw_division_name])
            ->andFilterWhere(['like', 'division_name', $this->division_name])
            ->andFilterWhere(['like', 'district_name', $this->district_name])
            ->andFilterWhere(['like', 'block_name', $this->block_name])
            ->andFilterWhere(['like', 'gram_panchayat_name', $this->gram_panchayat_name]);

        return $dataProvider;
    }
}
