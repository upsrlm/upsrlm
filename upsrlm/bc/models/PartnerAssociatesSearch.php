<?php

namespace bc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\PartnerAssociates;
use common\models\master\MasterRole;

/**
 * PartnerAssociatesSearch represents the model behind the search form of `bc\models\PartnerAssociates`.
 */
class PartnerAssociatesSearch extends PartnerAssociates {

    public $district_option = [];
    public $block_option = [];
    public $district_code;
    public $block_code;
    public $bank_option = [];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'master_partner_bank_id', 'gender', 'age', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['name_of_the_field_officer', 'date_of_birth', 'photo_profile', 'designation', 'mobile_no', 'alternate_mobile_no', 'whatsapp_no', 'email_id', 'photo_aadhaar_front', 'photo_aadhaar_back', 'company_letter', 'name_of_supervisor', 'designation_of_supervisor', 'mobile_no_of_supervisor', 'bank_name', 'bank_branch', 'bank_ifsc_code', 'bank_account_number'], 'safe'],
            [['district_code', 'block_code'], 'safe']
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
        $query = PartnerAssociates::find();
        $query->andWhere([PartnerAssociates::getTableSchema()->fullName . '.status' => 1]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([PartnerAssociates::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
                $query->joinWith(['disblock']);
                $query->andWhere(['partner_associates_block.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->distinct('partner_associates_block.district_code');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([PartnerAssociates::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
                $query->joinWith(['disblock']);
                $query->andWhere(['partner_associates_block.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->distinct('partner_associates_block.district_code');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->joinWith(['disblock']);
                $query->andWhere(['partner_associates_block.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->distinct('partner_associates_block.district_code');
            } else {
                $query->where('0=1');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            PartnerAssociates::getTableSchema()->fullName . '.id' => $this->id,
            PartnerAssociates::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            PartnerAssociates::getTableSchema()->fullName . '.gender' => $this->gender,
            PartnerAssociates::getTableSchema()->fullName . '.date_of_birth' => $this->date_of_birth,
            PartnerAssociates::getTableSchema()->fullName . '.age' => $this->age,
            PartnerAssociates::getTableSchema()->fullName . '.created_by' => $this->created_by,
            PartnerAssociates::getTableSchema()->fullName . '.created_at' => $this->created_at,
            PartnerAssociates::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            PartnerAssociates::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            PartnerAssociates::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.name_of_the_field_officer', $this->name_of_the_field_officer])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.photo_profile', $this->photo_profile])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.designation', $this->designation])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.alternate_mobile_no', $this->alternate_mobile_no])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.whatsapp_no', $this->whatsapp_no])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.email_id', $this->email_id])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.photo_aadhaar_front', $this->photo_aadhaar_front])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.photo_aadhaar_back', $this->photo_aadhaar_back])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.company_letter', $this->company_letter])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.name_of_supervisor', $this->name_of_supervisor])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.designation_of_supervisor', $this->designation_of_supervisor])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.mobile_no_of_supervisor', $this->mobile_no_of_supervisor])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.bank_name', $this->bank_name])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.bank_branch', $this->bank_branch])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.bank_ifsc_code', $this->bank_ifsc_code])
                ->andFilterWhere(['like', PartnerAssociates::getTableSchema()->fullName . '.bank_account_number', $this->bank_account_number]);

        return $dataProvider;
    }

}
