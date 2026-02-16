<?php

namespace common\models\form;

use yii;
use common\models\User;
use yii\base\Model;
use yii\base\NotSupportedException;
use common\models\master\MasterRole;

//use common\models\RelationUserBdoBlock;
//use common\models\dynamicdb\bc\RelationUserBdoBlock;
//use common\models\RelationUserDistrict;
//use common\models\dynamicdb\bc\RelationUserDistrict;
//use common\models\RelationUserDivision;
//use common\models\dynamicdb\bc\RelationUserDivision;

/**
 * ChangeRoleForm gets user's password,currentpassword,re_password and changes them.
 *
 * @property User $user
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ChangeRoleForm extends Model {

    public $role;
    public $old_role;

    /** @var Module */
    protected $module;

    /** @var Mailer */
    protected $mailer;

    /** @var User */
    private $_user;
    public $user;
    public $role_option;

    /** @inheritdoc */
    public function __construct($user) {
        $this->user = $user;
        $this->old_role = $this->user->role;
        $this->role_option = [
            MasterRole::ROLE_ADO => 'ADO-P',
            MasterRole::ROLE_AGRICULTURE_DISTRICT => 'Agriculture (District Level)',
            MasterRole::ROLE_DISABILITY_STATE_LEVEL => 'Disability (State Level)',
            MasterRole::ROLE_DISABILITY_DISTRICT_LEVEL => 'Disability (District Level)',
            MasterRole::ROLE_HR_ADMIN => 'HR Admin',
            MasterRole::ROLE_CDO => 'Chief Development Officer',
            MasterRole::ROLE_CM_HELPLINE => 'CM Helpline',
            MasterRole::ROLE_CM_HELPLINE_MANAGER => 'CM Helpline Manager',
            MasterRole::ROLE_DPRO => 'DPRO',
            MasterRole::ROLE_DIRECTOR_ULB => 'Director ULB',
            MasterRole::ROLE_DIRECTOR_RURAL_DD => 'Director Rural Development Department',
            MasterRole::ROLE_DM => 'District Magistrate',
            MasterRole::ROLE_DC_NRLM => 'DC NRLM',
            MasterRole::ROLE_DSO => 'District Supply Officer',
            MasterRole::ROLE_DIVISIONAL_COMMISSIONER => 'Divisional Commissioner ',
            MasterRole::ROLE_BDO => 'Block Development Officer',
            MasterRole::ROLE_SPM_FI_MF => 'SPM FI & MF',
            MasterRole::ROLE_SPM_FINANCE => 'SPM Finance',
            MasterRole::ROLE_PANCHAYATI_RAJ => 'Panchayati Raj',
            MasterRole::ROLE_PCI_ADMIN => 'PCI Admin',
            MasterRole::ROLE_PCI_USER => 'PCI User',
            MasterRole::ROLE_BACKEND_OPERATOR => 'Backend Operator',
            MasterRole::ROLE_BMMU => 'BMMU',
            MasterRole::ROLE_DMMU => 'DMMU',
            MasterRole::ROLE_SMMU => 'SMMU',
            MasterRole::ROLE_JMD => 'JMD',
            MasterRole::ROLE_SUPPORT_UNIT => 'Support Unit',
            MasterRole::ROLE_DBT_CALL_CENTER_MANAGER => 'DBT Call Center Manager',
            MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE => 'DBT Call Center Executive',
            MasterRole::ROLE_YOUNG_PROFESSIONAL => 'Young Proffssional',
            MasterRole::ROLE_RSETIS_STATE_UNIT => 'RSETIs State Unit',
            MasterRole::ROLE_RSETIS_DISTRICT_UNIT => 'RSETIs District Unit',
            MasterRole::ROLE_RSETIS_BATCH_CREATOR => 'RSETIs Batch creator',
            MasterRole::ROLE_RSETIS_NODAL_BANK => 'RSETIs Nodal Bank',
            MasterRole::ROLE_UPSDM_STATE => 'Skill Development Mission (State Level)',
            MasterRole::ROLE_UPSDM_DISTRICT => 'Skill Development Mission (District Level)',
            MasterRole::ROLE_UPSRLM_RSETI_ANCHOR => 'UPSRLM- RSETI anchor',
            MasterRole::ROLE_BANK_DISTRICT_UNIT => 'Bank/FI Partner',
            MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL => 'Bank/FI Partner District Nodal',
            MasterRole::ROLE_SBMG => 'SBM-G',
            MasterRole::ROLE_DIVISION_DISTRICT_DIRECTOR => 'Division District Director',
            MasterRole::ROLE_ZERO_POVERTY_INTERNAL_VIEWER => 'Zero Poverty Viewer',
            MasterRole::ROLE_PD => 'Project Directors',
            MasterRole::ROLE_WOMEN_WELFARE_DISTRICT_LEVEL => 'Women Welfare (District Level)',
            MasterRole::ROLE_WOMEN_WELFARE_ADMIN => 'Women Welfare (State Level)',
            MasterRole::ROLE_MSC => 'MSC',
            MasterRole::ROLE_LABOUR_STATE_LEVEL => 'Labour (State Level)',
        ];
    }

    /** @inheritdoc */
    public function rules() {
        return [
            [['role'], 'required'],
            ['role', 'compare', 'compareAttribute' => 'old_role', 'operator' => '!=', 'message' => 'Please choose a different role'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'role' => 'Role',
        ];
    }

    /** @inheritdoc */
    public function formName() {
        return 'reset-role-form';
    }

    /**
     * Saves new account settings.
     *
     * @return bool
     */
    public function save() {
        if ($this->validate()) {
            $this->user->role = $this->role;
            $this->user->action_type = 2;
            if ($this->user->save()) {
                $condition = ['and',
                    ['=', 'user_id', $this->user->id,],
                ];
                if (in_array($this->old_role, [MasterRole::ROLE_GP_SAACHIV, MasterRole::ROLE_GP_ADHIKARI, MasterRole::ROLE_GRAM_PARDHAN, MasterRole::ROLE_GP_SAHAYAK, MasterRole::ROLE_GP_SAFAI_KARMI])) {

                    \common\models\RelationUserGramPanchayat::updateAll([
                        'status' => '-1',
                            ], $condition);
                    \common\models\dynamicdb\bc\RelationUserGramPanchayat::updateAll([
                        'status' => '-1',
                            ], $condition);
                }
                if (in_array($this->old_role, [MasterRole::ROLE_BMMU, MasterRole::ROLE_BDO, MasterRole::ROLE_ADO, MasterRole::ROLE_BDO_SUPPORTER])) {

                    \common\models\RelationUserBdoBlock::updateAll([
                        'status' => '-1',
                            ], $condition);
                    \common\models\dynamicdb\bc\RelationUserBdoBlock::updateAll([
                        'status' => '-1',
                            ], $condition);
                }
                if (in_array($this->old_role, [MasterRole::ROLE_DM, MasterRole::ROLE_DSO, MasterRole::ROLE_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_CDO, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_DMMU, MasterRole::ROLE_DPM, MasterRole::ROLE_DPRO])) {
                    \common\models\RelationUserDistrict::updateAll([
                        'status' => '-1',
                            ], $condition);
                    \common\models\dynamicdb\bc\RelationUserDistrict::updateAll([
                        'status' => '-1',
                            ], $condition);
                }
                if (in_array($this->old_role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                    \common\models\RelationUserDivision::updateAll([
                        'status' => '-1',
                            ], $condition);
                    \common\models\dynamicdb\bc\RelationUserDivision::updateAll([
                        'status' => '-1',
                            ], $condition);
                }
                return $this->user;
            }

            return false;
        }
    }
}
