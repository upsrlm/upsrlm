<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_role".
 *
 * @property int $id
 * @property string $role_name
 * @property int $status
 */
class MasterRole extends \yii\db\ActiveRecord {

    const ROLE_SUPER_ADMIN = 0;
    const ROLE_ADMIN = 1;
    const ROLE_MSC = 7;
    const ROLE_PCI_ADMIN = 8;
    const ROLE_PCI_USER = 9;
    const ROLE_CALL_CENTER_ADMIN = 11;
    const ROLE_CALL_CENTER_EXECUTIVE = 12;
    const ROLE_HR_ADMIN = 13;
    const ROLE_MD = 14;
    const ROLE_JMD = 15;
    const ROLE_SBMG = 16;
    const ROLE_SPM_FI_MF = 17;
    const ROLE_BACKEND_OPERATOR = 18;
    const ROLE_SMMU = 19;
    const ROLE_DIRECTOR_RURAL_DD = 20;
    const ROLE_CDO = 21;
    const ROLE_DSO = 22;
    const ROLE_DM = 23;
    const ROLE_DMMU = 24;
    const ROLE_DC_NRLM = 25;
    const ROLE_SUPPORT_UNIT = 26;
    const ROLE_DPRO = 27;
    const ROLE_DPM = 28;
    const ROLE_DIVISION_DISTRICT_DIRECTOR = 29;
    const ROLE_PD = 30;
    const ROLE_BDO_SUPPORTER = 34;
    const ROLE_ADO = 33;
    const ROLE_BDO = 31;
    const ROLE_BMMU = 32;
    const ROLE_GP_SAACHIV = 41;
    const ROLE_GP_ADHIKARI = 42;
    const ROLE_GP_SAHAYAK = 43;
    const ROLE_GRAM_PARDHAN = 44;
    const ROLE_GP_ROJGAR_SEVAK = 45;
    const ROLE_GP_SAFAI_KARMI = 46;
    const ROLE_ULTRA_POOR_ENUMERATOR = 47;
    const ROLE_GP_SECONDARY_ENUMERATOR = 45;
    const ROLE_DIRECTOR_ULB = 50;
    const ROLE_MC = 51;
    const ROLE_URBAN_PRIMARY_ENUMERATOR = 55;
    const ROLE_URBAN_SECONDARY_ENUMERATOR = 56;
    const ROLE_DIVISIONAL_COMMISSIONER = 60;
    const ROLE_DIVISIONAL_CONSULTANTS = 61;
    const ROLE_DISTRICT_CONSULTANTS = 62;
    const ROLE_DPO = 63;
    const ROLE_DYCPO = 64;
    const ROLE_CUSTOM = 70;
    const ROLE_YOUNG_PROFESSIONAL = 71;
    const ROLE_VIEWER = 72; //NMMU-FI, MoRD
    const ROLE_SPM_FINANCE = 73;
    const ROLE_BC_VIEWER = 74;
    const ROLE_PANCHAYATI_RAJ = 75;
    const ROLE_PANCHAYATI_RAJ_DISTRICT_LEVEL = 76;
    // RSETIS Role
    const ROLE_RSETIS_STATE_UNIT = 80;
    const ROLE_RSETIS_DISTRICT_UNIT = 81;
    const ROLE_RSETIS_NODAL_BANK = 82;
    const ROLE_UPSRLM_RSETI_ANCHOR = 83;
    const ROLE_RSETIS_BATCH_CREATOR = 84;
    const ROLE_RBI = 87;
    // Bank partner Role
    const ROLE_BANK_DISTRICT_UNIT = 90;
    const ROLE_BANK_FI_PARTNER_DISTRICT_NODAL = 91;
    const ROLE_CORPORATE_BCS = 92;
    const ROLE_CBO_USER = 100;
    const ROLE_ZERO_POVERTY_USER = 120;
    const ROLE_ENUMERATION_UPDATER = 121;
    // Internal Call Center Role
    const ROLE_INTERNAL_CALL_CENTER_ADMIN = 150;
    const ROLE_INTERNAL_CALL_CENTER_EXECUTIVE = 151;
    // DBT Call Center Role
    const ROLE_DBT_CALL_CENTER_MANAGER = 160;
    const ROLE_DBT_CALL_CENTER_EXECUTIVE = 161;
    // Saheli role constant
    const ROLE_FRONTIER_MARKET_ADMIN = 202;
    const ROLE_FRONTIER_MARKET_DISTRICT_ADMIN = 203;
    // Wada Role constant
    const ROLE_WADA_ADMIN = 302;
    const ROLE_WADA_VIEWER = 303;
    const ROLE_UPSDM_STATE = 320;
    const ROLE_UPSDM_DISTRICT = 321;
    const ROLE_ULTRA_POOR_VIEWER = 350;
    const ROLE_DASHBOARD_VIEWER = 351;
    const ROLE_ZERO_POVERTY_INTERNAL_VIEWER = 352;
    // Department Role
    const ROLE_DBT_USER = 400;
    const ROLE_PANCHAYATI_RAJ_SBM_G = 401;
    const ROLE_BOCW_ADMIN = 402;
    const ROLE_BOCW_DISTRICT_LEVEL = 403;
    const ROLE_BOCW_VIEWER = 404;
    const ROLE_LABOUR_STATE_LEVEL = 405;
    const ROLE_LABOUR_DISTRICT_LEVEL = 406;
    const ROLE_BASIC_EDUCATION_ADMIN = 410;
    const ROLE_AGRICULTURE_ADMIN = 420;
    const ROLE_AGRICULTURE_DISTRICT = 441;
    const ROLE_AGRICULTURE_DEO = 429;
    const ROLE_PANCHAYATI_RAJ_DEO = 430;
    const ROLE_RD_ADMIN = 440;
    const ROLE_RD_HOUSING_ADMIN = 450;
    const ROLE_SOCIAL_WELFARE_ADMIN = 460;
    const ROLE_SOCIAL_WELFARE_DISTRICT_LEVEL = 461;
    const ROLE_WOMEN_WELFARE_ADMIN = 470;
    const ROLE_WOMEN_WELFARE_DISTRICT_LEVEL = 471;
    const ROLE_FOOD_CIVIL_SUPPLIES_ADMIN = 480;
    const ROLE_NAMAMI_GANGE_ADMIN = 485;
    const ROLE_MEDICAL_HEALTH_ADMIN = 490;
    const ROLE_URBAN_DEVELOPMENT_ADMIN = 500;
    const ROLE_DISABILITY_STATE_LEVEL = 510;
    const ROLE_DISABILITY_DISTRICT_LEVEL = 511;
    const ROLE_CM_HELPLINE = 170;
    const ROLE_CM_HELPLINE_MANAGER = 171;
    const ROLE_FAMILYID_USER = 200;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'role_name'], 'required'],
            [['id', 'status'], 'integer'],
            [['role_name'], 'string', 'max' => 30],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'status' => 'Status',
        ];
    }
}
