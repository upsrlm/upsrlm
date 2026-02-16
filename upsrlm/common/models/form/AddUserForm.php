<?php

namespace common\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use common\models\base\GenralModel;
use common\models\UserSearch;
use common\models\master\MasterRole;
use common\models\User;

/**
 * AddUserForm is the model behind the User
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class AddUserForm extends Model {

    public $id;
    public $name;
    public $username;
    public $password;
    public $email;
    public $role;
    public $mobile_no;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $profile_status = 1;
    public $login_by_otp;
    public $user_model;
    public $block_model;
    public $role_option = [];
    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';

    public function __construct($user_model = null) {
        $this->user_model = Yii::createObject([
                    'class' => User::className()
        ]);
        if ($user_model != null) {
            $this->user_model = $user_model;
            $this->name = $this->user_model->name;
            $this->username = $this->user_model->username;
            $this->email = $this->user_model->email;
            $this->mobile_no = $this->user_model->mobile_no;
            $this->role = $this->user_model->role;
            $this->password = substr($this->user_model->upd, 3);
            $this->profile_status = $this->user_model->profile_status;
            $this->login_by_otp = $this->user_model->login_by_otp;
        }
        //$this->role_option = ArrayHelper::map(\app\models\master\MasterRole::find()->all(), 'id', 'role_name'); // [UserModel::ROLE_GPA => 'Gram Panchayat Adhikari', UserModel::ROLE_GPS => 'Gram Panchayat Sachiv'];
        $this->role_option = [
            MasterRole::ROLE_DPRO => 'DPRO',
            MasterRole::ROLE_ADO => 'ADO',
            MasterRole::ROLE_HR_ADMIN => 'HR Admin',
            MasterRole::ROLE_CDO => 'Chief Development Officer',
            MasterRole::ROLE_CM_HELPLINE_MANAGER => 'CM Helpline Manager',
            MasterRole::ROLE_DASHBOARD_VIEWER=>'Dashboard Viewer',
            MasterRole::ROLE_DISABILITY_STATE_LEVEL => 'Disability (State Level)',
            MasterRole::ROLE_DISABILITY_DISTRICT_LEVEL=>'Disability (District Level)',
            MasterRole::ROLE_ZERO_POVERTY_INTERNAL_VIEWER=>'Zero Poverty Viewer',
            MasterRole::ROLE_DIRECTOR_ULB => 'Director ULB',
            MasterRole::ROLE_DIRECTOR_RURAL_DD => 'Director Rural Development Department',
            MasterRole::ROLE_DM => 'District Magistrate',
            MasterRole::ROLE_DPM => 'District Project Managers (DPM)',
            MasterRole::ROLE_DC_NRLM => 'DC NRLM',
            MasterRole::ROLE_DSO => 'District Supply Officer',
            MasterRole::ROLE_DIVISIONAL_COMMISSIONER => 'Divisional Commissioner ',
            MasterRole::ROLE_DIVISIONAL_CONSULTANTS => 'Divisional Consultants',
            MasterRole::ROLE_DISTRICT_CONSULTANTS => 'District Consultants',
            MasterRole::ROLE_BDO => 'Block Development Officer',
            MasterRole::ROLE_MC => 'Municipal Commissioner',
            MasterRole::ROLE_JMD => 'JMD',
            MasterRole::ROLE_VIEWER => 'NMMU-FI, MoRD',
            MasterRole::ROLE_SPM_FINANCE => 'SPM Finance',
            MasterRole::ROLE_BACKEND_OPERATOR => 'Backend Operator',
            MasterRole::ROLE_BC_VIEWER => 'BC Viewer',
            MasterRole::ROLE_SPM_FI_MF => 'State Program Manager - Financial Inclusion & Micro Finance',
            MasterRole::ROLE_PANCHAYATI_RAJ => 'Panchayati Raj',
            MasterRole::ROLE_PCI_USER => 'PCI User',
            MasterRole::ROLE_BMMU => 'BMMU',
            MasterRole::ROLE_DMMU => 'DMMU',
            MasterRole::ROLE_SMMU => 'SMMU',
            MasterRole::ROLE_SOCIAL_WELFARE_ADMIN => 'Social Welfare Admin',
            MasterRole::ROLE_SUPPORT_UNIT => 'Support Unit',
            MasterRole::ROLE_YOUNG_PROFESSIONAL => 'Young Proffssional',
            MasterRole::ROLE_RSETIS_STATE_UNIT => 'RSETIs State Unit',
            MasterRole::ROLE_RSETIS_DISTRICT_UNIT => 'RSETIs District Unit',
            MasterRole::ROLE_RSETIS_BATCH_CREATOR => 'RSETIs Batch creator',
            MasterRole::ROLE_RSETIS_NODAL_BANK => 'RSETIs Nodal Bank',
            MasterRole::ROLE_UPSRLM_RSETI_ANCHOR => 'UPSRLM- RSETI anchor',
            MasterRole::ROLE_BANK_DISTRICT_UNIT => 'Bank/FI Partner',
            MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL => 'Bank/FI Partner District Nodal',
            MasterRole::ROLE_FRONTIER_MARKET_ADMIN => 'Frontier Market Admin',
            MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN => 'Frontier Market District Admin',
            MasterRole::ROLE_WADA_ADMIN => 'WADA Admin',
            MasterRole::ROLE_DBT_CALL_CENTER_MANAGER => 'DBT Call Center Manager',
            MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE => 'DBT Call Center Executive',
            MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN => 'Internal Call center Admin',
            MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE => 'Internal Call center executive',
            MasterRole::ROLE_BOCW_ADMIN => 'BOCW Admin',
            MasterRole::ROLE_BASIC_EDUCATION_ADMIN => 'Basic Education Admin',
            MasterRole::ROLE_AGRICULTURE_ADMIN => 'Agriculture Admin',
            MasterRole::ROLE_AGRICULTURE_DEO => 'Agriculture DEO',
            MasterRole::ROLE_ULTRA_POOR_VIEWER => 'ULTRA-POOR VIEWER',
            MasterRole::ROLE_RBI => 'RBI User',
            MasterRole::ROLE_RD_ADMIN => 'RD Admin',
            MasterRole::ROLE_RD_HOUSING_ADMIN => 'RD Housing Admin',
            MasterRole::ROLE_PANCHAYATI_RAJ_SBM_G => 'Panchayati Raj SBM-G',
            MasterRole::ROLE_WOMEN_WELFARE_ADMIN => 'Women Welfare Admin',
            MasterRole::ROLE_FOOD_CIVIL_SUPPLIES_ADMIN => 'Food & Civil Supplies Admin',
            MasterRole::ROLE_NAMAMI_GANGE_ADMIN => 'Namami Gange Admin',
            MasterRole::ROLE_MEDICAL_HEALTH_ADMIN => 'Medical Health Admin',
            MasterRole::ROLE_MSC => 'MSC',
        ]; // [UserModel::ROLE_GPA => 'Gram Panchayat Adhikari', UserModel::ROLE_GPS => 'Gram Panchayat Sachiv'];
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['created_at', 'created_by'], 'safe'],
            [['name'], 'required', 'message' => 'Is requred'],
            [['name'], 'trim'],
            [['mobile_no'], 'required', 'message' => 'Is requred'],
            [['mobile_no', 'username'], \common\validators\MobileNoValidator::className()],
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Is required'],
            ['username', 'match', 'pattern' => static::$usernameRegexp],
            ['username', 'string', 'min' => 3, 'max' => 255],
            // email rules
            ['email', 'trim'],
            ['email', 'required', 'message' => 'Is required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['username'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->user_model->$attribute != $model->$attribute;
                }, 'targetClass' => User::className(), 'message' => 'This login has already been taken', 'targetAttribute' => 'username'],
            [['email'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->user_model->$attribute != $model->$attribute;
                }, 'targetClass' => User::className(), 'message' => 'This email has already been taken', 'targetAttribute' => 'email'],
            // password rules
            ['password', 'required', 'message' => 'Is required'],
            ['password', 'string', 'min' => 6, 'max' => 72],
            [['status'], 'default', 'value' => 10],
            [['role',], 'required', 'message' => 'Is requred'],
            ['profile_status', 'safe'],
            ['profile_status', 'default', 'value' => 1],
            ['login_by_otp', 'default', 'value' => 1],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Login',
            'password' => 'Password',
            'email' => 'Email',
            'role' => 'Role',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }
        if ($this->user_model->isNewRecord) {
            if (in_array($this->role, [MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $this->profile_status = 0;
                $this->login_by_otp = 2;
            }
            if (in_array($this->role, [MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU])) {
                $this->profile_status = 0;
            }
        }
        $this->user_model->name = $this->name;
        $this->user_model->mobile_no = $this->mobile_no;
        $this->user_model->username = $this->username;
        $this->user_model->role = $this->role;
        $this->user_model->email = $this->email;
        $this->user_model->password = $this->password;
        $this->user_model->setPassword($this->password);
        $this->user_model->setUpd($this->password);
        $this->user_model->status = User::STATUS_ACTIVE;
        $this->user_model->profile_status = $this->profile_status;
        $this->user_model->login_by_otp = $this->login_by_otp;
        if ($this->user_model->isNewRecord) {
            $this->user_model->action_type = 1;
        } else {
            $this->user_model->action_type = 2;
        }

        if ($this->user_model->save()) {
            return $this;
        }
    }
}
