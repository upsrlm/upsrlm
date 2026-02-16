<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\BcFiles;
use common\models\master\MasterRole;

/**
 * BcFilesSearch represents the model behind the search form of `bc\modules\selection\models\BcFiles`.
 */
class BcFilesSearch extends BcFiles {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'form', 'row_count', 'master_partner_bank_id', 'upload_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
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
        $query = BcFiles::find();

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere(['bc_files.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere(['bc_files.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere(['bc_files.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere(['bc_files.created_by' => $user_model->id]);
            } else {
                $query->where('0=1');
            }
        }

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
            'bc_files.id' => $this->id,
            'bc_files.form' => $this->form,
            'bc_files.row_count' => $this->row_count,
            'bc_files.master_partner_bank_id' => $this->master_partner_bank_id,
            'bc_files.upload_by' => $this->upload_by,
            'bc_files.upload_datetime' => $this->upload_datetime,
            'bc_files.created_by' => $this->created_by,
            'bc_files.updated_by' => $this->updated_by,
            'bc_files.created_at' => $this->created_at,
            'bc_files.updated_at' => $this->updated_at,
            'bc_files.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'bc_files.file_name', $this->file_name]);

        return $dataProvider;
    }
}
