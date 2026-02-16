<?php

namespace bc\modules\selection\models\report;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\base\GenralModel;
use yii\helpers\ArrayHelper;
use common\models\master\MasterRole;

/**
 * Report  
 */
class Feedback extends Model {

    public $id;
    public $bc_application_id;
    public $srlm_bc_selection_user_id;
    public $bc_name;
    public $division_code;
    public $division_name;
    public $district_code;
    public $district_name;
    public $block_code;
    public $block_name;
    public $gram_panchayat_code;
    public $gram_panchayat_name;
    public $village_code;
    public $village_name;
    public $hamlet;
    public $ques_1;
    public $ques_2;
    public $ques_3;
    public $ques_4;
    public $ques_5;
    public $created_at;
    public $updated_at;
    public $status;
    public $master_partner_bank_id;
    public $feedback_form_status;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['district_code', 'block_code', 'village_code', 'gram_panchayat_code', 'ques_1','feedback_form_status'], 'safe'],
            [['ques_2', 'ques_3', 'status', 'ques_4', 'ques_5', 'division_code', 'master_partner_bank_id'], 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'district_code' => 'District',
            'division_code' => 'Division',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'village_code' => 'Village',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function graph($params) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
//        print_r($params['district_code']);exit;
        $graph = [];

        $query = "SELECT
                      SUM(CASE WHEN srlmbc.ques_1  = '1' THEN 1 ELSE 0 END) AS que1a1,
                      SUM(CASE WHEN srlmbc.ques_1  = '2' THEN 1 ELSE 0 END) AS que1a2,
                      SUM(CASE WHEN srlmbc.ques_1  = '3' THEN 1 ELSE 0 END) AS que1a3,
                      SUM(CASE WHEN srlmbc.ques_2  = '1' THEN 1 ELSE 0 END) AS que2a1,
                      SUM(CASE WHEN srlmbc.ques_2  = '2' THEN 1 ELSE 0 END) AS que2a2,
                      SUM(CASE WHEN srlmbc.ques_2  = '3' THEN 1 ELSE 0 END) AS que2a3,
                                      
                      SUM(CASE WHEN srlmbc.ques_3  = '1' THEN 1 ELSE 0 END) AS que3a1,
                      SUM(CASE WHEN srlmbc.ques_3  = '2' THEN 1 ELSE 0 END) AS que3a2,
                      SUM(CASE WHEN srlmbc.ques_3  = '3' THEN 1 ELSE 0 END) AS que3a3,
                  
                      SUM(CASE WHEN srlmbc.ques_4  = '1' THEN 1 ELSE 0 END) AS que4a1,
                      SUM(CASE WHEN srlmbc.ques_4  = '2' THEN 1 ELSE 0 END) AS que4a2,
                      SUM(CASE WHEN srlmbc.ques_4  = '3' THEN 1 ELSE 0 END) AS que4a3,
                      COUNT(*) AS total
                      FROM  bc_pbt_feedback AS srlmbc 
                    join srlm_bc_application on srlm_bc_application.id=srlmbc.bc_application_id  
                    ";
        $where = " where srlmbc.status !=-1 ";
        if ($this->division_code) {
            $where .= ' and srlm_bc_application.division_code=' . $this->division_code;
        }
        if ($params['district_code']) {
            $where .= ' and srlm_bc_application.district_code=' . $params['district_code'];
        }
        if ($params['block_code']) {
            $where .= ' and srlm_bc_application.block_code=' . $params['block_code'];
        }
        if ($params['gram_panchayat_code']) {
            $where .= ' and srlm_bc_application.gram_panchayat_code=' . $params['gram_panchayat_code'];
        }

        if ($params['master_partner_bank_id']) {
            $where .= ' and srlm_bc_application.master_partner_bank_id=' . $params['master_partner_bank_id'];
        }
        $query .= $where;
        $graph = \Yii::$app->dbbc->createCommand($query)->queryOne();
        return $graph;
    }

    public function bctraiking($params) {
        $user_model = Yii::$app->user->identity;
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $graph = [];

        $query = "SELECT
                      ROUND(SUM(ques_1)*100/count(*),0) as ques1,
                      ROUND(SUM(ques_2)*100/count(*),0) as ques2,
                      ROUND(SUM(ques_3)*100/count(*),0) as ques3,
                      ROUND(SUM(ques_4)*100/count(*),0) as ques4,
                      ROUND(SUM(ques_5)*100/count(*),0) as ques5,
                      ROUND(SUM(ques_6)*100/count(*),0) as ques6,
                      ROUND(SUM(ques_7)*100/count(*),0) as ques7,                
                      ROUND(SUM(ques_8)*100/count(*),0) as ques8,
                      ROUND(SUM(ques_9)*100/count(*),0) as ques9,
                      ROUND(SUM(ques_10)*100/count(*),0) as ques10,
                      ROUND(SUM(ques_11)*100/count(*),0) as ques11,
                      ROUND(SUM(ques_12)*100/count(*),0) as ques12,
                      ROUND(SUM(ques_13)*100/count(*),0) as ques13,
                      ROUND(SUM(ques_14)*100/count(*),0) as ques14,
                      ROUND(SUM(ques_15)*100/count(*),0) as ques15,
                      ROUND(SUM(ques_16)*100/count(*),0) as ques16,
                      ROUND(SUM(ques_17)*100/count(*),0) as ques17,
                      ROUND(SUM(ques_18)*100/count(*),0) as ques18,
                      ROUND(SUM(ques_19)*100/count(*),0) as ques19,
                      ROUND(SUM(ques_20)*100/count(*),0) as ques20,
                      COUNT(*) AS total
                      FROM  bc_tracking_feedback AS srlmbc 
                    join srlm_bc_application on srlm_bc_application.id=srlmbc.bc_application_id  
                    ";
        $where = " where srlmbc.status !=-1 ";
        if ($user_model == NULL) {
            
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $where .= " and srlmbc.district_code in (" . implode(",", ArrayHelper::getColumn($user_model->districts, 'district_code')) . ")";
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $where .= " and srlmbc.district_code in (" . implode(",", ArrayHelper::getColumn($user_model->districts, 'district_code')) . ")";
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $where .= " and srlmbc.district_code in (" . implode(",", ArrayHelper::getColumn($user_model->districts, 'district_code')) . ")";
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $where .= " and srlmbc.district_code in (" . implode(",", ArrayHelper::getColumn($user_model->districts, 'district_code')) . ")";
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $where .= ' and srlm_bc_application.master_partner_bank_id=' . $user_model->master_partner_bank_id;
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $where .= ' and srlm_bc_application.master_partner_bank_id=' . $user_model->master_partner_bank_id;
                $where .= " and srlmbc.district_code in (" . implode(",", ArrayHelper::getColumn($user_model->districts, 'district_code')) . ")";
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $where .= ' and srlm_bc_application.master_partner_bank_id=' . $user_model->master_partner_bank_id;
                $where .= " and srlmbc.district_code in (" . implode(",", ArrayHelper::getColumn($user_model->districts, 'district_code')) . ")";
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $where .= " and srlmbc.district_code in (" . implode(",", ArrayHelper::getColumn($user_model->districts, 'district_code')) . ")";
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $where .= " and srlmbc.district_code in (" . implode(",", ArrayHelper::getColumn($user_model->districts, 'district_code')) . ")";
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RBI])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            }
        }
        if ($this->division_code) {
            $where .= ' and srlm_bc_application.division_code=' . $this->division_code;
        }
        if ($params['district_code']) {
            $where .= ' and srlm_bc_application.district_code=' . $params['district_code'];
        }
        if ($params['block_code']) {
            $where .= ' and srlm_bc_application.block_code=' . $params['block_code'];
        }
        if ($params['gram_panchayat_code']) {
            $where .= ' and srlm_bc_application.gram_panchayat_code=' . $params['gram_panchayat_code'];
        }

        if ($params['master_partner_bank_id']) {
            $where .= ' and srlm_bc_application.master_partner_bank_id=' . $params['master_partner_bank_id'];
        }
        if ($params['feedback_form_status']) {
            if($params['feedback_form_status']==1){
             $where .= ' and srlmbc.section >=' . 9;   
            }
            if($params['feedback_form_status']==2){
               $where .= ' and srlmbc.section <' . 9;    
            }
            
        }
        $query .= $where;
        $graph = \Yii::$app->dbbc->createCommand($query)->queryOne();
        return $graph;
    }
}
