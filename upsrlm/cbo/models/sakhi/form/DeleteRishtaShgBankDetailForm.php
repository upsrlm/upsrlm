<?php

namespace cbo\models\sakhi\form;

use Yii;
use cbo\models\sakhi\RishtaShgBankDetail;

/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */

class DeleteRishtaShgBankDetailForm extends \yii\base\Model {

    public $id;
    public $cbo_shg_id;
    public $shg_bank_id;
    public $bank_account_no_of_the_shg;
    public $bank_id;
    public $name_of_bank;
    public $branch;
    public $branch_code_or_ifsc;
    public $bank_account;
    public $date_of_opening_the_bank_account;
    public $duration_of_membership;
    public $passbook_file;
    public $bank_balance_date;
    public $balance_as_on_date;
    public $status;
    public $shg_bank_detail_model;

    public function __construct($shg_bank_detail_model = null) {
        $this->shg_bank_detail_model = Yii::createObject([
                    'class' => RishtaShgBankDetail::className()
        ]);
        if ($shg_bank_detail_model != null) {
            $this->shg_bank_detail_model = $shg_bank_detail_model;
            $this->bank_account_no_of_the_shg = $this->shg_bank_detail_model->bank_account_no_of_the_shg;
            $this->bank_id = $this->shg_bank_detail_model->bank_id;
            $this->name_of_bank = $this->shg_bank_detail_model->name_of_bank;
            $this->branch = $this->shg_bank_detail_model->branch;
            $this->branch_code_or_ifsc = $this->shg_bank_detail_model->branch_code_or_ifsc;
            $this->date_of_opening_the_bank_account = $this->shg_bank_detail_model->date_of_opening_the_bank_account;
            $this->bank_balance_date = $this->shg_bank_detail_model->bank_balance_date;
            $this->balance_as_on_date = $this->shg_bank_detail_model->balance_as_on_date;
            $this->status = $this->shg_bank_detail_model->status;
        }
    }

    public function rules() {
        return [
            [['branch','branch_code_or_ifsc','date_of_opening_the_bank_account','bank_id','bank_account_no_of_the_shg','balance_as_on_date'],'required','message'=> "{attribute} खाली नहीं हो सकती।"],
            [['branch'], 'string', 'max' => 150],
            [['branch_code_or_ifsc'], 'string', 'max' => 25],
            [['bank_account_no_of_the_shg','balance_as_on_date','cbo_shg_id','shg_bank_id'],'integer'],
            [['bank_account_no_of_the_shg'], 'string','min'=>9, 'max' => 18],
            [['date_of_opening_the_bank_account','bank_balance_date'],'safe'],
            [['bank_balance_date'], 'date', 'format' => 'php:Y-m-d'],
            [['bank_account_no_of_the_shg'], 'unique', 'when' => function ($model, $attribute) {
                return $this->shg_bank_detail_model->$attribute != $model->$attribute;
            }, 'targetClass' => \cbo\models\sakhi\RishtaShgBankDetail::className(), 'message' => 'This Account Number has already been taken','targetAttribute'=>['bank_account_no_of_the_shg','status']],

         ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'bank_id' => 'बैंक का नाम',
            'name' => 'बैंक का नाम',
            'branch'=>'शाखा का नाम',
            'role' => 'Role',
            'branch_code_or_ifsc' => 'शाखा कोड या IFSC कोड',
            'balance_as_on_date' => 'दिनांक के अनुसार शेष राशि',
            'bank_account_no_of_the_shg'=>'बैंक का खाता संख्या'
        ];
    }


}
