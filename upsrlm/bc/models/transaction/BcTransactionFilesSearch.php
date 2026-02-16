<?php

namespace bc\models\transaction;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\BcTransactionFiles;
use common\models\master\MasterRole;

/**
 * BcTransactionFilesSearch represents the model behind the search form of `bc\models\BcTransactionFiles`.
 */
class BcTransactionFilesSearch extends BcTransactionFiles {
    public $bank_option=[];
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'row_count', 'master_partner_bank_id', 'upload_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['file_name', 'upload_datetime'], 'safe'],
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
        $query = BcTransactionFiles::find();
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionFiles::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionFiles::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionFiles::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } else {
                $query->where('0=1');
            }
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 10 : $pagination],
            'sort' => ['defaultOrder' => ['upload_datetime' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTransactionFiles::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionFiles::getTableSchema()->fullName . '.row_count' => $this->row_count,
            BcTransactionFiles::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionFiles::getTableSchema()->fullName . '.upload_by' => $this->upload_by,
            BcTransactionFiles::getTableSchema()->fullName . '.upload_datetime' => $this->upload_datetime,
            BcTransactionFiles::getTableSchema()->fullName . '.created_by' => $this->created_by,
            BcTransactionFiles::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            BcTransactionFiles::getTableSchema()->fullName . '.created_at' => $this->created_at,
            BcTransactionFiles::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            BcTransactionFiles::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', BcTransactionFiles::getTableSchema()->fullName . '.file_name', $this->file_name]);

        return $dataProvider;
    }

}
