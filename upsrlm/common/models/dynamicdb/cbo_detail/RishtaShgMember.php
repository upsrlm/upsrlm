<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rishta_shg_member".
 *
 * @property int $id
 * @property int|null $cbo_shg_id
 * @property string $name
 * @property string|null $mobile
 * @property int|null $marital_status
 * @property int|null $age
 * @property int|null $caste_category
 * @property int|null $duration_of_membership
 * @property int|null $total_saving
 * @property int|null $loan
 * @property int|null $loan_count
 * @property string|null $loan_amount
 * @property string|null $loan_date
 * @property int|null $mcp_status
 * @property int|null $office_bearer
 * @property int|null $role
 * @property int|null $bank_account
 * @property int|null $relative_in_shg
 * @property int|null $no_of_relative
 * @property int|null $current_member
 * @property int|null $user_id
 * @property int $suggest_wada_sakhi
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 */
class RishtaShgMember extends CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rishta_shg_member';
    }

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
    public function rules() {
        return [
            [['cbo_shg_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'marital_status', 'age', 'caste_category', 'duration_of_membership', 'total_saving', 'loan', 'loan_count', 'mcp_status', 'office_bearer', 'role', 'bank_account', 'relative_in_shg', 'no_of_relative', 'current_member', 'user_id', 'suggest_wada_sakhi', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name', 'cbo_shg_id', 'mobile'], 'required'],
            [['loan_date'], 'safe'],
            [['name', 'loan_amount'], 'string', 'max' => 150],
            [['mobile'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'name' => 'Name',
            'mobile' => 'Mobile',
            'marital_status' => 'Marital Status',
            'age' => 'Age',
            'caste_category' => 'Caste Category',
            'duration_of_membership' => 'Duration Of Membership',
            'total_saving' => 'Total Saving',
            'loan' => 'Loan',
            'loan_count' => 'Loan Count',
            'loan_amount' => 'Loan Amount',
            'loan_date' => 'Loan Date',
            'mcp_status' => 'Mcp Status',
            'office_bearer' => 'Office Bearer',
            'role' => 'Role',
            'bank_account' => 'Bank Account',
            'relative_in_shg' => 'Relative In Shg',
            'no_of_relative' => 'No Of Relative',
            'current_member' => 'Current Member',
            'user_id' => 'User ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {

        if ($this->user_id) {
            $this->verified = 1;
        }
        if ($this->cbo_shg_id) {
            $shg_model = \cbo\models\Shg::findOne($this->cbo_shg_id);
            if ($shg_model != null) {
                $this->division_code = $shg_model->division_code;
                $this->district_code = $shg_model->district_code;
                $this->block_code = $shg_model->block_code;
                $this->gram_panchayat_code = $shg_model->gram_panchayat_code;
                $this->village_code = $shg_model->village_code;
            }
        }
        return parent::beforeSave($insert);
    }

    public function getUser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

    public function getUpdateby() {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getShgrole() {
        return $this->hasOne(master\CboMasterMemberDesignation::className(), ['id' => 'role']);
    }

    public function GetCtccount() {
        return $this->hasMany(\common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::className(), ['customernumber' => 'mobile'])->select(['id'])->where(['upsrlm_call_type' => 1]);
    }

    public function GetFirstcall() {
        $firstcall = \common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find()->where(['customernumber' => $this->mobile, 'upsrlm_call_type' => 1, 'upsrlm_call_status' => 10])->orderBy(['api_request_datetime' => SORT_ASC])->limit(1)->one();
        if ($firstcall) {
            return $firstcall->api_request_datetime;
        }
        return null;
    }

    public function GetLastcall() {
        $firstcall = \common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find()->where(['customernumber' => $this->mobile, 'upsrlm_call_type' => 1, 'upsrlm_call_status' => 10])->orderBy(['api_request_datetime' => SORT_DESC])->limit(1)->one();
        if ($firstcall) {
            return $firstcall->api_request_datetime;
        }
        return null;
    }

    public function GetIbdcount() {
        return $this->hasMany(\common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::className(), ['customernumber' => 'mobile'])->where(['upsrlm_call_type' => 2])->select(['id'])->count();
    }

    public function getShg() {
        return $this->hasOne(RishtaShg::className(), ['id' => 'cbo_shg_id']);
    }

    public function getCboshg() {
        return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_shg_id']);
    }

    public static function shgrolelist() {
        return ArrayHelper::map(master\CboMasterMemberDesignation::find()->where(['status' => 1, 'entity_type' => 1])->orderBy('role_hindi')->all(), 'id', 'role_hindi');
    }

    public function getMatch() {
        if ($this->suggest_wada_sakhi == 1) {
            $make_user = \common\models\CboMembers::find()->joinWith(['user'])->where([\common\models\CboMembers::getTableSchema()->fullName . '.cbo_type' => 1, \common\models\CboMembers::getTableSchema()->fullName . '.cbo_id' => $this->cbo_shg_id, \common\models\CboMembers::getTableSchema()->fullName . '.status' => 1, \common\models\CboMembers::getTableSchema()->fullName . '.suggest_wada_sakhi' => 1])->one();
            if (isset($make_user) and $make_user->user_id == $this->user_id) {
                return true;
            }
        } else {
            if ($this->role == 1) {
                $make_user = \common\models\CboMembers::find()->joinWith(['user'])->where([\common\models\CboMembers::getTableSchema()->fullName . '.cbo_type' => 1, \common\models\CboMembers::getTableSchema()->fullName . '.cbo_id' => $this->cbo_shg_id, \common\models\CboMembers::getTableSchema()->fullName . '.status' => 1, \common\models\CboMembers::getTableSchema()->fullName . '.shg_chairperson' => 1])->one();
                if (isset($make_user) and $make_user->user_id == $this->user_id) {
                    return true;
                }
            } elseif ($this->role == 2) {
                $make_user = \common\models\CboMembers::find()->joinWith(['user'])->where([\common\models\CboMembers::getTableSchema()->fullName . '.cbo_type' => 1, \common\models\CboMembers::getTableSchema()->fullName . '.cbo_id' => $this->cbo_shg_id, \common\models\CboMembers::getTableSchema()->fullName . '.status' => 1, \common\models\CboMembers::getTableSchema()->fullName . '.shg_secretary' => 1])->one();
                if (isset($make_user) and $make_user->user_id == $this->user_id) {
                    return true;
                }
            } elseif ($this->role == 3) {
                $make_user = \common\models\CboMembers::find()->joinWith(['user'])->where([\common\models\CboMembers::getTableSchema()->fullName . '.cbo_type' => 1, \common\models\CboMembers::getTableSchema()->fullName . '.cbo_id' => $this->cbo_shg_id, \common\models\CboMembers::getTableSchema()->fullName . '.status' => 1, \common\models\CboMembers::getTableSchema()->fullName . '.shg_treasurer' => 1])->one();
                if (isset($make_user) and $make_user->user_id == $this->user_id) {
                    return true;
                }
            } else {
                return false;
            }
        }

        return false;
    }

    public function getCallbutton() {
        $html = '';
        if ($this->suggest_wada_sakhi) {
            if (!$this->user->app_id) {
                $html .= \yii\helpers\Html::a('<i class="fal fa-phone"></i> कॉल करें', ['/platform/list/readytoconnect?rishta_shg_member_id=' . $this->id . '&scneario=1004'], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
            } else {
                $wada = \common\models\wada\WadaApplication::findOne(['user_id' => $this->user_id, 'cbo_shg_id' => $this->cbo_shg_id, 'status' => 2]);
                if ($wada == null) {
                    $html .= \yii\helpers\Html::a('<i class="fal fa-phone"></i> कॉल करें', ['/platform/list/readytoconnect?rishta_shg_member_id=' . $this->id . '&scneario=1005'], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                }
            }
        } else {
            if (in_array($this->role, [1, 2, 3])) {
                if ($this->user == null) {
                    if ($this->user == null) {
                        $html .= \yii\helpers\Html::a('<i class="fal fa-phone"></i> कॉल करें', ['/platform/list/readytoconnect?rishta_shg_member_id=' . $this->id . '&scneario=1001'], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                    } elseif (isset($this->user)) {
                        if (!$this->user->app_id) {
                            $html .= \yii\helpers\Html::a('<i class="fal fa-phone"></i> Ready to Connect', ['/platform/list/readytoconnect?rishta_shg_member_id=' . $this->id . '&scneario=1002'], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                        } else {
                            $sugest = RishtaShgMember::find()->where(['cbo_shg_id' => $this->cbo_shg_id, 'suggest_wada_sakhi' => 1])->count();
                            if ($sugest == '0') {
                                $html .= \yii\helpers\Html::a('<i class="fal fa-phone"></i>कॉल करें', ['/platform/list/readytoconnect?rishta_shg_member_id=' . $this->id . '&scneario=1003'], ['data-toggle' => "tooltip", 'data-pjax' => 0, 'class' => 'btn btn-info']);
                            }
                        }
                    }
                }
            }
        }
        return $html;
    }

    public function getCallstage() {
        $html = '';
        if ($this->suggest_wada_sakhi) {
            if (!$this->user->app_id) {
                $html .= 4;
            } else {
                $wada = \common\models\wada\WadaApplication::findOne(['user_id' => $this->user_id, 'cbo_shg_id' => $this->cbo_shg_id, 'status' => 2]);
                if ($wada == null) {
                    $html .= 5;
                }
            }
        } else {
            if (in_array($this->role, [1, 2, 3])) {
                if ($this->user == null) {
                    if ($this->user == null) {
                        $html .= 1;
                    } elseif (isset($this->user)) {
                        if (!$this->user->app_id) {
                            $html .= 2;
                        } else {
                            $sugest = RishtaShgMember::find()->where(['cbo_shg_id' => $this->cbo_shg_id, 'suggest_wada_sakhi' => 1])->count();
                            if ($sugest == '0') {
                                $html .= 3;
                            }
                        }
                    }
                }
            }
        }
        return $html;
    }

    public function getStage($s = null) {
        $html = '';
        if ($this->suggest_wada_sakhi) {
            if (!$this->user->app_id) {
                $html .= 'WSS अभ्यर्थी द्ववरा रिश्ता ऐप का उप्योग शेष';
            } else {
                $wada = \common\models\wada\WadaApplication::findOne(['user_id' => $this->user_id, 'cbo_shg_id' => $this->cbo_shg_id, 'status' => 2]);
                if ($wada == null) {
                    $html .= 'WSS अभ्यर्थी द्वारा फ़ॉर्म भरना शुरू करना शेष';
                }
            }
        } else {
            if (in_array($this->role, [1, 2, 3])) {
                if ($this->user == null) {
                    if ($this->user == null) {
                        $html .= 'SHG-CST यूज़र सत्यापन शेष ';
                    } elseif (isset($this->user)) {
                        if (!$this->user->app_id) {
                            $html .= 'SHG-CST द्ववरा रिश्ता ऐप का उप्योग शेष';
                        } else {
                            $sugest = RishtaShgMember::find()->where(['cbo_shg_id' => $this->cbo_shg_id, 'suggest_wada_sakhi' => 1])->count();
                            if ($sugest == '0') {
                                $html .= 'SHG-CST द्वारा WSS नामांकन शेष';
                            }
                        }
                    }
                }
            }
        }
        return $html;
    }

}
