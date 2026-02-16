<?php

namespace common\models\dynamicdb\cbo_detail;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\RishtaRolePermission;

/**
 * RishtaRolePermissionSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\RishtaRolePermission`.
 */
class RishtaRolePermissionSearch extends RishtaRolePermission {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'role', 'permission', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
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
        $query = RishtaRolePermission::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['role' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            RishtaRolePermission::getTableSchema()->fullName . '.id' => $this->id,
            RishtaRolePermission::getTableSchema()->fullName . '.role' => $this->role,
            RishtaRolePermission::getTableSchema()->fullName . '.permission' => $this->permission,
            RishtaRolePermission::getTableSchema()->fullName . '.created_by' => $this->created_by,
            RishtaRolePermission::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            RishtaRolePermission::getTableSchema()->fullName . '.created_at' => $this->created_at,
            RishtaRolePermission::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            RishtaRolePermission::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        return $dataProvider;
    }

}
