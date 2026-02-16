<?php

namespace common\models\form;

use yii;
use common\models\User;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\Expression;

/**
 * RishtaChangePinForm gets user's 
 *
 * @property User $user
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class RishtaChangePinForm extends Model {

    /** @var string */
    public $new_pin;
    public $userid;
    public $re_pin;
    public $current_pin;
    public $old_pin;
    public $user;
    public static $pinRegexp = '"^\d{4}$"';

    /** @inheritdoc */
    public function __construct($user) {
        $this->user = $user;
        $this->old_pin=$this->user->otp_value;
    }

    /** @inheritdoc */
    public function rules() {
        return [
            [['new_pin', 're_pin','current_pin'], 'required'],
            [['old_pin'],'safe'],
            ['new_pin', 'match', 'pattern' => static::$pinRegexp, 'message' => "{attribute} अमान्य ।"],
            ['re_pin', 'compare', 'compareAttribute' => 'new_pin', 'message' => "पिन मेल नहीं खाता"],
            ['current_pin', 'compare', 'compareAttribute' => 'old_pin', 'message' => "वर्तमान पिन मान्य नहीं है"],
            
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'new_pin' => 'नया पिन',
            're_pin' => 'फिर से पिन',
            'current_pin'=>'वर्तमान पिन'
        ];
    }

    /** @inheritdoc */
    public function formName() {
        return 'rest-pin-form';
    }

}
