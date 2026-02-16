<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "cbo_members".
 *
 * @property int $id
 * @property int $user_id
 * @property int $cbo_type
 * @property int $cbo_id
 * @property int|null $entry_type
 * @property int|null $role
 * @property int $shg_chairperson
 * @property int $shg_secretary
 * @property int $shg_treasurer
 * @property int $shg_member
 * @property int $vo_chairperson
 * @property int $vo_secretary
 * @property int $vo_treasurer
 * @property int $vo_member
 * @property int $clf_chairperson
 * @property int $clf_secretary
 * @property int $clf_treasurer
 * @property int $clf_member
 * @property int $bc_sakhi
 * @property int $samuh_sakhi
 * @property int $wada_sakhi
 * @property int $suggest_wada_sakhi
 * @property int $accountant
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $status
 */
class CboMembers extends CboDetailactiveRecord {

    const CBO_TYPE_SHG = 1;
    const CBO_TYPE_VO = 2;
    const CBO_TYPE_CLF = 3;
    const CBO_MEMBER_STATUS_DELETE = -1;
    const CBO_MEMBER_STATUS_NO_DECIDE = 0;
    const CBO_MEMBER_STATUS_CONFIRM = 1;

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
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
        return 'cbo_members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'cbo_type', 'cbo_id'], 'required'],
            [['user_id', 'cbo_type', 'cbo_id', 'entry_type', 'role', 'shg_chairperson', 'shg_secretary', 'shg_treasurer', 'shg_member', 'vo_chairperson', 'vo_secretary', 'vo_treasurer', 'vo_member', 'clf_chairperson', 'clf_secretary', 'clf_treasurer', 'clf_member', 'bc_sakhi', 'samuh_sakhi', 'wada_sakhi', 'suggest_wada_sakhi', 'accountant', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['cbo_id'], \common\validators\CheackcboroleValidator::className()],
            ['shg_chairperson', 'default', 'value' => 0],
            ['shg_secretary', 'default', 'value' => 0],
            ['shg_treasurer', 'default', 'value' => 0],
            ['shg_member', 'default', 'value' => 0],
            ['vo_chairperson', 'default', 'value' => 0],
            ['vo_secretary', 'default', 'value' => 0],
            ['vo_treasurer', 'default', 'value' => 0],
            ['vo_member', 'default', 'value' => 0],
            ['clf_chairperson', 'default', 'value' => 0],
            ['clf_secretary', 'default', 'value' => 0],
            ['clf_treasurer', 'default', 'value' => 0],
            ['clf_member', 'default', 'value' => 0],
            ['bc_sakhi', 'default', 'value' => 0],
            ['samuh_sakhi', 'default', 'value' => 0],
            ['wada_sakhi', 'default', 'value' => 0],
            ['suggest_wada_sakhi', 'default', 'value' => 0],
            ['accountant', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'cbo_type' => 'Cbo Type',
            'cbo_id' => 'Cbo ID',
            'entry_type' => 'Entry Type',
            'role' => 'Role',
            'shg_chairperson' => 'Shg Chairperson',
            'shg_secretary' => 'Shg Secretary',
            'shg_treasurer' => 'Shg Treasurer',
            'shg_member' => 'Shg Member',
            'vo_chairperson' => 'Vo Chairperson',
            'vo_secretary' => 'Vo Secretary',
            'vo_treasurer' => 'Vo Treasurer',
            'vo_member' => 'Vo Member',
            'clf_chairperson' => 'Clf Chairperson',
            'clf_secretary' => 'Clf Secretary',
            'clf_treasurer' => 'Clf Treasurer',
            'clf_member' => 'Clf Member',
            'bc_sakhi' => 'Bc Sakhi',
            'samuh_sakhi' => 'Samuh Sakhi',
            'wada_sakhi' => 'Wada Sakhi',
            'accountant' => 'Accountant',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getProfile() {
        return $this->hasOne(CboMemberProfile::className(), ['user_id' => 'user_id']);
    }
    public function getCbotype() {
        $type = [self::CBO_TYPE_SHG => 'SHG', self::CBO_TYPE_VO => 'VO', self::CBO_TYPE_CLF => 'CLF'];
        return isset($type[$this->cbo_type]) ? $type[$this->cbo_type] : '';
    }

    public function GetCtccount() {
        $ctc = \common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find()->select(['id'])->where(['customernumber' => $this->user->username, 'upsrlm_call_type' => 1])->count();
        return $ctc;
    }

    public function GetCccount() {
        $ctc = \common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find()->select(['id'])->where(['customernumber' => $this->user->username, 'upsrlm_call_type' => 1, 'upsrlm_call_status' => 10])->count();
        return $ctc;
    }

    public function GetFirstcall() {
        $firstcall = \common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find()->where(['customernumber' => $this->user->username, 'upsrlm_call_type' => 1,'upsrlm_call_status' => 10])->orderBy(['api_request_datetime' => SORT_ASC])->limit(1)->one();
        if ($firstcall) {
            return $firstcall->api_request_datetime;
        }
        return null;
    }

    public function GetLastcall() {
        $firstcall = \common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find()->where(['customernumber' => $this->user->username, 'upsrlm_call_type' => 1,'upsrlm_call_status' => 10])->orderBy(['api_request_datetime' => SORT_DESC])->limit(1)->one();
        if ($firstcall) {
            return $firstcall->api_request_datetime;
        }
        return null;
    }

    public function getCbo() {
        if ($this->cbo_type == self::CBO_TYPE_SHG) {
            return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_id'])->joinWith(['gp']);
        }
        if ($this->cbo_type == self::CBO_TYPE_VO) {
            return $this->hasOne(\cbo\models\CboVo::className(), ['id' => 'cbo_id']);
        }
        if ($this->cbo_type == self::CBO_TYPE_CLF) {
            return $this->hasOne(\cbo\models\CboClf::className(), ['id' => 'cbo_id']);
        }
    }

    public function getShg() {
        return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_id'])->joinWith(['gp']);
    }

    public function getShgmember() {
        return $this->hasOne(RishtaShgMember::className(), ['cbo_shg_id' => 'cbo_id', 'user_id' => 'user_id'])->andWhere(['mobile' => $this->user->username]);
    }

    public function getSamuh() {
        return $this->hasOne(\common\models\wada\WadaApplication::className(), ['user_id' => 'user_id', 'cbo_shg_id' => 'cbo_id']);
    }
    public function getShgrole() {
        return $this->hasOne(master\CboMasterMemberDesignation::className(), ['id' => 'role']);
    }
    public function getFormstatus() {
        if ($this->samuh == null) {
            return 'शुरू नहीं किया गया';
        } else {
            if ($this->samuh->form_number == null) {
                return 'शुरू नहीं किया गया';
            } else {
                $a = [
                    null => 'शुरू नहीं किया गय',
                    0 => 'शुरू नहीं किया गय',
                    1 => 'Section 1 : बेसिक सूचना',
                    2 => 'Section 2 : Mobility',
                    3 => 'Section 3 : टेक्नॉलजी पारंगतता',
                    4 => 'Section 4 : नेतृत्व',
                    5 => 'Section 5 : मल्टी-सेक्टर सेवाओं के बारे में जानकारी',
                    6 => 'Section 6',
                ];
                $status = '';
                if ($this->samuh->form_number == 6) {
                    if ($this->samuh->status == 1) {
                        $status = ' Save mode';
                    }
                    if ($this->samuh->status == 2) {
                        $status = ' Submit';
                    }
                }
                return isset($a[$this->samuh->form_number])? $a[$this->samuh->form_number] . $status:'शुरू नहीं किया गया';
            }
        }
    }

    public function getStage($s = null) {
        $phase = '';

        if (!$this->user->app_id) {
            $phase = 'Rishta App not used';
        }
        if ($s != 1002) {
            if ($this->user->app_id) {
                $phase = 'Rishta App used';
            }
        }
        $nominate = RishtaShgMember::find()->select(['id'])->where(['cbo_shg_id' => $this->cbo_id, 'suggest_wada_sakhi' => 1])->count();
        if ($nominate) {
            $phase .= '<br/>Samuh Sakhi Nominated';
        } else {
            $phase .= '<br/>Samuh Sakhi Not Nominated';
        }   
        return $phase;
    }
    public function getCallbutton(){
        
    }

}
