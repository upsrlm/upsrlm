<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_tracking_feedback".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property int|null $srlm_bc_selection_user_id
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $master_partner_bank_id
 * @property int|null $user_id
 * @property int $ques_1
 * @property int $ques_2
 * @property int $ques_3
 * @property int $ques_4
 * @property int $ques_5
 * @property int $ques_6
 * @property int $ques_7
 * @property int $ques_8
 * @property int $ques_9
 * @property int $ques_10
 * @property int $ques_11
 * @property int $ques_12
 * @property int $ques_13
 * @property int $ques_14
 * @property int $ques_15
 * @property int $ques_16
 * @property int $ques_17
 * @property int $ques_18
 * @property int $ques_19
 * @property int $ques_20
 * @property int $handheld_device
 * @property int $handheld_device_ques_1
 * @property int $handheld_device_ques_2
 * @property int $handheld_device_ques_3
 * @property int $handheld_device_ques_4
 * @property int $handheld_device_ques_5
 * @property int $fraud_transaction
 * @property int $fraud_transaction_ques_1
 * @property int $fraud_transaction_ques_2
 * @property int $fraud_transaction_ques_3
 * @property int $fraud_transaction_ques_4
 * @property int $problems_with_bank
 * @property int $problems_with_bank_ques_1
 * @property int $problems_with_bank_ques_2
 * @property int $bc_commissions_payment
 * @property int $bc_commissions_payment_ques_1
 * @property int $bc_commissions_payment_ques_2
 * @property int $bc_commissions_payment_ques_3
 * @property int $section
 * @property int|null $feedback_by
 * @property string|null $feedback_date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcTrackingFeedback extends BcactiveRecord {

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
        return 'bc_tracking_feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'user_id', 'ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5', 'ques_6', 'ques_7', 'ques_8', 'ques_9', 'ques_10', 'ques_11', 'ques_12', 'ques_13', 'ques_14', 'ques_15', 'ques_16', 'ques_17', 'ques_18', 'ques_19', 'ques_20', 'section', 'feedback_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['handheld_device', 'handheld_device_ques_1', 'handheld_device_ques_2', 'handheld_device_ques_3', 'handheld_device_ques_4', 'handheld_device_ques_5', 'fraud_transaction', 'fraud_transaction_ques_1', 'fraud_transaction_ques_2', 'fraud_transaction_ques_3', 'fraud_transaction_ques_4', 'problems_with_bank', 'problems_with_bank_ques_1', 'problems_with_bank_ques_2', 'bc_commissions_payment', 'bc_commissions_payment_ques_1', 'bc_commissions_payment_ques_2', 'bc_commissions_payment_ques_3'], 'integer'],
            [['feedback_date'], 'safe'],
            [['bc_application_id'], 'unique'],
            [['handheld_device'], 'default', 'value' => 0],
            [['fraud_transaction'], 'default', 'value' => 0],
            [['problems_with_bank'], 'default', 'value' => 0],
            [['bc_commissions_payment'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'BC Sakhi',
            'srlm_bc_selection_user_id' => 'Srlm Bc Selection User ID',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'GP',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'user_id' => 'User ID',
            'ques_1' => 'Ques 1',
            'ques_2' => 'Ques 2',
            'ques_3' => 'Ques 3',
            'ques_4' => 'Ques 4',
            'ques_5' => 'Ques 5',
            'ques_6' => 'Ques 6',
            'ques_7' => 'Ques 7',
            'ques_8' => 'Ques 8',
            'ques_9' => 'Ques 9',
            'ques_10' => 'Ques 10',
            'ques_11' => 'Ques 11',
            'ques_12' => 'Ques 12',
            'ques_13' => 'Ques 13',
            'ques_14' => 'Ques 14',
            'ques_15' => 'Ques 15',
            'ques_16' => 'Ques 16',
            'ques_17' => 'Ques 17',
            'ques_18' => 'Ques 18',
            'ques_19' => 'Ques 19',
            'ques_20' => 'Ques 20',
            'handheld_device' => 'हैंडहेल्ड मशीन से सम्बंधित कोई समस्या',
            'handheld_device_ques_1' => 'मशीन गर्म हो जाता है',
            'handheld_device_ques_2' => 'बैटरी की समस्या है / बैकअप नहीं है ',
            'handheld_device_ques_3' => 'ब्लूटूथ की समस्या है ',
            'handheld_device_ques_4' => 'फिंगर प्रिंट स्कैनर काम नहीं केर रहा है ',
            'handheld_device_ques_5' => 'मशीन ख़राब होने ओर बफर स्टैक से तत्काल बदला नहीं गया है , देरी हो रही है',
            'fraud_transaction' => 'फ्रॉड ट्रांसक्शन से  सम्बंधित कोई समस्या',
            'fraud_transaction_ques_1' => 'फ्रॉड कॉल आया है/ था',
            'fraud_transaction_ques_2' => 'फ्रॉड कॉल और फ्रॉड ट्रांसक्शन घटित हुआ है ( तत्काल रपोट करे  )',
            'fraud_transaction_ques_3' => 'पार्टनर बैंक के अन्दुरुनी स्टॉक का फ्रॉड में लिप्त होना ( कॉल सेंटर पैर भी रिपोर्ट करे )',
            'fraud_transaction_ques_4' => 'फ्रॉड कॉल के विषय में समय से कारवाही संपन्न नहीं हुआ है / देरी हो रही है (पुलिस/ बीमा/ बैंक )',
            'problems_with_bank' => 'बैंक से सम्बंधित कोई समस्या',
            'problems_with_bank_ques_1' => 'कैश देने में आनाकानी / देर करना',
            'problems_with_bank_ques_2' => 'कैश के लेन देन में लम्बी लाइन में लगना पड़ता है',
            'bc_commissions_payment' => 'BC  सखी के कमीशन पेमेंट भुगतान से सम्बंधित कोई समस्या ',
            'bc_commissions_payment_ques_1' => 'सही समय पर कमीशन पेमेंट नहीं हुआ है ',
            'bc_commissions_payment_ques_2' => 'कमीशन में अन्यावश्यक कटौती हुआ है  ',
            'bc_commissions_payment_ques_3' => 'कमीशन बैंक के बताये नियम / फार्मूला के अनुरूप नहीं हुआ है',
            'section' => 'Section',
            'feedback_by' => 'Feedback By',
            'feedback_date' => 'Feedback Date',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getQues1a() {
        $array = [];
        $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_bc_sakhi_option();
        foreach ($ques_option as $key => $value) {
            $name = 'ques_' . $key;
            if ($this->$name == 1) {
                array_push($array, $key);
            }
        }
        return $array;
    }

    public function getQues2a() {
        $array = [];
        $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_partner_bank_option();
        foreach ($ques_option as $key => $value) {
            $name = 'ques_' . $key;
            if ($this->$name == 1) {
                array_push($array, $key);
            }
        }
        return $array;
    }

    public function getQues3a() {
        $array = [];
        $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_bank_option();
        foreach ($ques_option as $key => $value) {
            $name = 'ques_' . $key;
            if ($this->$name == 1) {
                array_push($array, $key);
            }
        }
        return $array;
    }

    public function getQues4a() {
        $array = [];
        $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_awareness_gap_option();
        foreach ($ques_option as $key => $value) {
            $name = 'ques_' . $key;
            if ($this->$name == 1) {
                array_push($array, $key);
            }
        }
        return $array;
    }

    public function getQues5a() {
        $array = [];
        $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_operational_issues_option();
        foreach ($ques_option as $key => $value) {
            $name = 'ques_' . $key;
            if ($this->$name == 1) {
                array_push($array, $key);
            }
        }
        return $array;
    }

    public function getQues1html() {
        $html = "<h3>BC Sakhi</h3>";
        if (isset($this->ques1a)) {
            $html .= '<ul class="nav">';
            $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_bc_sakhi_option();
            foreach ($ques_option as $key => $value) {
                $name = 'ques_' . $key;
                if ($this->$name == 1) {
                    $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $value . '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getQues2html() {
        $html = "<h3>Partner bank</h3>";
        if (isset($this->ques2a)) {
            $html .= '<ul class="nav">';
            $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_partner_bank_option();
            foreach ($ques_option as $key => $value) {
                $name = 'ques_' . $key;
                if ($this->$name == 1) {
                    $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $value . '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getQues3html() {
        $html = "<h3>Bank</h3>";
        if (isset($this->ques3a)) {
            $html .= '<ul class="nav">';
            $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_bank_option();
            foreach ($ques_option as $key => $value) {
                $name = 'ques_' . $key;
                if ($this->$name == 1) {
                    $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $value . '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getQues4html() {
        $html = "<h3>Awareness gap</h3>";
        if (isset($this->ques4a)) {
            $html .= '<ul class="nav">';
            $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_awareness_gap_option();
            foreach ($ques_option as $key => $value) {
                $name = 'ques_' . $key;
                if ($this->$name == 1) {
                    $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $value . '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getQues5html() {
        $html = "<h3>Operational issues</h3>";
        if (isset($this->ques5a)) {
            $html .= '<ul class="nav">';
            $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_operational_issues_option();
            foreach ($ques_option as $key => $value) {
                $name = 'ques_' . $key;
                if ($this->$name == 1) {
                    $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $value . '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getQues1htmls() {
        $html = "";
        if (isset($this->ques1a)) {
            $html .= '<ul class="nav">';
            $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_bc_sakhi_option();
            foreach ($ques_option as $key => $value) {
                $name = 'ques_' . $key;
                if ($this->$name == 1) {
                    $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $value . '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getQues2htmls() {
        $html = "";
        if (isset($this->ques2a)) {
            $html .= '<ul class="nav">';
            $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_partner_bank_option();
            foreach ($ques_option as $key => $value) {
                $name = 'ques_' . $key;
                if ($this->$name == 1) {
                    $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $value . '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getQues3htmls() {
        $html = "";
        if (isset($this->ques3a)) {
            $html .= '<ul class="nav">';
            $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_bank_option();
            foreach ($ques_option as $key => $value) {
                $name = 'ques_' . $key;
                if ($this->$name == 1) {
                    $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $value . '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getQues4htmls() {
        $html = "";
        if (isset($this->ques4a)) {
            $html .= '<ul class="nav">';
            $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_awareness_gap_option();
            foreach ($ques_option as $key => $value) {
                $name = 'ques_' . $key;
                if ($this->$name == 1) {
                    $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $value . '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getQues5htmls() {
        $html = "";
        if (isset($this->ques5a)) {
            $html .= '<ul class="nav">';
            $ques_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_operational_issues_option();
            foreach ($ques_option as $key => $value) {
                $name = 'ques_' . $key;
                if ($this->$name == 1) {
                    $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $value . '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getHdhtmls() {
        $html = "";
        if ($this->handheld_device_ques_1 == 1 or $this->handheld_device_ques_2 == 1 or $this->handheld_device_ques_3 == 1 or $this->handheld_device_ques_4 == 1 or $this->handheld_device_ques_5 == 1) {
            $html .= '<ul class="nav">';

            if ($this->handheld_device_ques_1 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> मशीन गर्म हो जाता है </li>';
            }
            if ($this->handheld_device_ques_2 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> बैटरी की समस्या है / बैकअप नहीं है </li>';
            }
            if ($this->handheld_device_ques_3 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ब्लूटूथ की समस्या है</li>';
            }
            if ($this->handheld_device_ques_4 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i>फिंगर प्रिंट स्कैनर काम नहीं केर रहा है </li>';
            }
            if ($this->handheld_device_ques_5 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i>मशीन ख़राब होने ओर बफर स्टैक से तत्काल बदला नहीं गया है , देरी हो रही है </li>';
            }
          
            
            $html .= '</ul>';
        }
        return $html;
    }
    public function getFthtmls() {
        $html = "";
        if ($this->fraud_transaction_ques_1 == 1 or $this->fraud_transaction_ques_2 == 1 or $this->fraud_transaction_ques_3 == 1 or $this->fraud_transaction_ques_4 == 1) {
            $html .= '<ul class="nav">';
            if ($this->fraud_transaction_ques_1 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> फ्रॉड कॉल आया है/ था </li>';
            }
            if ($this->fraud_transaction_ques_2 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> फ्रॉड कॉल और फ्रॉड ट्रांसक्शन घटित हुआ है </li>';
            }
            if ($this->fraud_transaction_ques_3 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> पार्टनर बैंक के अन्दुरुनी स्टॉक का फ्रॉड में लिप्त होना </li>';
            }
            if ($this->fraud_transaction_ques_4 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> फ्रॉड कॉल के विषय में समय से कारवाही संपन्न नहीं हुआ है / देरी हो रही है (पुलिस/ बीमा/ बैंक ) </li>';
            }          
            $html .= '</ul>';
        }
        return $html;
    }
    public function getPwbhtmls() {
        $html = "";
        if ($this->problems_with_bank_ques_1 == 1 or $this->problems_with_bank_ques_2 == 1) {
            $html .= '<ul class="nav">';
            if ($this->problems_with_bank_ques_1 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> कैश देने में आनाकानी / देर करना </li>';
            }
            if ($this->problems_with_bank_ques_2 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> कैश के लेन देन में लम्बी लाइन में लगना पड़ता है </li>';
            }
                  
            $html .= '</ul>';
        }
        return $html;
    }
    public function getPcbhtmls() {
        $html = "";
        if ($this->bc_commissions_payment_ques_1 == 1 or $this->bc_commissions_payment_ques_2 == 1 or $this->bc_commissions_payment_ques_3 == 1) {
            $html .= '<ul class="nav">';
            if ($this->bc_commissions_payment_ques_1 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> सही समय पर कमीशन पेमेंट नहीं हुआ है </li>';
            }
            if ($this->bc_commissions_payment_ques_2 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> कमीशन में अन्यावश्यक कटौती हुआ है </li>';
            }
            if ($this->bc_commissions_payment_ques_3 == 1) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> कमीशन बैंक के बताये नियम / फार्मूला के अनुरूप नहीं हुआ है </li>';
            }
                    
            $html .= '</ul>';
        }
        return $html;
    }
    public function getBc() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }

    public function getDistrict() {
        return $this->hasOne(\bc\models\master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(\bc\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getGp() {
        return $this->hasOne(\bc\models\master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getPbank() {
        return $this->hasOne(\bc\models\master\MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }

    public function getHd() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->handheld_device]) ? $ques_option[$this->handheld_device] : '';
    }

    public function getHdq1() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->handheld_device_ques_1]) ? $ques_option[$this->handheld_device_ques_1] : '';
    }

    public function getHdq2() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->handheld_device_ques_2]) ? $ques_option[$this->handheld_device_ques_2] : '';
    }

    public function getHdq3() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->handheld_device_ques_3]) ? $ques_option[$this->handheld_device_ques_3] : '';
    }

    public function getHdq4() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->handheld_device_ques_4]) ? $ques_option[$this->handheld_device_ques_4] : '';
    }

    public function getHdq5() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->handheld_device_ques_5]) ? $ques_option[$this->handheld_device_ques_5] : '';
    }

    public function getFt() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->fraud_transaction]) ? $ques_option[$this->fraud_transaction] : '';
    }

    public function getFtq1() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->fraud_transaction_ques_1]) ? $ques_option[$this->fraud_transaction_ques_1] : '';
    }

    public function getFtq2() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->fraud_transaction_ques_2]) ? $ques_option[$this->fraud_transaction_ques_2] : '';
    }

    public function getFtq3() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->fraud_transaction_ques_3]) ? $ques_option[$this->fraud_transaction_ques_3] : '';
    }

    public function getFtq4() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->fraud_transaction_ques_4]) ? $ques_option[$this->fraud_transaction_ques_4] : '';
    }

    public function getPwb() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->problems_with_bank]) ? $ques_option[$this->problems_with_bank] : '';
    }

    public function getPwbq1() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->problems_with_bank_ques_1]) ? $ques_option[$this->problems_with_bank_ques_1] : '';
    }

    public function getPwbq2() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->problems_with_bank_ques_2]) ? $ques_option[$this->problems_with_bank_ques_2] : '';
    }

    public function getBcp() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->bc_commissions_payment]) ? $ques_option[$this->bc_commissions_payment] : '';
    }

    public function getBcpq1() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->bc_commissions_payment_ques_1]) ? $ques_option[$this->bc_commissions_payment_ques_1] : '';
    }

    public function getBcpq2() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->bc_commissions_payment_ques_2]) ? $ques_option[$this->bc_commissions_payment_ques_2] : '';
    }

    public function getBcpq3() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं'];
        return isset($ques_option[$this->bc_commissions_payment_ques_3]) ? $ques_option[$this->bc_commissions_payment_ques_3] : '';
    }
}
