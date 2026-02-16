<?php

namespace bc\modules\training\models\form;

use Yii;
use bc\modules\selection\models\BcPbtFeedback;
use common\models\User;
use yii\web\UploadedFile;
use bc\modules\selection\models\SrlmBcApplication;

/**
 * BCFeedbackForm is the model behind the CboBcFeedback
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BCFeedbackForm extends \yii\base\Model {

    public $id;
    public $bc_application_id;
    public $srlm_bc_selection_user_id;
    public $user_id;
    public $ques_1;
    public $ques_2;
    public $ques_3;
    public $ques_4;
    public $ques_5;
    public $ques_6;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $ques_1_option = [];
    public $ques_2_option = [];
    public $ques_3_option = [];
    public $ques_4_option = [];
    public $ques_5_option = [];
    public $user_model;
    public $bc_feedback_model;
    public $bc_model;

    public function __construct($model) {
        $this->bc_model = $model;
        $this->bc_feedback_model = BcPbtFeedback::findOne(['bc_application_id' => $this->bc_model->id]);
        $this->ques_1_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'थोड़ी बहुत'];
        $this->ques_2_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'थोड़ी बहुत'];
        $this->ques_3_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'थोड़ी बहुत'];
        $this->ques_4_option = [1 => 'बिलकुल जानकारी नहीं मिली है', 2 => 'और जानकारी और स्पष्टता की ज़रूरत है', 3 => 'अच्छी समझ बनी है - ख़तरों से स्वयं निपट सकेंगे'];

        if ($this->bc_feedback_model == null) {
            $this->bc_feedback_model = new BcPbtFeedback();
            $this->bc_feedback_model->user_id = $this->bc_model->user_id;
            $this->user_id = $this->bc_model->user_id;
            $this->bc_application_id = $this->bc_model->id;
            $this->srlm_bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
        } else {
            $this->bc_application_id = $this->bc_feedback_model->bc_application_id;
            $this->srlm_bc_selection_user_id = $this->bc_feedback_model->srlm_bc_selection_user_id;
            $this->user_id = $this->bc_feedback_model->user_id;
            $this->ques_1 = $this->bc_feedback_model->ques_1;
            $this->ques_2 = $this->bc_feedback_model->ques_2;
            $this->ques_3 = $this->bc_feedback_model->ques_3;
            $this->ques_4 = $this->bc_feedback_model->ques_4;
            $this->ques_5 = $this->bc_feedback_model->ques_5;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id'], 'required'],
            [['srlm_bc_selection_user_id'], 'required'],
            [['ques_1'], 'required', 'message' => 'आवश्यक है'],
            [['ques_2'], 'required', 'message' => 'आवश्यक है'],
            [['ques_3'], 'required', 'message' => 'आवश्यक है'],
            [['ques_4'], 'required', 'message' => 'आवश्यक है'],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'user_id', 'ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Application ID',
            'srlm_bc_selection_user_id' => 'Srlm Bc Selection User ID',
            'user_id' => 'User ID',
            'ques_1' => '1. फ़्रॉड कॉल के माध्यम से ऑनलाइन आपके बैंक खाते से पैसे निकाल लेने के ख़तरे',
            'ques_2' => '2. ऐंटी मनी लॉंडरिंग (AML)/ ग़लत तरीक़े से ऑनलाइन पैसे के लेनदेन से जुड़े विषय ',
            'ques_3' => '3. नक़ली मुद्रा/ नोट के ख़तरे - उनके व्यवहार एवं पहचान करने के तरीक़े ताकि उनसे बचा जा सके ।',
            'ques_4' => '4.क्या आपको सभी विषय एवं उनसे सम्बंधित सावधानियों के बारे समझ मिली?',
            'ques_5' => 'Ques 5',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {
        $this->bc_feedback_model->bc_application_id = $this->bc_application_id;
        $this->bc_feedback_model->srlm_bc_selection_user_id = $this->srlm_bc_selection_user_id;
        $this->bc_feedback_model->user_id = $this->user_id;
        $this->bc_feedback_model->ques_1 = $this->ques_1;
        $this->bc_feedback_model->ques_2 = $this->ques_2;
        $this->bc_feedback_model->ques_3 = $this->ques_3;
        $this->bc_feedback_model->ques_4 = $this->ques_4;

        if ($this->bc_feedback_model->save()) {
            $this->bc_model->training_feedback = 1;
            $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_PBANK_TRAINING_FEEDBACK;
            $this->bc_model->save();
            return $this;
        } else {
            return false;
        }
        return $this;
    }

}
