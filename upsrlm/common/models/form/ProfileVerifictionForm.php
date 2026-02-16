<?php

namespace common\models\form;

use Yii;
use common\models\User;
use common\models\UserProfile;
use common\models\base\GenralModel;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\Expression;

/**
 * ProfileVerifictionForm is the model behind the UserProfile
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ProfileVerifictionForm extends Model {

    public $id;
    public $user_id;
    public $verification_status;
    public $verification_status1;
    public $verification_status2;
    public $verification_status3;
    public $verification_status4;
    public $verification_status5;
    public $verification_by;
    public $verification_datetime;
    public $comment;
    public $user_model;
    public $profle_model;
    public $state_option = [];
    public $district_option = [];
    public $option = [];
    public $verification_status_option = [];

    public function __construct($user_id) {
        $this->user_model = User::findOne($user_id);
        $this->user_id = $this->user_model->id;
        $this->option = [1 => 'हाँ', 0 => 'नहीं'];
        $this->profle_model = UserProfile::findOne(['user_id' => $user_id]);
        $this->verification_status_option = [1 => 'Verify', 2 => 'Reject'];
        if ($this->profle_model != null) {
            $this->verification_status1 = $this->profle_model->verification_status1;
            $this->verification_status2 = $this->profle_model->verification_status2;
            $this->verification_status3 = $this->profle_model->verification_status3;
            $this->verification_status4 = $this->profle_model->verification_status4;
            $this->verification_status5 = $this->profle_model->verification_status5;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // [['user_id', 'verification_status'], 'required'],
            [['user_id', 'verification_status1', 'verification_status2', 'verification_status3', 'verification_status4', 'verification_status5'], 'required'],
            [['verification_status', 'verification_by'], 'integer'],
            [['verification_datetime'], 'safe'],
            
            [['comment'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'verification_status' => 'Verification Status',
            'verification_status1' => 'क्या BMM/DMM/SMM नियत स्थान पर कार्यरत हैं ?',
            'verification_status2' => 'BMM/DMM/ SMM के नाम, स्थायी व वर्तमान पता, फ़ोन नम्बर, ईमेल इत्यादि सही हैं',
            'verification_status3' => 'उनका प्रोफ़ायल फ़ोटो पुराना/किसी और दस्तावेज या फ़ोटो से ली गयी फ़ोटो नहीं है। रीसेंट फ़ोटो है।',
            'verification_status4' => 'सभी ज़रूरी दस्तावेज पूर्ण रूप से संलग्न हैं ऑफर लेटर, सर्विस अग्रीमेंट एवं पोस्टिंग ऑर्डर इत्यादि',
            'verification_status5' => 'उनके स्वयं के प्रोफ़ायल स्टेटमेंट सही एवं पूर्ण हैं।',
            'comment' => 'Comment',
            'verification_by' => 'Verification By',
            'verification_datetime' => 'Verification Datetime',
        ];
    }

}
