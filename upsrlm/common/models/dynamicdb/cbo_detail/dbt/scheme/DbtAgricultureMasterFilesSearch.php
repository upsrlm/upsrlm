<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtAgricultureMasterFiles;
use common\models\master\MasterRole;

/**
 * DbtAgricultureMasterFilesSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\dbt\scheme\DbtAgricultureMasterFiles`.
 */
class DbtAgricultureMasterFilesSearch extends DbtAgricultureMasterFiles {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'upload_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['note', 'file_name', 'upload_datetime'], 'safe'],
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
        $query = DbtAgricultureMasterFiles::find();

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_AGRICULTURE_ADMIN])) {
                
            } else {
                $query->where('0=1');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]],
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
            'upload_by' => $this->upload_by,
            'upload_datetime' => $this->upload_datetime,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note])
                ->andFilterWhere(['like', 'file_name', $this->file_name]);

        return $dataProvider;
    }
}
