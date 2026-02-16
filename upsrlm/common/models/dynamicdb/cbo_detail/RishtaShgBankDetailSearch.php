<?php

namespace common\models\dynamicdb\cbo_detail;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\RishtaShgBankDetail;

/**
 * RishtaShgBankDetailSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\RishtaShgBankDetail`.
 */
class RishtaShgBankDetailSearch extends RishtaShgBankDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cbo_shg_id', 'bank_id', 'balance_as_on_date', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['bank_account_no_of_the_shg', 'name_of_bank', 'branch', 'branch_code_or_ifsc', 'date_of_opening_the_bank_account', 'bank_balance_date', 'passbook_photo'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = RishtaShgBankDetail::find();

        // add conditions that should always apply here

         $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 20 : $pagination],
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
            'cbo_shg_id' => $this->cbo_shg_id,
            'bank_id' => $this->bank_id,
            'date_of_opening_the_bank_account' => $this->date_of_opening_the_bank_account,
            'balance_as_on_date' => $this->balance_as_on_date,
            'bank_balance_date' => $this->bank_balance_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'bank_account_no_of_the_shg', $this->bank_account_no_of_the_shg])
            ->andFilterWhere(['like', 'name_of_bank', $this->name_of_bank])
            ->andFilterWhere(['like', 'branch', $this->branch])
            ->andFilterWhere(['like', 'branch_code_or_ifsc', $this->branch_code_or_ifsc])
            ->andFilterWhere(['like', 'passbook_photo', $this->passbook_photo]);

        return $dataProvider;
    }
}
