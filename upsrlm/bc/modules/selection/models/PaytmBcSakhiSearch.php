<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\PaytmBcSakhi;

/**
 * PaytmBcSakhiSearch represents the model behind the search form of `bc\modules\selection\models\PaytmBcSakhi`.
 */
class PaytmBcSakhiSearch extends PaytmBcSakhi {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'sr_no', 'district_code', 'block_code', 'gram_panchayat_code', 'upsrlm_onboarding_status', 'upsrlm_handheld_machine_status', 'upsrlm_bc_handheld_machine_recived', 'upsrlm_pan_card_status', 'upsrlm_bc_shg_funds_status', 'upsrlm_bc_support_funds_received', 'upsrlm_master_partner_bank_id', 'upsrlm_training_status', 'upsrlm_bc_operational'], 'integer'],
            [['application_no', 'name', 'otp_mobile_no', 'mobile_number', 'onboarding_status', 'bmd_1650', 'sarthi_device_25000', 'both_devices', 'device_not_purchased', 'bc_operational', 'district', 'block', 'gp', 'bc_shg_payment_status', 'acknowledge_support_funds_received', 'bankidofbc', 'upsrlm_bankidbc'], 'safe'],
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
        $query = PaytmBcSakhi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['district' => SORT_ASC]],
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
            'sr_no' => $this->sr_no,
            'district_code' => $this->district_code,
            'block_code' => $this->block_code,
            'gram_panchayat_code' => $this->gram_panchayat_code,
            'upsrlm_onboarding_status' => $this->upsrlm_onboarding_status,
            'upsrlm_handheld_machine_status' => $this->upsrlm_handheld_machine_status,
            'upsrlm_bc_handheld_machine_recived' => $this->upsrlm_bc_handheld_machine_recived,
            'upsrlm_pan_card_status' => $this->upsrlm_pan_card_status,
            'upsrlm_bc_shg_funds_status' => $this->upsrlm_bc_shg_funds_status,
            'upsrlm_bc_support_funds_received' => $this->upsrlm_bc_support_funds_received,
            'upsrlm_master_partner_bank_id' => $this->upsrlm_master_partner_bank_id,
            'upsrlm_training_status' => $this->upsrlm_training_status,
            'upsrlm_bc_operational' => $this->upsrlm_bc_operational,
        ]);

        $query->andFilterWhere(['like', 'application_no', $this->application_no])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'otp_mobile_no', $this->otp_mobile_no])
                ->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
                ->andFilterWhere(['like', 'onboarding_status', $this->onboarding_status])
                ->andFilterWhere(['like', 'bmd_1650', $this->bmd_1650])
                ->andFilterWhere(['like', 'sarthi_device_25000', $this->sarthi_device_25000])
                ->andFilterWhere(['like', 'both_devices', $this->both_devices])
                ->andFilterWhere(['like', 'device_not_purchased', $this->device_not_purchased])
                ->andFilterWhere(['like', 'bc_operational', $this->bc_operational])
                ->andFilterWhere(['like', 'district', $this->district])
                ->andFilterWhere(['like', 'block', $this->block])
                ->andFilterWhere(['like', 'gp', $this->gp])
                ->andFilterWhere(['like', 'bc_shg_payment_status', $this->bc_shg_payment_status])
                ->andFilterWhere(['like', 'acknowledge_support_funds_received', $this->acknowledge_support_funds_received])
                ->andFilterWhere(['like', 'bankidofbc', $this->bankidofbc])
                ->andFilterWhere(['like', 'upsrlm_bankidbc', $this->upsrlm_bankidbc]);

        return $dataProvider;
    }
}
