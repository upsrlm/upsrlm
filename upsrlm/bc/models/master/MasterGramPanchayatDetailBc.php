<?php

namespace bc\models\master;

use Yii;

/**
 * This is the model class for table "master_gram_panchayat_detail_bc".
 *
 * @property int $id
 * @property int $gram_panchayat_code
 * @property int $bc_selection_application_receive
 * @property int $selected_application_id
 * @property int $bc_selection_sc_st_application_receive
 * @property int $bc_selection_obc_application_receive
 * @property int $bc_selection_general_application_receive
 * @property int $group_member
 * @property int|null $selected_bc
 * @property int $selected_but_not_eligible
 * @property int $no_of_eligible_application
 * @property int|null $first_standby_id
 * @property int $standby2count
 * @property int|null $final_bc_id
 * @property int $eligible
 * @property int|null $gp_post_vacant
 * @property int|null $standby1_id
 * @property int|null $standby2_id
 * @property int|null $standby3_id
 * @property int|null $standby4_id
 * @property int $second_complete
 * @property int $second_vacant
 * @property int $third_complete
 * @property int $third_vacant
 * @property int $vacant_15dec
 * @property int $vacant_27dec
 * @property int $round1_no_application
 * @property int $round2_no_application
 * @property int $total_no_of_application
 * @property int $selected_bc_round1
 * @property int $selected_bc_round2
 * @property int $selected_bc_round3
 * @property int $selected_bc_round1_status
 * @property int $selected_bc_round2_status
 * @property int $selected_bc_round3_status
 * @property int $selected_bc_round4_status
 * @property int $issue
 * @property int $current_available
 * @property int|null $current_status

 */
class MasterGramPanchayatDetailBc extends \bc\modules\selection\models\BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_gram_panchayat_detail_bc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['gram_panchayat_code'], 'required'],
            [['gram_panchayat_code', 'bc_selection_application_receive', 'selected_application_id', 'bc_selection_sc_st_application_receive', 'bc_selection_obc_application_receive', 'bc_selection_general_application_receive', 'group_member', 'selected_bc', 'selected_but_not_eligible', 'no_of_eligible_application', 'first_standby_id', 'standby2count', 'final_bc_id', 'eligible', 'gp_post_vacant', 'standby1_id', 'standby2_id', 'standby3_id','standby4_id', 'second_complete', 'second_vacant', 'third_complete', 'third_vacant', 'vacant_15dec', 'vacant_27dec', 'round1_no_application', 'round2_no_application', 'total_no_of_application', 'selected_bc_round1', 'selected_bc_round2', 'selected_bc_round3', 'selected_bc_round1_status', 'selected_bc_round2_status', 'selected_bc_round3_status', 'selected_bc_round4_status', 'issue', 'current_available', 'current_status'], 'integer'],
            [['gram_panchayat_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'bc_selection_application_receive' => 'Bc Selection Application Receive',
            'selected_application_id' => 'Selected Application ID',
            'bc_selection_sc_st_application_receive' => 'Bc Selection Sc St Application Receive',
            'bc_selection_obc_application_receive' => 'Bc Selection Obc Application Receive',
            'bc_selection_general_application_receive' => 'Bc Selection General Application Receive',
            'group_member' => 'Group Member',
            'selected_bc' => 'Selected Bc',
            'selected_but_not_eligible' => 'Selected But Not Eligible',
            'no_of_eligible_application' => 'No Of Eligible Application',
            'first_standby_id' => 'First Standby ID',
            'standby2count' => 'Standby2count',
            'final_bc_id' => 'Final Bc ID',
            'eligible' => 'Eligible',
            'gp_post_vacant' => 'Gp Post Vacant',
            'standby1_id' => 'Standby1 ID',
            'standby2_id' => 'Standby2 ID',
            'standby3_id' => 'Standby3 ID',
            'second_complete' => 'Second Complete',
            'second_vacant' => 'Second Vacant',
            'third_complete' => 'Third Complete',
            'third_vacant' => 'Third Vacant',
            'vacant_15dec' => 'Vacant 15dec',
            'vacant_27dec' => 'Vacant 27dec',
            'round1_no_application' => 'Round1 No Application',
            'round2_no_application' => 'Round2 No Application',
            'total_no_of_application' => 'Total No Of Application',
            'selected_bc_round1' => 'Selected Bc Round1',
            'selected_bc_round2' => 'Selected Bc Round2',
            'selected_bc_round3' => 'Selected Bc Round3',
            'selected_bc_round1_status' => 'Selected Bc Round1 Status',
            'selected_bc_round2_status' => 'Selected Bc Round2 Status',
            'selected_bc_round3_status' => 'Selected Bc Round3 Status',
            'selected_bc_round4_status' => 'Selected Bc Round4 Status',
            'issue' => 'Issue',
            'current_available' => 'Current Available',
            'current_status' => 'Current Status',
            
        ];
    }
    public function getGp() {
        return $this->hasOne(\bc\models\master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }
}
