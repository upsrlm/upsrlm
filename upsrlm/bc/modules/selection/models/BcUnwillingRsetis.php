<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_unwilling_rsetis".
 *
 * @property int $id
 * @property int $bc_application_id
 * @property int $bc_selection_user_id
 * @property int $entry_type
 * @property int $unwilling_reason1
 * @property int $unwilling_reason2
 * @property int $unwilling_reason3
 * @property int $unwilling_reason4
 * @property int $unwilling_reason5
 * @property int $unwilling_reason6
 * @property int $unwilling_reason7
 * @property int $unwilling_reason8
 * @property int $unwilling_reason9
 * @property int $unwilling_reason10
 * @property int $unwilling_reason11
 * @property int $unwilling_reason12
 * @property int $unwilling_reason13
 * @property int $unwilling_reason14
 * @property int $unwilling_reason15
 * @property int $unwilling_reason16
 * @property int $unwilling_reason17
 * @property int $unwilling_reason18
 * @property int $unwilling_reason19
 * @property int $unwilling_reason20
 * @property int $unwilling_reason21
 * @property string|null $unwilling_reason7_text
 * @property int|null $entry_by
 * @property string|null $entry_date
 * @property int $is_pvr
 * @property int $is_shg_assign
 * @property int $is_bc_shg_bank
 * @property int $is_pfms_mapping
 * @property int $is_support_fund_shg
 * @property int $is_onboarding
 * @property int $is_handheld_machine
 * @property int $is_bc_operational
 * @property int $is_bc_receive_support_fund
 * @property int $funds_returned_to_shg
 * @property string|null $return_date_of_support_fund
 * @property string|null $support_fund_responsible_name
 * @property string|null $support_fund_responsible_mobile_no
 * @property int $bc_unwilling
 * @property int $bc_unwilling_reason13
 * @property int $bc_unwilling_reason14
 * @property int $bc_unwilling_reason15
 * @property int $bc_unwilling_reason16
 * @property int $bc_unwilling_reason17
 * @property int $bc_unwilling_reason18
 * @property int $bc_unwilling_reason19
 * @property int $bc_unwilling_reason20
 * @property int $bc_unwilling_reason21
 * @property int|null $bc_entry_by
 * @property string|null $bc_entry_date
 * @property int $cdo_unwilling_reason13
 * @property int $cdo_unwilling_reason14
 * @property int $cdo_unwilling_reason15
 * @property int $cdo_unwilling_reason16
 * @property int $cdo_unwilling_reason17
 * @property int $cdo_unwilling_reason18
 * @property int $cdo_unwilling_reason19
 * @property int $cdo_unwilling_reason20
 * @property int $cdo_unwilling_reason21
 * @property int|null $cdo_entry_by
 * @property string|null $cdo_entry_date
 * @property int $upsrlm_unwilling_reason13
 * @property int $upsrlm_unwilling_reason14
 * @property int $upsrlm_unwilling_reason15
 * @property int $upsrlm_unwilling_reason16
 * @property int $upsrlm_unwilling_reason17
 * @property int $upsrlm_unwilling_reason18
 * @property int $upsrlm_unwilling_reason19
 * @property int $upsrlm_unwilling_reason20
 * @property int $upsrlm_unwilling_reason21
 * @property int|null $upsrlm_entry_by
 * @property string|null $upsrlm_entry_date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcUnwillingRsetis extends BcactiveRecord {

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
        return 'bc_unwilling_rsetis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'bc_selection_user_id'], 'required'],
            [['bc_application_id', 'bc_selection_user_id', 'unwilling_reason1', 'unwilling_reason2', 'unwilling_reason3', 'unwilling_reason4', 'unwilling_reason5', 'unwilling_reason6', 'unwilling_reason7', 'entry_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['unwilling_reason8', 'unwilling_reason9', 'unwilling_reason10', 'unwilling_reason11', 'unwilling_reason12'], 'integer'],
            [['unwilling_reason13', 'unwilling_reason14', 'unwilling_reason15', 'unwilling_reason16', 'unwilling_reason17', 'unwilling_reason18', 'unwilling_reason19', 'unwilling_reason20'], 'integer'],
            [['is_pvr', 'is_shg_assign', 'is_bc_shg_bank', 'is_pfms_mapping', 'is_support_fund_shg', 'is_onboarding', 'is_handheld_machine', 'is_bc_operational', 'is_bc_receive_support_fund', 'funds_returned_to_shg'], 'integer'],
            [['entry_date'], 'safe'],
            [['entry_type'], 'integer'],
            [['unwilling_reason7_text'], 'string', 'max' => 500],
            [['return_date_of_support_fund'], 'safe'],
            [['support_fund_responsible_name'], 'string', 'max' => 255],
            [['support_fund_responsible_mobile_no'], 'string', 'max' => 15],
            [['unwilling_reason21', 'bc_unwilling', 'bc_unwilling_reason13', 'bc_unwilling_reason14', 'bc_unwilling_reason15', 'bc_unwilling_reason16', 'bc_unwilling_reason17', 'bc_unwilling_reason18', 'bc_unwilling_reason19', 'bc_unwilling_reason20', 'bc_unwilling_reason21', 'bc_entry_by', 'cdo_unwilling_reason13', 'cdo_unwilling_reason14', 'cdo_unwilling_reason15', 'cdo_unwilling_reason16', 'cdo_unwilling_reason17', 'cdo_unwilling_reason18', 'cdo_unwilling_reason19', 'cdo_unwilling_reason20', 'cdo_unwilling_reason21', 'cdo_entry_by', 'upsrlm_unwilling_reason13', 'upsrlm_unwilling_reason14', 'upsrlm_unwilling_reason15', 'upsrlm_unwilling_reason16', 'upsrlm_unwilling_reason17', 'upsrlm_unwilling_reason18', 'upsrlm_unwilling_reason19', 'upsrlm_unwilling_reason20', 'upsrlm_unwilling_reason21', 'upsrlm_entry_by'], 'integer'],
            [['bc_entry_date', 'cdo_entry_date', 'upsrlm_entry_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Application ID',
            'bc_selection_user_id' => 'Bc Selection User ID',
            'unwilling_reason1' => 'Unwilling Reason1',
            'unwilling_reason2' => 'Unwilling Reason2',
            'unwilling_reason3' => 'Unwilling Reason3',
            'unwilling_reason4' => 'Unwilling Reason4',
            'unwilling_reason5' => 'Unwilling Reason5',
            'unwilling_reason6' => 'Unwilling Reason6',
            'unwilling_reason7' => 'Unwilling Reason7',
            'unwilling_reason7_text' => 'Unwilling Reason7 Text',
            'is_pvr' => 'पीवीआर',
            'is_shg_assign' => 'बीसी-एसएचजी लिंक',
            'is_bc_shg_bank' => 'बीसी-एसएचजी बैंक खाता सत्यापित',
            'is_pfms_mapping' => 'पीएफएमएस मैपिंग',
            'is_support_fund_shg' => 'बीसी-सहायता निधि (एसएचजी)',
            'is_handheld_machine' => 'हैंडहेल्ड मशीन उपलब्ध करायी गयी',
            'is_onboarding' => 'ऑनबोर्डिंग',
            'is_bc_operational' => 'क्या बीसी ऑपरेशनल हैं/ थीं',
            'is_bc_receive_support_fund' => 'क्या बीसी सखी ने बीसी सपोर्ट फण्ड प्राप्त किया है',
            'funds_returned_to_shg' => 'क्या फण्ड की वापसी assigned SHG में की गई है?',
            'return_date_of_support_fund' => 'किस तारीख़ तक वापस करेंगे, संकेत करें',
            'support_fund_responsible_name' => 'बीसी सपोर्ट फण्ड वापसी के लिए ज़िम्मेदार अधिकारी/ प्रोफेशनल का नाम',
            'support_fund_responsible_mobile_no' => 'बीसी सपोर्ट फण्ड वापसी के लिए ज़िम्मेदार अधिकारी/ प्रोफेशनल का मोबाइल नंबर',
            'entry_by' => 'Entry By',
            'entry_date' => 'Entry Date',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getRsby() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'entry_by']);
    }

    public function getBankby() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'entry_by']);
    }

    public function getBcby() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'bc_entry_by']);
    }

    public function getCdoby() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'cdo_entry_by']);
    }

    public function getUpsrlmby() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'upsrlm_entry_by']);
    }

    public function getBanks() {
        return ($this->unwilling_reason1 + $this->unwilling_reason2 + $this->unwilling_reason3 + $this->unwilling_reason4 + $this->unwilling_reason5 + $this->unwilling_reason6 + $this->unwilling_reason7 + $this->unwilling_reason13 + $this->unwilling_reason14 + $this->unwilling_reason15 + $this->unwilling_reason16 + $this->unwilling_reason17 + $this->unwilling_reason18 + $this->unwilling_reason19 + $this->unwilling_reason20 + $this->unwilling_reason21);
    }

    public function getBcs() {
        return ($this->bc_unwilling_reason13 + $this->bc_unwilling_reason14 + $this->bc_unwilling_reason15 + $this->bc_unwilling_reason16 + $this->bc_unwilling_reason17 + $this->bc_unwilling_reason18 + $this->bc_unwilling_reason19 + $this->bc_unwilling_reason20 + $this->bc_unwilling_reason21);
    }

    public function getCdos() {
        return ($this->cdo_unwilling_reason13 + $this->cdo_unwilling_reason14 + $this->cdo_unwilling_reason15 + $this->cdo_unwilling_reason16 + $this->cdo_unwilling_reason17 + $this->cdo_unwilling_reason18 + $this->cdo_unwilling_reason19 + $this->cdo_unwilling_reason20 + $this->cdo_unwilling_reason21);
    }

    public function getUpsrlms() {
        return ($this->upsrlm_unwilling_reason13 + $this->upsrlm_unwilling_reason14 + $this->upsrlm_unwilling_reason15 + $this->upsrlm_unwilling_reason16 + $this->upsrlm_unwilling_reason17 + $this->upsrlm_unwilling_reason18 + $this->upsrlm_unwilling_reason19 + $this->upsrlm_unwilling_reason20 + $this->upsrlm_unwilling_reason21);
    }

    public function getRsethiunwilling() {
        $html = '';
        if ($this->entry_type == 1) {
            $html .= '<ul>';
            if ($this->unwilling_reason1 == 1) {
                $html .= '<li>';
                $html .= base\GenralModel::unwilling_reason_rsethis_option()[1];
                $html .= '</li>';
            }
            if ($this->unwilling_reason2 == 1) {
                $html .= '<li>';
                $html .= base\GenralModel::unwilling_reason_rsethis_option()[2];
                $html .= '</li>';
            }
            if ($this->unwilling_reason3 == 1) {
                $html .= '<li>';
                $html .= base\GenralModel::unwilling_reason_rsethis_option()[3];
                $html .= '</li>';
            }
            if ($this->unwilling_reason4 == 1) {
                $html .= '<li>';
                $html .= base\GenralModel::unwilling_reason_rsethis_option()[4];
                $html .= '</li>';
            }
            if ($this->unwilling_reason5 == 1) {
                $html .= '<li>';
                $html .= base\GenralModel::unwilling_reason_rsethis_option()[5];
                $html .= '</li>';
            }
            if ($this->unwilling_reason6 == 1) {
                $html .= '<li>';
                $html .= base\GenralModel::unwilling_reason_rsethis_option()[6];
                $html .= '</li>';
            }
            if ($this->unwilling_reason7 == 1) {
                $html .= '<li>';
                $html .= $this->unwilling_reason7_text;
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getBankunwilling() {
        $html = '';
        if ($this->entry_type == 2) {
            if ($this->banks) {
                $html .= '<ul>';
                if ($this->unwilling_reason13 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bank_option_new()[13];
                    $html .= '</li>';
                }
                if ($this->unwilling_reason14 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bank_option_new()[14];
                    $html .= '</li>';
                }
                if ($this->unwilling_reason15 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bank_option_new()[15];
                    $html .= '</li>';
                }
                if ($this->unwilling_reason16 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bank_option_new()[16];
                    $html .= '</li>';
                }
                if ($this->unwilling_reason17 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bank_option_new()[17];
                    $html .= '</li>';
                }
                if ($this->unwilling_reason18 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bank_option_new()[18];
                    $html .= '</li>';
                }
                if ($this->unwilling_reason19 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bank_option_new()[19];
                    $html .= '</li>';
                }
                if ($this->unwilling_reason20 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bank_option_new()[20];
                    $html .= '</li>';
                }
                if ($this->unwilling_reason21 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bank_option_new()[21];
                    $html .= '</li>';
                }
                $html .= '</ul>';
            }
        }
        return $html;
    }

    public function getBcunwilling() {
        $html = '';
        if ($this->entry_type == 2) {
            if ($this->bcs) {
                $html .= '<ul>';
                if ($this->bc_unwilling_reason13 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bc_option_new()[13];
                    $html .= '</li>';
                }
                if ($this->bc_unwilling_reason14 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bc_option_new()[14];
                    $html .= '</li>';
                }
                if ($this->bc_unwilling_reason15 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bc_option_new()[15];
                    $html .= '</li>';
                }
                if ($this->bc_unwilling_reason16 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bc_option_new()[16];
                    $html .= '</li>';
                }
                if ($this->bc_unwilling_reason17 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bc_option_new()[17];
                    $html .= '</li>';
                }
                if ($this->bc_unwilling_reason18 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bc_option_new()[18];
                    $html .= '</li>';
                }
                if ($this->bc_unwilling_reason19 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bc_option_new()[19];
                    $html .= '</li>';
                }
                if ($this->bc_unwilling_reason20 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bc_option_new()[20];
                    $html .= '</li>';
                }
                if ($this->bc_unwilling_reason21 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_bc_option_new()[21];
                    $html .= '</li>';
                }
                $html .= '</ul>';
            }
        }
        return $html;
    }

    public function getCdounwilling() {
        $html = '';
        if ($this->entry_type == 2) {
            if ($this->cdos) {
                $html .= '<ul>';
                if ($this->cdo_unwilling_reason13 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_cdo_option_new()[13];
                    $html .= '</li>';
                }
                if ($this->cdo_unwilling_reason14 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_cdo_option_new()[14];
                    $html .= '</li>';
                }
                if ($this->cdo_unwilling_reason15 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_cdo_option_new()[15];
                    $html .= '</li>';
                }
                if ($this->cdo_unwilling_reason16 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_cdo_option_new()[16];
                    $html .= '</li>';
                }
                if ($this->cdo_unwilling_reason17 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_cdo_option_new()[17];
                    $html .= '</li>';
                }
                if ($this->cdo_unwilling_reason18 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_cdo_option_new()[18];
                    $html .= '</li>';
                }
                if ($this->cdo_unwilling_reason19 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_cdo_option_new()[19];
                    $html .= '</li>';
                }
                if ($this->cdo_unwilling_reason20 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_cdo_option_new()[20];
                    $html .= '</li>';
                }
                if ($this->cdo_unwilling_reason21 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_cdo_option_new()[21];
                    $html .= '</li>';
                }
                $html .= '</ul>';
            }
        }
        return $html;
    }

    public function getUpsrlmunwilling() {
        $html = '';
        if ($this->entry_type == 2) {
            if ($this->upsrlms) {
                $html .= '<ul>';
                if ($this->upsrlm_unwilling_reason13 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_upsrlm_option_new()[13];
                    $html .= '</li>';
                }
                if ($this->upsrlm_unwilling_reason14 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_upsrlm_option_new()[14];
                    $html .= '</li>';
                }
                if ($this->upsrlm_unwilling_reason15 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_upsrlm_option_new()[15];
                    $html .= '</li>';
                }
                if ($this->upsrlm_unwilling_reason16 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_upsrlm_option_new()[16];
                    $html .= '</li>';
                }
                if ($this->upsrlm_unwilling_reason17 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_upsrlm_option_new()[17];
                    $html .= '</li>';
                }
                if ($this->upsrlm_unwilling_reason18 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_upsrlm_option_new()[18];
                    $html .= '</li>';
                }
                if ($this->upsrlm_unwilling_reason19 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_upsrlm_option_new()[19];
                    $html .= '</li>';
                }
                if ($this->upsrlm_unwilling_reason20 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_upsrlm_option_new()[20];
                    $html .= '</li>';
                }
                if ($this->upsrlm_unwilling_reason21 == 1) {
                    $html .= '<li>';
                    $html .= base\GenralModel::unwilling_reason_upsrlm_option_new()[21];
                    $html .= '</li>';
                }
                $html .= '</ul>';
            }
        }

        return $html;
    }

    public function getPvr() {
        $array = [0 => '', 1 => 'हाँ', 2 => 'नहीं'];
        return isset($array[$this->is_pvr]) ? $array[$this->is_pvr] : '';
    }

    public function getShgassign() {
        $array = [0 => '', 1 => 'हाँ', 2 => 'नहीं'];
        return isset($array[$this->is_shg_assign]) ? $array[$this->is_shg_assign] : '';
    }

    public function getBcshgbank() {
        $array = [0 => '', 1 => 'हाँ', 2 => 'नहीं'];
        return isset($array[$this->is_bc_shg_bank]) ? $array[$this->is_bc_shg_bank] : '';
    }

    public function getPfmsmapping() {
        $array = [0 => '', 1 => 'हाँ', 2 => 'नहीं'];
        return isset($array[$this->is_pfms_mapping]) ? $array[$this->is_pfms_mapping] : '';
    }

    public function getSupportfundshg() {
        $array = [0 => '', 1 => 'हाँ', 2 => 'नहीं'];
        return isset($array[$this->is_support_fund_shg]) ? $array[$this->is_support_fund_shg] : '';
    }

    public function getOnboarding() {
        $array = [0 => '', 1 => 'हाँ', 2 => 'नहीं'];
        return isset($array[$this->is_onboarding]) ? $array[$this->is_onboarding] : '';
    }

    public function getHandheldmachine() {
        $array = [0 => '', 1 => 'हाँ', 2 => 'नहीं'];
        return isset($array[$this->is_handheld_machine]) ? $array[$this->is_handheld_machine] : '';
    }

    public function getBcoperational() {
        $array = [0 => '', 1 => 'हाँ', 2 => 'नहीं'];
        return isset($array[$this->is_bc_operational]) ? $array[$this->is_bc_operational] : '';
    }

    public function getBcreceivesupportfund() {
        $array = [0 => '', 1 => 'हाँ', 2 => 'नहीं'];
        return isset($array[$this->is_bc_receive_support_fund]) ? $array[$this->is_bc_receive_support_fund] : '';
    }

    public function getFundsreturnedtoshg() {
        $array = [0 => '', 1 => 'हाँ', 2 => 'नहीं'];
        return isset($array[$this->funds_returned_to_shg]) ? $array[$this->funds_returned_to_shg] : '';
    }

    public function getCon() {
        $array = [0 => '', 1 => 'हाँ', 2 => 'नहीं'];
        return isset($array[$this->confirm]) ? $array[$this->confirm] : '';
    }
}
