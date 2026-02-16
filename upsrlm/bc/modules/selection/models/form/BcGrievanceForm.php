<?php

namespace bc\modules\selection\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcProvidedSaree;
use yii\db\Expression;
use common\helpers\FileHelpers;

/**
 * BcGrievanceForm is the model behind the BcProvidedSaree
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BcGrievanceForm extends \yii\base\Model {

    public $id;
    public $bc_application_id;
    public $srlm_bc_selection_user_id;
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;
    public $title;
    public $group;
    public $machine_work;
    public $machine_problem;
    public $machine_problem_99_text;
    public $fraud_transaction;
    public $bank_problem;
    public $bc_commissions_payment;
    public $any_other_problem;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $bc_model;
    public $bc_saree_model;
    public $machine_work_option = [1 => 'हां', 2 => 'नहीं'];
    public $machine_problem_option = [1 => 'मशीन गर्म हो जाती है', 2 => 'बैटरी की समस्या है/ बैक-अप नहीं है;', 3 => 'ब्लूटूथ की समस्या है', 4 => 'फिंगरप्रिंट स्कैनर काम नहीं कर रहा है', 5 => 'मशीन ख़राब होने पर बफर स्टॉक से तत्काल बदला नहीं गया है; देरी हो रही है;', 99 => 'कोई अन्य समस्या'];
    public $group_option = [];
    public $fraud_transaction_option = [1 => "फ्रॉड कॉल आया है/ था", 2 => "फ्रॉड कॉल व फ्रॉड ट्रांज़ैक्शन घटित हुआ है", 3 => "पार्टनर बैंक के अंदुरनी स्टाफ का लिप्त होना ", 4 => "फ्रॉड कॉल के विषय मे विषय मे समय से कार्रवाई सम्पन नहीं हुआ है / देरी हो रही है (पुलिस /बीमा /बैंक )"];
    public $bank_problem_option = [1 => 'कैश देने मे आनाकानी/ देर करना;', 2 => 'कैश के लेनदेन मm लंबी लाइन मे लगना पढ़ता है '];
    public $bc_commissions_payment_option = [1 => "सही समय से कमीशन पेमेन्ट नही हुआ है ", 2 => 'कमीशन मे अनावस्यक कटौती हुआ है', 3 => "कमीशन बैंक के बताये नियम / फार्मूला के अनुरूप नहीं हुआ है"];

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->bc_application_id = $this->bc_model->id;
        $this->srlm_bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
        $this->district_code = $this->bc_model->district_code;
        $this->block_code = $this->bc_model->block_code;
        $this->gram_panchayat_code = $this->bc_model->gram_panchayat_code;
        $this->group_option = \common\models\base\GenralModel::bc_grievance_group();
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id'], 'required'],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'group', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['machine_work'], 'required', 'on' => ['1'], 'message' => "{attribute} चयन कीजिए।"],
            ['machine_problem', 'required', 'on' => ['1'], 'when' => function ($model) {
                    return $model->machine_work == 2;
                }, 'message' => "{attribute} चयन कीजिए।", 'whenClient' => "function (attribute, value) {
                  return $('#machine_work').val() == '2' && $('#group').val() == '1';
            }"],
            [['fraud_transaction'], 'required', 'on' => ['2'], 'message' => "{attribute} चयन कीजिए।"],
            [['bank_problem'], 'required', 'on' => ['3'], 'message' => "{attribute} चयन कीजिए।"],
            [['bc_commissions_payment'], 'required', 'on' => ['4'], 'message' => "{attribute} चयन कीजिए।"],
            [['any_other_problem'], 'required', 'on' => ['5'], 'message' => "{attribute} आवश्यक"],
            [['any_other_problem'], 'trim'],
            [['machine_problem_99_text'], 'trim']              
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Name',
            'srlm_bc_selection_user_id' => 'Selection User ID',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'machine_work' => 'क्या आपकी मशीन सही काम कर रही है?',
            'machine_problem' => "अगर नहीं तो 'क्या समस्या आती है",
            'machine_problem_99_text' => "कोई अन्य समस्या",
            'fraud_transaction' => 'फ्रॉड ट्रांज़ैक्शन से सम्बंदित',
            'bank_problem' => 'बैंक से संबंधित',
            'bc_commissions_payment' => 'बैंक से संबंधित',
            'any_other_problem'=>'कोई अन्य समस्या',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {

        return $this->bc_model;
    }

}
