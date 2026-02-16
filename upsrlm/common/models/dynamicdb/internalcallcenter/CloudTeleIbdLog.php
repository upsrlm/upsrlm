<?php

namespace common\models\dynamicdb\internalcallcenter;

use common\models\dynamicdb\internalcallcenter\hhs\HhsCallingLog;
use Yii;

/**
 * This is the model class for table "cloud_tele_ibd_log".
 *
 * @property int $id
 * @property int|null $upsrlm_user_id
 * @property string|null $agent_name
 * @property string|null $upsrlm_user_mobile_no
 * @property string|null $customernumber
 * @property string|null $cNumber
 * @property string|null $request_datetime
 * @property int|null $time_before
 * @property string|null $time_text_before
 * @property string|null $datetime_before
 * @property int|null $time_after
 * @property string|null $time_text_after
 * @property string|null $datetime_after
 * @property string|null $callid
 * @property string|null $full_response_before
 * @property string|null $full_response_after
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class CloudTeleIbdLog extends InternalCallCenteractiveRecord {

    const TYPE_NONE = 0;
    const TYPE_BC = 1;
    const TYPE_SHG = 2;
    const TYPE_VO = 3;
    const TYPE_VO_SAMUH_SAKHI = 31;
    const TYPE_CLF = 4;

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cloud_tele_ibd_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['upsrlm_user_id', 'time_before', 'time_after', 'created_at', 'updated_at', 'status'], 'integer'],
            [['request_datetime', 'datetime_before', 'datetime_after'], 'safe'],
            [['full_response_before', 'full_response_after'], 'string'],
            [['agent_name'], 'string', 'max' => 255],
            [['upsrlm_user_mobile_no', 'customernumber', 'cNumber'], 'string', 'max' => 15],
            [['time_text_before', 'time_text_after'], 'string', 'max' => 100],
            [['callid'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'upsrlm_user_id' => 'Upsrlm User ID',
            'agent_name' => 'Agent Name',
            'upsrlm_user_mobile_no' => 'Upsrlm User Mobile No',
            'customernumber' => 'Customernumber',
            'cNumber' => 'C Number',
            'request_datetime' => 'Request Datetime',
            'time_before' => 'Time Before',
            'time_text_before' => 'Time Text Before',
            'datetime_before' => 'Datetime Before',
            'time_after' => 'Time After',
            'time_text_after' => 'Time Text After',
            'datetime_after' => 'Datetime After',
            'callid' => 'Callid',
            'full_response_before' => 'Full Response Before',
            'full_response_after' => 'Full Response After',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        $null = new \yii\db\Expression('NULL');
        $attribute = CloudTeleIbdLog::findOne($this->id);
        $member_type = self::TYPE_NONE;
        try {
            if ($attribute->status == 2 and $attribute->upsrlm_user_id) {
//                $user_model = \common\models\User::find()->where(['username' => $attribute->customernumber, 'status' => 10])->one();
//                if ($user_model != null) {
//                    $this->insertultracall($attribute, $user_model); 
//                }
                $ultrapoor = \common\models\dynamicdb\ultrapoor\nfsa\NfsaBaseSurvey::findOne(['mobile_no' => $attribute->customernumber, 'status' => 1]);
                $member = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['mobile' => $attribute->customernumber, 'status' => 1])->one();
                if ($member != null) {
                    $member_type = self::TYPE_SHG;
                } else {
                    $member = \cbo\models\CboVo::find()->where(['samuh_sakhi_mobile_no' => $attribute->customernumber, 'wada' => 1])->andWhere(['is not', 'samuh_sakhi_cbo_shg_id', $null])->one();
                    if ($member != null) {
                        $member_type = self::TYPE_VO_SAMUH_SAKHI;
                    }
                }
                $this->insertcalllist($attribute, $member, $member_type);
                 if ($ultrapoor != null) {
                     $this->inserthhs($ibd, $ultrapoor);
                 }
            }
        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
//            exit;
        }


        return true;
    }

    private function insertcalllist($ibd, $member = null, $member_type) {
        $call_ibd = CloudTeleApiLog::find()->select(['id'])->where(['customernumber' => $ibd->customernumber, 'upsrlm_call_type' => 2])->count();
        if ($member_type == self::TYPE_SHG) {
            $call_list_ibd = new platform\CallingList();
            $call_list_ibd->rishta_shg_member_id = $member->id;
            $call_list_ibd->customer_number = $ibd->customernumber;
            $call_list_ibd->calling_agent_number = $ibd->upsrlm_user_mobile_no;
            $call_list_ibd->calling_agent_id = $ibd->upsrlm_user_id;
            $call_list_ibd->caller_group_id = 2;
            $call_list_ibd->call_generate_date = date("Y-m-d");
            $call_list_ibd->call_schedule_date = date("Y-m-d");
            $call_list_ibd->default_call_scenario_id = 0;
            $call_list_ibd->agent_call_received = 0;
            $call_list_ibd->callid = $ibd->callid;
            $call_list_ibd->cbo_shg_id = $member->cbo_shg_id;
            $call_list_ibd->name_of_shg = $member->cboshg->name_of_shg;
            $call_list_ibd->member_name = $member->name;
            $call_list_ibd->member_mobile = $member->mobile;
            $call_list_ibd->member_marital_status = $member->marital_status;
            $call_list_ibd->member_age = $member->age;
            $call_list_ibd->member_caste_category = $member->caste_category;
            $call_list_ibd->member_duration_of_membership = $member->duration_of_membership;
            $call_list_ibd->member_total_saving = $member->total_saving;
            $call_list_ibd->member_loan = $member->loan;
            $call_list_ibd->member_loan_count = $member->loan_count;
            $call_list_ibd->member_loan_amount = $member->loan_amount;
            $call_list_ibd->member_role = $member->role;
            $call_list_ibd->member_relative_in_shg = $member->relative_in_shg;
            $call_list_ibd->member_no_of_relative = $member->no_of_relative;
            $call_list_ibd->member_current_member = $member->current_member;
            $call_list_ibd->member_user_id = $member->user_id;
            $call_list_ibd->member_status = $member->status;
            $call_list_ibd->member_district_code = $member->cboshg->district_code;
            $call_list_ibd->member_district_name = $member->cboshg->district_name;
            $call_list_ibd->member_block_code = $member->cboshg->block_code;
            $call_list_ibd->member_block_name = $member->cboshg->block_name;
            $call_list_ibd->member_gram_panchayat_code = $member->cboshg->gram_panchayat_code;
            $call_list_ibd->member_gram_panchayat_name = $member->cboshg->gram_panchayat_name;
            $call_list_ibd->member_village_code = $member->cboshg->village_code;
            $call_list_ibd->member_village_name = $member->cboshg->village_name;
            $call_list_ibd->member_wada_shg = $member->cboshg->wada_shg;

            $call_list_ibd->upsrlm_call_type = 2;
            $call_list_ibd->ibd_request_datetime = $ibd->request_datetime;
            $call_list_ibd->ibd_call_count = ($call_ibd + 1);
            if ($call_list_ibd->save(false)) {
                
            }
        } elseif ($member_type == self::TYPE_VO_SAMUH_SAKHI) {
            $call_list_ibd = new platform\CallingList();
            $call_list_ibd->rishta_shg_member_id = 0;
            $call_list_ibd->customer_number = $ibd->customernumber;
            $call_list_ibd->calling_agent_number = $ibd->upsrlm_user_mobile_no;
            $call_list_ibd->calling_agent_id = $ibd->upsrlm_user_id;
            $call_list_ibd->caller_group_id = 2;
            $call_list_ibd->call_generate_date = date("Y-m-d");
            $call_list_ibd->call_schedule_date = date("Y-m-d");
            $call_list_ibd->default_call_scenario_id = 0;
            $call_list_ibd->agent_call_received = 0;
            $call_list_ibd->callid = $ibd->callid;
            $call_list_ibd->cbo_shg_id = $member->samuh_sakhi_cbo_shg_id;
            $call_list_ibd->cbo_vo_id = $member->id;
            $call_list_ibd->name_of_shg = $member->samuhsakhishg->name_of_shg;
            $call_list_ibd->member_name = $member->samuh_sakhi_name;
            $call_list_ibd->member_mobile = $member->samuh_sakhi_mobile_no;
            $call_list_ibd->member_age = $member->samuh_sakhi_age;
            $call_list_ibd->member_caste_category = $member->samuh_sakhi_social_category;
            $call_list_ibd->member_district_code = $member->district_code;
            $call_list_ibd->member_district_name = $member->district_name;
            $call_list_ibd->member_block_code = $member->block_code;
            $call_list_ibd->member_block_name = $member->block_name;
            $call_list_ibd->member_gram_panchayat_code = $member->gram_panchayat_code;
            $call_list_ibd->member_gram_panchayat_name = $member->gram_panchayat_name;
            $call_list_ibd->member_village_code = $member->samuhsakhishg->village_code;
            $call_list_ibd->member_village_name = $member->samuhsakhishg->village_name;
            $call_list_ibd->member_wada_shg = $member->samuhsakhishg->wada_shg;
            $call_list_ibd->upsrlm_call_type = 2;
            $call_list_ibd->ibd_request_datetime = $ibd->request_datetime;
            $call_list_ibd->ibd_call_count = ($call_ibd + 1);
            if ($call_list_ibd->save(false)) {
                
            }
        } elseif ($member_type == self::TYPE_NONE) {
            $call_list_ibd = new platform\CallingList();
            $call_list_ibd->rishta_shg_member_id = 0;
            $call_list_ibd->customer_number = $ibd->customernumber;
            $call_list_ibd->calling_agent_number = $ibd->upsrlm_user_mobile_no;
            $call_list_ibd->calling_agent_id = $ibd->upsrlm_user_id;
            $call_list_ibd->caller_group_id = 2;
            $call_list_ibd->call_generate_date = date("Y-m-d");
            $call_list_ibd->call_schedule_date = date("Y-m-d");
            $call_list_ibd->default_call_scenario_id = 0;
            $call_list_ibd->agent_call_received = 0;
            $call_list_ibd->callid = $ibd->callid;
            $call_list_ibd->upsrlm_call_type = 2;
            $call_list_ibd->ibd_request_datetime = $ibd->request_datetime;
            $call_list_ibd->ibd_call_count = ($call_ibd + 1);
            if ($call_list_ibd->save(false)) {
                
            }
        }
    }

    private function insertultracall($ibd, $member = null) {
        $call_ibd = CloudTeleApiLog::find()->select(['id'])->where(['customernumber' => $ibd->customernumber, 'upsrlm_call_type' => 2])->count();

        $call_list_ibd = new platform\UltraPoorCallingLog();
        $call_list_ibd->user_id = $member->id;
        $call_list_ibd->role = $member->role;
        $call_list_ibd->name = $member->name;
        $call_list_ibd->customer_number = $ibd->customernumber;
        $call_list_ibd->calling_agent_number = $ibd->upsrlm_user_mobile_no;
        $call_list_ibd->calling_agent_id = $ibd->upsrlm_user_id;
        $call_list_ibd->caller_group_id = 2;
        $call_list_ibd->call_generate_date = date("Y-m-d");
        $call_list_ibd->call_schedule_date = date("Y-m-d");
        $call_list_ibd->default_call_scenario_id = 0;
        $call_list_ibd->agent_call_received = 0;
        $call_list_ibd->callid = $ibd->callid;
        $call_list_ibd->district_name = implode(', ', array_unique(\yii\helpers\ArrayHelper::getColumn($member->grampanchayat, 'district.district_name')));
        ;
        $call_list_ibd->block_name = implode(', ', array_unique(\yii\helpers\ArrayHelper::getColumn($member->grampanchayat, 'block.block_name')));
        $call_list_ibd->gram_panchayat_name = implode(', ', array_unique(\yii\helpers\ArrayHelper::getColumn($member->grampanchayat, 'gp.gram_panchayat_name')));
        $call_list_ibd->upsrlm_call_type = 2;
        $call_list_ibd->ibd_request_datetime = $ibd->request_datetime;
        $call_list_ibd->ibd_call_count = ($call_ibd + 1);
        $call_list_ibd->status = 0;
        if ($call_list_ibd->save(false)) {
            
        }
    }

    private function inserthhs($ibd, $hhs_model = null) {
        $call_ibd = CloudTeleApiLog::find()->select(['id'])->where(['customernumber' => $ibd->customernumber, 'upsrlm_call_type' => 2])->count();

        $call_list_ibd = new HhsCallingLog();
        $call_list_ibd->household_member_id = $hhs_model->id;
        $call_list_ibd->customer_number = $hhs_model->mobile_no;
        $call_list_ibd->calling_agent_number = $ibd->upsrlm_user_mobile_no;
        $call_list_ibd->calling_agent_id = $ibd->upsrlm_user_id;
        $call_list_ibd->call_generate_date = date("Y-m-d");
        $call_list_ibd->call_schedule_date = date("Y-m-d");
        $call_list_ibd->customer_number = $ibd->customernumber;
        $call_list_ibd->caller_group_id = 2;
        $call_list_ibd->default_call_scenario_id = 0;
        $call_list_ibd->agent_call_received = 0;
        $call_list_ibd->callid = $ibd->callid;
        $call_list_ibd->hhs_name = $hhs_model->name_of_head_of_household;
        $call_list_ibd->user_id = $hhs_model->hhs_user_id;
        $call_list_ibd->user_role = $hhs_model->hhs_user_role;
        $call_list_ibd->pin = $hhs_model->hhs_pin;
        $call_list_ibd->user_login = $hhs_model->app_login;
        $call_list_ibd->district_code = $hhs_model->district_code;
        if (isset($hhs_model->district->district_name)) {
            $call_list_ibd->district_name = $hhs_model->district->district_name;
        }
        $call_list_ibd->block_code = $hhs_model->block_code;
        if (isset($hhs_model->block->block_name)) {
            $call_list_ibd->block_name = $hhs_model->block->block_name;
        }
        $call_list_ibd->gram_panchayat_code = $hhs_model->gram_panchayat_code;
        if (isset($hhs_model->gp->gram_panchayat_name)) {
            $call_list_ibd->gram_panchayat_name = $hhs_model->gp->gram_panchayat_name;
        }
        $call_list_ibd->village_code = $hhs_model->village_code;
        if (isset($hhs_model->village->village_name)) {
            $call_list_ibd->village_name = $hhs_model->village->village_name;
        }
        $call_list_ibd->upsrlm_call_type = 2;
        $call_list_ibd->ibd_request_datetime = $ibd->request_datetime;
        $call_list_ibd->ibd_call_count = ($call_ibd + 1);
        $call_list_ibd->status = 0;
        if ($call_list_ibd->save(false)) {
            
        }
    }
}
