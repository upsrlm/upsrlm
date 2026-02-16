<?php

namespace cbo\models\sakhi\form;

use Yii;
use cbo\models\sakhi\RishtaShgMember;


/**
 * This is the model class for table "rishta_shg_member_office_bearers".
 *
 * @property int $id
 * @property int|null $cbo_shg_id
 * @property int|null $cbo_shg_member_id
 * @property int|null $role
 * @property int|null $duration_of_membership
 * @property int|null $bank_account
 * @property int|null $loan_count
 * @property int|null $relative_in_shg
 * @property int|null $no_of_relative
 */
/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */

class DeleteRishtaShgMemberOfficeBearersForm extends \yii\base\Model {

    public $id;
    public $cbo_shg_id;
    public $cbo_shg_member_id;
    public $role;
    public $age;
    public $bank_account;
    public $relative_in_shg;
    public $no_of_relative;
    public $duration_of_membership;
    public $shg_member_office_bearers_model;

    public function __construct($shg_member_office_bearers_model = null) {
        $this->shg_member_office_bearers_model = Yii::createObject([
                    'class' => RishtaShgMember::className()
        ]);
        if ($shg_member_office_bearers_model != null) {
            $this->shg_member_office_bearers_model = $shg_member_office_bearers_model;
            $this->cbo_shg_id = $this->shg_member_office_bearers_model->cbo_shg_id;
            $this->shg_member_office_bearers_model = $shg_member_office_bearers_model;
            $this->role = $this->shg_member_office_bearers_model->role;
            $this->bank_account = $this->shg_member_office_bearers_model->bank_account;
            $this->relative_in_shg = $this->shg_member_office_bearers_model->relative_in_shg;
            $this->no_of_relative = $this->shg_member_office_bearers_model->no_of_relative;
            $this->duration_of_membership = $this->shg_member_office_bearers_model->duration_of_membership;
        }
    }

    public function rules() {
        return [
            [['role','bank_account','duration_of_membership','relative_in_shg'],'required','message'=> "{attribute} खाली नहीं हो सकती।"],
            [['role','bank_account','duration_of_membership','relative_in_shg','no_of_relative','cbo_shg_member_id','cbo_shg_id'],'integer'] ,
            ['no_of_relative', 'integer', 'min' => 0, 'max' => 999]   
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'role' => 'भूमिका',
            'no_of_relative' => 'अगर हाँ, तो कितने',
            'relative_in_shg' => 'क्या समूह में परिवार/ रिश्तेदार',
            'bank_account' => 'क्या बैंक अकाउंट संचालक',
            'duration_of_membership' => 'कितने समय से समूह के सदस्य हैं',
        ];
    }


}
