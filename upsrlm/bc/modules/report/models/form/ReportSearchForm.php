<?php

namespace bc\modules\report\models\form;

use Yii;
use yii\base\Model;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use yii\helpers\ArrayHelper;

/**
 * ReportSearchFormfor report
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ReportSearchForm extends Model {

    public $division_code;
    public $district_code;
    public $sub_district_code;
    public $block_code;
    public $village_code;
    public $gram_panchayat_code;
    public $section_at;
    public $cast;
    public $age_group;
    public $reading_skills;
    public $phone_type;
    public $marital_status;
    public $already_group_member;
    public $start_date;
    public $end_date;
    public $created_by;
    public $status;
    public $training_status;
    public $change_type = "";
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $status_option = [];
    public $cast_option = [];
    public $age_group_option = [];
    public $reading_skills_option = [];
    public $phone_type_option = [];
    public $marital_status_option = [];
    public $already_group_member_option = [1 => 'No', 2 => 'Chair person', 5 => 'Samuh Sakhi', 14 => 'Any other '];
    public $highest_score_in_gp_option = [];
    public $report_type = 1;
    public $highest_score_in_gp;
    public $district_base_url = '/selection/data/application/report?DashboardSearchForm[district_code]';
    public $block_base_url = '/selection/data/application/report?DashboardSearchForm[block_code]';
    public $gp_base_url = '/selection/data/applicationss/report?DashboardSearchForm[gram_panchayat_code]';
    public $filter;
    public $col_view_temp;
    public $col_send_temp;
    public $am = '';
    public $graph_selection;
    public $member = [3, 4, 6, 7, 8, 9, 10, 11, 12, 13];
    public $singleapplication;
    public $custom_already_group_member;
    public $call1;
    public $bc_photo_status;
    public $bc_photo_option;
    public $view_temp_option;
    public $custom_member_column;
    public $assign_shg_status;
    public $bc_bank;
    public $shg_bank;
    public $pfms_maped_status;
    public $bc_shg_funds_status;
    public $pan_card_status;
    public $handheld_machine_status;
    public $bc_partner_bank_option = [];
    public $rseti_bank_option = [];
    public $rseti_bank;
    public $bc_partner_bank;
    public $master_partner_bank_id;
    public $aspirational;

    public function __construct($params) {

        $this->load($params);
        $this->cast_option = GenralModel::bccostoption();
        $this->age_group_option = GenralModel::bcagegrouptoption();
        $this->reading_skills_option = GenralModel::bcreadingskillsoption();
        $this->phone_type_option = GenralModel::bcphonetypeoption();
        $this->marital_status_option = GenralModel::bcmaritalstatusoption();
        $this->already_group_member_option = GenralModel::bcalreadygroupmemberoption();
        $this->highest_score_in_gp_option = ['1' => "Highest Score", "0" => "Not higest Score"];
        $this->view_temp_option = ["viewtemp3" => "बीसी सखी : ऍप अपडेट", 'viewtemp1' => "बीसी सखी : शार्ट लिस्ट", "viewtemp2" => "बीसी सखी : स्टैंड बाई", "viewtemp5" => "बीसी सखी : शार्ट लिस्ट Info", "viewtemp7" => "बीसी सखी व समूह के बैंक अकाउंट संबंधित सूचना देने के विषय में", "viewtemp8" => "BC सखी के मोबाइल से सम्बंधित अति महत्वपूर्ण सूचना", "viewtemp9" => "बीसी सखी ऐप को अपडेट रखना", "viewtemp10" => "बैंक अकाउंट की जानकारी"];
        $this->bc_photo_option = ['0' => "तस्वीर मौजूद नहीं है", "1" => "तस्वीर मौजूद है"];
        if (Yii::$app->request->isAjax) {
            if (isset($params["DashboardSearchForm"]["change_type"]))
                $this->change_type = $params["DashboardSearchForm"]["change_type"];
        }
        $this->district_option = GenralModel::districtoption($this);

        $this->block_option = GenralModel::blockoption($this);
        if ($this->block_code) {
            $this->gp_option = GenralModel::gpoption($this);
        }
        if ($this->block_code or $this->gram_panchayat_code) {
            $this->village_option = GenralModel::villageoption($this);
        }
        if ($this->district_code) {
            $this->filter = '&DashboardSearchForm[district_code]=' . $this->district_code;
        }
        if ($this->block_code) {
            $this->filter .= '&DashboardSearchForm[block_code]=' . $this->block_code;
        }
        if ($this->cast) {
            $this->filter .= '&DashboardSearchForm[cast]=' . $this->cast;
        }
        if ($this->age_group) {
            $this->filter .= '&DashboardSearchForm[age_group]=' . $this->age_group;
        }
        if ($this->reading_skills) {
            $this->filter .= '&DashboardSearchForm[reading_skills]=' . $this->reading_skills;
        }
        if ($this->phone_type) {
            $this->filter .= '&DashboardSearchForm[phone_type]=' . $this->phone_type;
        }
        if ($this->marital_status) {
            $this->filter .= '&DashboardSearchForm[marital_status]=' . $this->marital_status;
        }
        if ($this->custom_already_group_member == 14) {
            $this->already_group_member = $this->member;
        } else {
            if ($this->custom_already_group_member) {
                $this->already_group_member = $this->custom_already_group_member;
            }
        }
        if ($this->custom_already_group_member and!is_array($this->custom_already_group_member)) {
            $this->filter .= '&DashboardSearchForm[custom_already_group_member]=' . $this->custom_already_group_member;
        }
        if ($this->highest_score_in_gp) {
            $this->filter .= '&DashboardSearchForm[highest_score_in_gp]=' . $this->highest_score_in_gp;
        }
//        $member = [];
//        if (isset($this->member) and is_array($this->member)) {
//            foreach ($this->member as $val) {
//                $this->am .= '&DashboardSearchForm[already_group_member][]=' . $val;
//            }
//        }
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['district_code', 'sub_district_code', 'block_code', 'village_code', 'gram_panchayat_code', 'section_at'], 'safe'],
            [['start_date', 'end_date', 'status', 'graph_selection', 'division_code'], 'safe'],
            [['age_group', 'cast', 'reading_skills', 'phone_type', 'marital_status', 'already_group_member', 'report_type', 'highest_score_in_gp', 'singleapplication', 'custom_already_group_member'], 'safe'],
            [['training_status'], 'safe'],
            [['call1'], 'safe'],
            [['col_view_temp', 'col_send_temp'], 'safe'],
            [['bc_photo_status'], 'safe'],
            [['custom_member_column'], 'safe'],
            [['assign_shg_status'], 'safe'],
            [['bc_bank'], 'safe'],
            [['shg_bank'], 'safe'],
            [['bc_shg_funds_status'], 'safe'],
            [['pfms_maped_status'], 'safe'],
            [['pan_card_status'], 'safe'],
            [['handheld_machine_status'], 'safe'],
            [['rseti_bank'], 'safe'],
            [['bc_partner_bank'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
            [['aspirational'], 'safe']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'division_code' => 'Division',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'village_code' => 'Village',
            'section_at' => 'Section At',
            'status' => 'Hhs Status',
            'age_group' => 'Age Group',
            'cast' => 'Social Category',
            'reading_skills' => 'Education / Functional skills',
            'phone_type' => 'Phone Type',
            'marital_status' => 'Marital Status',
            'already_group_member' => 'Group Member',
            'custom_already_group_member' => 'Group Member',
            'training_status' => 'Training status',
            'col_view_temp' => 'View notification message',
            'col_send_temp' => 'Send notification',
            'bc_photo_status' => 'Photo Status',
            'custom_member_column' => 'SHG Member (while applying)',
            'assign_shg_status' => 'BC-SHG Mapped',
            'pfms_maped_status' => 'PFMS Mapped',
            'bc_shg_funds_status' => 'BC SHG funds received',
            'pan_card_status' => 'PAN Card Status',
            'handheld_machine_status' => 'Handheld Machine provided',
            'master_partner_bank_id' => 'Partner agencies',
        ];
    }

}
