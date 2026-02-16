<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\BcHonorariumPayment;
use common\models\master\MasterRole;

/**
 * BcHonorariumPaymentSearch represents the model behind the search form of `bc\modules\selection\models\BcHonorariumPayment`.
 */
class BcHonorariumPaymentSearch extends BcHonorariumPayment {

    public $nretp;
    public $aspirational;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'month1_payment_by', 'month1_acknowledge', 'month1_acknowledge_rishta_notification', 'month1_acknowledge_not_recived_reason', 'month1_acknowledge_not_recived_reason_other', 'month2_payment_by', 'month2_acknowledge', 'month2_acknowledge_rishta_notification', 'month2_acknowledge_not_recived_reason', 'month2_acknowledge_not_recived_reason_other', 'month3_payment_by', 'month3_acknowledge', 'month3_acknowledge_rishta_notification', 'month3_acknowledge_not_recived_reason', 'month3_acknowledge_not_recived_reason_other', 'month4_payment_by', 'month4_acknowledge', 'month4_acknowledge_rishta_notification', 'month4_acknowledge_not_recived_reason', 'month4_acknowledge_not_recived_reason_other', 'month5_payment_by', 'month5_acknowledge', 'month5_acknowledge_rishta_notification', 'month5_acknowledge_not_recived_reason', 'month5_acknowledge_not_recived_reason_other', 'month6_payment_by', 'month6_acknowledge', 'month6_acknowledge_rishta_notification', 'month6_acknowledge_not_recived_reason', 'month6_acknowledge_not_recived_reason_other', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['month1', 'month1_payment_date', 'month1_payment_datetime', 'month1_acknowledge_recived_date', 'month1_acknowledge_datetime', 'month2', 'month2_payment_date', 'month2_payment_datetime', 'month2_acknowledge_recived_date', 'month2_acknowledge_datetime', 'month3', 'month3_payment_date', 'month3_payment_datetime', 'month3_acknowledge_recived_date', 'month3_acknowledge_datetime', 'month4', 'month4_payment_date', 'month4_payment_datetime', 'month4_acknowledge_recived_date', 'month4_acknowledge_datetime', 'month5', 'month5_payment_date', 'month5_payment_datetime', 'month5_acknowledge_recived_date', 'month5_acknowledge_datetime', 'month6', 'month6_payment_date', 'month6_payment_datetime', 'month6_acknowledge_recived_date', 'month6_acknowledge_datetime'], 'safe'],
            [['month1_payment_amount', 'month1_acknowledge_amount', 'month2_payment_amount', 'month2_acknowledge_amount', 'month3_payment_amount', 'month3_acknowledge_amount', 'month4_payment_amount', 'month4_acknowledge_amount', 'month5_payment_amount', 'month5_acknowledge_amount', 'month6_payment_amount', 'month6_acknowledge_amount'], 'number'],
            [['nretp'], 'safe'],
            [['aspirational'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $columns = null, $select = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = BcHonorariumPayment::find();
        $query->joinWith(['bc']);
        // add conditions that should always apply here

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {

                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {

                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {

                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $query->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {

                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } else {
                $query->where('0=1');
            }
            if ($this->nretp != '') {
                $query->joinWith(['block']);
                $query->andWhere(['master_block.nretp' => $this->nretp]);
            }
            if ($this->aspirational != '') {
                $query->joinWith(['block']);
                $query->andWhere(['master_block.aspirational' => $this->aspirational]);
            }
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
                    //'sort' => ['defaultOrder' => ['first_name' => SORT_ASC]],
            ]);

            $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                BcHonorariumPayment::getTableSchema()->fullName . '.id' => $this->id,
                BcHonorariumPayment::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
                BcHonorariumPayment::getTableSchema()->fullName . '.srlm_bc_selection_user_id' => $this->srlm_bc_selection_user_id,
                BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $this->district_code,
                BcHonorariumPayment::getTableSchema()->fullName . '.block_code' => $this->block_code,
                BcHonorariumPayment::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
                BcHonorariumPayment::getTableSchema()->fullName . '.month1' => $this->month1,
                BcHonorariumPayment::getTableSchema()->fullName . '.month1_payment_amount' => $this->month1_payment_amount,
                BcHonorariumPayment::getTableSchema()->fullName . '.month1_payment_date' => $this->month1_payment_date,
                BcHonorariumPayment::getTableSchema()->fullName . '.month1_payment_by' => $this->month1_payment_by,
                BcHonorariumPayment::getTableSchema()->fullName . '.month1_payment_datetime' => $this->month1_payment_datetime,
                BcHonorariumPayment::getTableSchema()->fullName . '.month1_acknowledge' => $this->month1_acknowledge,
                BcHonorariumPayment::getTableSchema()->fullName . '.month1_acknowledge_recived_date' => $this->month1_acknowledge_recived_date,
                BcHonorariumPayment::getTableSchema()->fullName . '.month1_acknowledge_rishta_notification' => $this->month1_acknowledge_rishta_notification,
                BcHonorariumPayment::getTableSchema()->fullName . '.month1_acknowledge_not_recived_reason' => $this->month1_acknowledge_not_recived_reason,
                BcHonorariumPayment::getTableSchema()->fullName . '.month1_acknowledge_not_recived_reason_other' => $this->month1_acknowledge_not_recived_reason_other,
                BcHonorariumPayment::getTableSchema()->fullName . '.month1_acknowledge_amount' => $this->month1_acknowledge_amount,
                BcHonorariumPayment::getTableSchema()->fullName . '.month1_acknowledge_datetime' => $this->month1_acknowledge_datetime,
                BcHonorariumPayment::getTableSchema()->fullName . '.month2' => $this->month2,
                BcHonorariumPayment::getTableSchema()->fullName . '.month2_payment_amount' => $this->month2_payment_amount,
                BcHonorariumPayment::getTableSchema()->fullName . '.month2_payment_date' => $this->month2_payment_date,
                BcHonorariumPayment::getTableSchema()->fullName . '.month2_payment_by' => $this->month2_payment_by,
                BcHonorariumPayment::getTableSchema()->fullName . '.month2_payment_datetime' => $this->month2_payment_datetime,
                BcHonorariumPayment::getTableSchema()->fullName . '.month2_acknowledge' => $this->month2_acknowledge,
                BcHonorariumPayment::getTableSchema()->fullName . '.month2_acknowledge_recived_date' => $this->month2_acknowledge_recived_date,
                BcHonorariumPayment::getTableSchema()->fullName . '.month2_acknowledge_rishta_notification' => $this->month2_acknowledge_rishta_notification,
                BcHonorariumPayment::getTableSchema()->fullName . '.month2_acknowledge_not_recived_reason' => $this->month2_acknowledge_not_recived_reason,
                BcHonorariumPayment::getTableSchema()->fullName . '.month2_acknowledge_not_recived_reason_other' => $this->month2_acknowledge_not_recived_reason_other,
                BcHonorariumPayment::getTableSchema()->fullName . '.month2_acknowledge_amount' => $this->month2_acknowledge_amount,
                BcHonorariumPayment::getTableSchema()->fullName . '.month2_acknowledge_datetime' => $this->month2_acknowledge_datetime,
                BcHonorariumPayment::getTableSchema()->fullName . '.month3' => $this->month3,
                BcHonorariumPayment::getTableSchema()->fullName . '.month3_payment_amount' => $this->month3_payment_amount,
                BcHonorariumPayment::getTableSchema()->fullName . '.month3_payment_date' => $this->month3_payment_date,
                BcHonorariumPayment::getTableSchema()->fullName . '.month3_payment_by' => $this->month3_payment_by,
                BcHonorariumPayment::getTableSchema()->fullName . '.month3_payment_datetime' => $this->month3_payment_datetime,
                BcHonorariumPayment::getTableSchema()->fullName . '.month3_acknowledge' => $this->month3_acknowledge,
                BcHonorariumPayment::getTableSchema()->fullName . '.month3_acknowledge_recived_date' => $this->month3_acknowledge_recived_date,
                BcHonorariumPayment::getTableSchema()->fullName . '.month3_acknowledge_rishta_notification' => $this->month3_acknowledge_rishta_notification,
                BcHonorariumPayment::getTableSchema()->fullName . '.month3_acknowledge_not_recived_reason' => $this->month3_acknowledge_not_recived_reason,
                BcHonorariumPayment::getTableSchema()->fullName . '.month3_acknowledge_not_recived_reason_other' => $this->month3_acknowledge_not_recived_reason_other,
                BcHonorariumPayment::getTableSchema()->fullName . '.month3_acknowledge_amount' => $this->month3_acknowledge_amount,
                BcHonorariumPayment::getTableSchema()->fullName . '.month3_acknowledge_datetime' => $this->month3_acknowledge_datetime,
                BcHonorariumPayment::getTableSchema()->fullName . '.month4' => $this->month4,
                BcHonorariumPayment::getTableSchema()->fullName . '.month4_payment_amount' => $this->month4_payment_amount,
                BcHonorariumPayment::getTableSchema()->fullName . '.month4_payment_date' => $this->month4_payment_date,
                BcHonorariumPayment::getTableSchema()->fullName . '.month4_payment_by' => $this->month4_payment_by,
                BcHonorariumPayment::getTableSchema()->fullName . '.month4_payment_datetime' => $this->month4_payment_datetime,
                BcHonorariumPayment::getTableSchema()->fullName . '.month4_acknowledge' => $this->month4_acknowledge,
                BcHonorariumPayment::getTableSchema()->fullName . '.month4_acknowledge_recived_date' => $this->month4_acknowledge_recived_date,
                BcHonorariumPayment::getTableSchema()->fullName . '.month4_acknowledge_rishta_notification' => $this->month4_acknowledge_rishta_notification,
                BcHonorariumPayment::getTableSchema()->fullName . '.month4_acknowledge_not_recived_reason' => $this->month4_acknowledge_not_recived_reason,
                BcHonorariumPayment::getTableSchema()->fullName . '.month4_acknowledge_not_recived_reason_other' => $this->month4_acknowledge_not_recived_reason_other,
                BcHonorariumPayment::getTableSchema()->fullName . '.month4_acknowledge_amount' => $this->month4_acknowledge_amount,
                BcHonorariumPayment::getTableSchema()->fullName . '.month4_acknowledge_datetime' => $this->month4_acknowledge_datetime,
                BcHonorariumPayment::getTableSchema()->fullName . '.month5' => $this->month5,
                BcHonorariumPayment::getTableSchema()->fullName . '.month5_payment_amount' => $this->month5_payment_amount,
                BcHonorariumPayment::getTableSchema()->fullName . '.month5_payment_date' => $this->month5_payment_date,
                BcHonorariumPayment::getTableSchema()->fullName . '.month5_payment_by' => $this->month5_payment_by,
                BcHonorariumPayment::getTableSchema()->fullName . '.month5_payment_datetime' => $this->month5_payment_datetime,
                BcHonorariumPayment::getTableSchema()->fullName . '.month5_acknowledge' => $this->month5_acknowledge,
                BcHonorariumPayment::getTableSchema()->fullName . '.month5_acknowledge_recived_date' => $this->month5_acknowledge_recived_date,
                BcHonorariumPayment::getTableSchema()->fullName . '.month5_acknowledge_rishta_notification' => $this->month5_acknowledge_rishta_notification,
                BcHonorariumPayment::getTableSchema()->fullName . '.month5_acknowledge_not_recived_reason' => $this->month5_acknowledge_not_recived_reason,
                BcHonorariumPayment::getTableSchema()->fullName . '.month5_acknowledge_not_recived_reason_other' => $this->month5_acknowledge_not_recived_reason_other,
                BcHonorariumPayment::getTableSchema()->fullName . '.month5_acknowledge_amount' => $this->month5_acknowledge_amount,
                BcHonorariumPayment::getTableSchema()->fullName . '.month5_acknowledge_datetime' => $this->month5_acknowledge_datetime,
                BcHonorariumPayment::getTableSchema()->fullName . '.month6' => $this->month6,
                BcHonorariumPayment::getTableSchema()->fullName . '.month6_payment_amount' => $this->month6_payment_amount,
                BcHonorariumPayment::getTableSchema()->fullName . '.month6_payment_date' => $this->month6_payment_date,
                BcHonorariumPayment::getTableSchema()->fullName . '.month6_payment_by' => $this->month6_payment_by,
                BcHonorariumPayment::getTableSchema()->fullName . '.month6_payment_datetime' => $this->month6_payment_datetime,
                BcHonorariumPayment::getTableSchema()->fullName . '.month6_acknowledge' => $this->month6_acknowledge,
                BcHonorariumPayment::getTableSchema()->fullName . '.month6_acknowledge_recived_date' => $this->month6_acknowledge_recived_date,
                BcHonorariumPayment::getTableSchema()->fullName . '.month6_acknowledge_rishta_notification' => $this->month6_acknowledge_rishta_notification,
                BcHonorariumPayment::getTableSchema()->fullName . '.month6_acknowledge_not_recived_reason' => $this->month6_acknowledge_not_recived_reason,
                BcHonorariumPayment::getTableSchema()->fullName . '.month6_acknowledge_not_recived_reason_other' => $this->month6_acknowledge_not_recived_reason_other,
                BcHonorariumPayment::getTableSchema()->fullName . '.month6_acknowledge_amount' => $this->month6_acknowledge_amount,
                BcHonorariumPayment::getTableSchema()->fullName . '.month6_acknowledge_datetime' => $this->month6_acknowledge_datetime,
                BcHonorariumPayment::getTableSchema()->fullName . '.created_by' => $this->created_by,
                BcHonorariumPayment::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
                BcHonorariumPayment::getTableSchema()->fullName . '.created_at' => $this->created_at,
                BcHonorariumPayment::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
                BcHonorariumPayment::getTableSchema()->fullName . '.status' => $this->status,
            ]);

            return $dataProvider;
        }
    }
}
