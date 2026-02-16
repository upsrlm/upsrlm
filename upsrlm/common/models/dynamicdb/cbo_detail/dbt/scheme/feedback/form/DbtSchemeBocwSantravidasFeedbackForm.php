<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme\feedback\form;

use Yii;
use common\models\dynamicdb\cbo_detail\dbt\scheme\feedback\DbtSchemeBocwSantravidasFeedback;
use yii\web\UploadedFile;
use common\models\base\GenralModel;

/**
 * DbtSchemeBocwSantravidasFeedbackForm the model behind the DbtSchemeBocwSantravidasFeedback
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class DbtSchemeBocwSantravidasFeedbackForm extends \yii\base\Model {

    public $id;
    public $user_id;
    public $ques1;
    public $ques2;
    public $ques3;
    public $ques4;
    public $ques5;
    public $ques6;
    public $ques7;
    public $ques1_option = [];
    public $ques2_option = [];
    public $ques3_option = [];
    public $ques4_option = [];
    public $ques5_option = [];
    public $ques6_option = [];
    public $ques7_option = [];
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $feedback_model;

    public function __construct($user_id) {
        $this->user_id = $user_id;
        $this->feedback_model = DbtSchemeBocwSantravidasFeedback::findOne(['user_id' => $this->user_id]);
        $this->ques1_option = [1 => 'हाँ', 2 => 'नहीं'];
        $this->ques2_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'शायद हो सकते थे'];
        $this->ques3_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'स्पष्ट तौर पता नहीं'];
        $this->ques4_option = [1 => 'हाँ', 2 => 'नहीं'];
        $this->ques5_option = [1 => 'लगभग 25% परिवार', 2 => '25-50% परिवार', 3 => '50-90% परिवार', 4 => '90% से ज़्यादा परिवार'];
        $this->ques6_option = [1 => '15 दिनों में', 2 => 'लगभग एक महीने मैं', 3 => '1 महीने से ज़्यादा समय में'];
        $this->ques7_option = [1 => 'हाँ', 2 => 'नहीं'];
        if ($this->feedback_model == null) {
            $this->feedback_model = new DbtSchemeBocwSantravidasFeedback();
            $this->feedback_model->user_id = $this->user_id;
        } else {
            $this->user_id = $this->feedback_model->user_id;
            $this->ques1 = $this->feedback_model->ques1;
            $this->ques2 = $this->feedback_model->ques2;
            $this->ques3 = $this->feedback_model->ques3;
            $this->ques4 = $this->feedback_model->ques4;
            $this->ques5 = $this->feedback_model->ques5;
            $this->ques6 = $this->feedback_model->ques6;
            $this->ques7 = $this->feedback_model->ques7;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id'], 'required'],
            [['ques1', 'ques2', 'ques3', 'ques4'], 'required', 'message' => 'आवश्यक है'],
            ['ques5', 'required', 'when' => function ($model) {
                    return $model->ques4 == 2;
                }, 'message' => 'आवश्यक है', 'whenClient' => "function (attribute, value) {
                  return $('#ques4').val() == '2';
            }"],
            [['ques6', 'ques7'], 'required', 'message' => 'आवश्यक है'],
            [['user_id', 'ques1', 'ques2', 'ques3', 'ques4', 'ques5', 'ques6', 'ques7', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'ques1' => 'क्या आप इस योजना के लाभ के बारे में जानती हैं?',
            'ques2' => 'क्या आप के परिवार में कोई इस लाभ के लिए पात्र हैं या हो सकते हैं/ कभी हो सकते थे?',
            'ques3' => 'क्या आपके ग्राम पंचायत के स्वयं सहायता समूह के सदस्यों के परिवारों में इस योजना के पात्र व्यक्ति हैं/ या हो सकते हैं ?',
            'ques4' => 'क्या आप या आपके ग्रा0प0 के समूहों के सदस्य परिवार BOCW में पंजीकृत हैं?',
            'ques5' => 'अगर नहीं, तो आपके आँकलन से आपके ग्रा0प0 के स्वयं सहायता समूहों में कितने परिवार इस योजना के पात्र बन सकते हैं?',
            'ques6' => 'अगर मोबाइल ऐप पर ही आवेदन की सुविधा मिले तो आप कितने दिनों में सभी समूह सदस्यों के सभी परिवार का पंजीकरण करवा सकती हैं?',
            'ques7' => 'क्या आप इस योजना के बारे मैं और जानकारी चाहतें है?',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {
        $this->feedback_model = DbtSchemeBocwSantravidasFeedback::findOne(['user_id' => $this->user_id]);
        if ($this->feedback_model == null) {
            $this->feedback_model = new DbtSchemeBocwSantravidasFeedback();
            $this->feedback_model->user_id = $this->user_id;
        }
        $this->feedback_model->user_id = $this->user_id;
        $this->feedback_model->ques1 = $this->ques1;
        $this->feedback_model->ques2 = $this->ques2;
        $this->feedback_model->ques3 = $this->ques3;
        $this->feedback_model->ques4 = $this->ques4;
        if ($this->ques4 == 2) {
            $this->feedback_model->ques5 = $this->ques5;
        }
        $this->feedback_model->ques6 = $this->ques6;
        $this->feedback_model->ques7 = $this->ques7;
        if (!$this->feedback_model->validate()) {
            return false;
        }
        if ($this->feedback_model->save()) {
            return $this;
        }
    }

}
