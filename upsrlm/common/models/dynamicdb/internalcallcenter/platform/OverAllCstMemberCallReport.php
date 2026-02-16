<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "over_all_cst_member_call_report".
 *
 * @property int $id
 * @property int|null $no_of_cst_member_user
 * @property int|null $no_of_cst_member_mobile_no
 * @property int|null $no_of_cst_member_ctc
 * @property int|null $no_of_cst_member_shg
 * @property int|null $cst_connection_status0
 * @property int|null $cst_connection_status1
 * @property int $cst_connection_status21
 * @property int $cst_connection_status22
 * @property int $cst_connection_status23
 * @property int $cst_connection_status24
 * @property int|null $cst_connection_status30
 * @property int $cst_acallstatus0
 * @property int $cst_acallstatus3
 * @property int $cst_acallstatus6
 * @property int $cst_acallstatus7
 * @property int $cst_acallstatus10
 * @property int $cst_acallstatus11
 * @property int $cst_acallstatus13
 * @property int $no_of_cst_used_mobile_no
 * @property int $cst_acallstatus14
 * @property int $cst_acallstatus17
 * @property int|null $cst_call_status10
 * @property int|null $cst_call_status11
 * @property int $cst_call_status12
 * @property int $cst_call_status13
 * @property int|null $no_of_cst_used_app
 * @property int|null $no_of_cst_used_ctc
 * @property int|null $no_of_cst_used_shg
 * @property int $cst_used_connection_status0
 * @property int|null $cst_used_connection_status1
 * @property int $cst_used_connection_status21
 * @property int $cst_used_connection_status22
 * @property int $cst_used_connection_status23
 * @property int $cst_used_connection_status24
 * @property int|null $cst_used_connection_status30
 * @property int|null $cst_used_call_status10
 * @property int|null $cst_used_call_status11
 * @property int $cst_used_call_status12
 * @property int $cst_used_call_status13
 * @property int $cst_used_acallstatus0
 * @property int $cst_used_acallstatus3
 * @property int $cst_used_acallstatus6
 * @property int $cst_used_acallstatus7
 * @property int $cst_used_acallstatus10
 * @property int $cst_used_acallstatus11
 * @property int $cst_used_acallstatus13
 * @property int $cst_used_acallstatus14
 * @property int $cst_used_acallstatus17
 * @property string|null $last_updated_at
 */
class OverAllCstMemberCallReport extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'over_all_cst_member_call_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['no_of_cst_member_user', 'no_of_cst_member_mobile_no', 'no_of_cst_member_ctc', 'no_of_cst_member_shg', 'cst_connection_status0', 'cst_connection_status1', 'cst_connection_status21', 'cst_connection_status22', 'cst_connection_status23', 'cst_connection_status24', 'cst_connection_status30', 'cst_acallstatus0', 'cst_acallstatus3', 'cst_acallstatus6', 'cst_acallstatus7', 'cst_acallstatus10', 'cst_acallstatus11', 'cst_acallstatus13', 'no_of_cst_used_mobile_no', 'cst_acallstatus14', 'cst_acallstatus17', 'cst_call_status10', 'cst_call_status11', 'cst_call_status12', 'cst_call_status13', 'no_of_cst_used_app', 'no_of_cst_used_ctc', 'no_of_cst_used_shg', 'cst_used_connection_status0', 'cst_used_connection_status1', 'cst_used_connection_status21', 'cst_used_connection_status22', 'cst_used_connection_status23', 'cst_used_connection_status24', 'cst_used_connection_status30', 'cst_used_call_status10', 'cst_used_call_status11', 'cst_used_call_status12', 'cst_used_call_status13', 'cst_used_acallstatus0', 'cst_used_acallstatus3', 'cst_used_acallstatus6', 'cst_used_acallstatus7', 'cst_used_acallstatus10', 'cst_used_acallstatus11', 'cst_used_acallstatus13', 'cst_used_acallstatus14', 'cst_used_acallstatus17'], 'integer'],
            [['last_updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'no_of_cst_member_user' => 'No Of Cst Member User',
            'no_of_cst_member_mobile_no' => 'No Of Cst Member Mobile No',
            'no_of_cst_member_ctc' => 'No Of Cst Member Ctc',
            'no_of_cst_member_shg' => 'No Of Cst Member Shg',
            'cst_connection_status0' => 'Cst Connection Status0',
            'cst_connection_status1' => 'Cst Connection Status1',
            'cst_connection_status21' => 'Cst Connection Status21',
            'cst_connection_status22' => 'Cst Connection Status22',
            'cst_connection_status23' => 'Cst Connection Status23',
            'cst_connection_status24' => 'Cst Connection Status24',
            'cst_connection_status30' => 'Cst Connection Status30',
            'cst_acallstatus0' => 'Cst Acallstatus0',
            'cst_acallstatus3' => 'Cst Acallstatus3',
            'cst_acallstatus6' => 'Cst Acallstatus6',
            'cst_acallstatus7' => 'Cst Acallstatus7',
            'cst_acallstatus10' => 'Cst Acallstatus10',
            'cst_acallstatus11' => 'Cst Acallstatus11',
            'cst_acallstatus13' => 'Cst Acallstatus13',
            'no_of_cst_used_mobile_no' => 'No Of Cst Used Mobile No',
            'cst_acallstatus14' => 'Cst Acallstatus14',
            'cst_acallstatus17' => 'Cst Acallstatus17',
            'cst_call_status10' => 'Cst Call Status10',
            'cst_call_status11' => 'Cst Call Status11',
            'cst_call_status12' => 'Cst Call Status12',
            'cst_call_status13' => 'Cst Call Status13',
            'no_of_cst_used_app' => 'No Of Cst Used App',
            'no_of_cst_used_ctc' => 'No Of Cst Used Ctc',
            'no_of_cst_used_shg' => 'No Of Cst Used Shg',
            'cst_used_connection_status0' => 'Cst Used Connection Status0',
            'cst_used_connection_status1' => 'Cst Used Connection Status1',
            'cst_used_connection_status21' => 'Cst Used Connection Status21',
            'cst_used_connection_status22' => 'Cst Used Connection Status22',
            'cst_used_connection_status23' => 'Cst Used Connection Status23',
            'cst_used_connection_status24' => 'Cst Used Connection Status24',
            'cst_used_connection_status30' => 'Cst Used Connection Status30',
            'cst_used_call_status10' => 'Cst Used Call Status10',
            'cst_used_call_status11' => 'Cst Used Call Status11',
            'cst_used_call_status12' => 'Cst Used Call Status12',
            'cst_used_call_status13' => 'Cst Used Call Status13',
            'cst_used_acallstatus0' => 'Cst Used Acallstatus0',
            'cst_used_acallstatus3' => 'Cst Used Acallstatus3',
            'cst_used_acallstatus6' => 'Cst Used Acallstatus6',
            'cst_used_acallstatus7' => 'Cst Used Acallstatus7',
            'cst_used_acallstatus10' => 'Cst Used Acallstatus10',
            'cst_used_acallstatus11' => 'Cst Used Acallstatus11',
            'cst_used_acallstatus13' => 'Cst Used Acallstatu13',
            'cst_used_acallstatus14' => 'Cst Used Acallstatus14',
            'cst_used_acallstatus17' => 'Cst Used Acallstatus17',
            'last_updated_at' => 'Last Updated At',
        ];
    }

    public function beforeSave($insert) {

        $this->last_updated_at = new \yii\db\Expression('NOW()');

        return parent::beforeSave($insert);
    }

}
