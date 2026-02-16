<?php

namespace cbo\models\sakhi\form;

use Yii;
use cbo\models\sakhi\RishtaShgFundReceived;

/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */

class DeleteRishtaShgFundReceivedForm extends \yii\base\Model {

    public $id;
    public $fund_type;
    public $received_from;
    public $date_of_receipt;
    public $amount_received;
    public $status;
    public $cbo_shg_id;
    public $shg_fund_received_id;
    public $action_url;
    public $action_validate_url;
    public $shg_fund_received_model;

    public function __construct($shg_fund_received_model = null) {
        $this->shg_fund_received_model = Yii::createObject([
                    'class' => RishtaShgFundReceived::className()
        ]);
        if ($shg_fund_received_model != null) {
            $this->shg_fund_received_model = $shg_fund_received_model;
            $this->cbo_shg_id = $this->shg_fund_received_model->cbo_shg_id;
            $this->fund_type = $this->shg_fund_received_model->fund_type;
            $this->received_from = $this->shg_fund_received_model->received_from;
            $this->date_of_receipt = $this->shg_fund_received_model->date_of_receipt;
            $this->amount_received = $this->shg_fund_received_model->amount_received;
            $this->status = $this->shg_fund_received_model->status;
        }
    }

    public function rules() {
        return [
            [['fund_type','received_from','date_of_receipt','amount_received'],'required','message'=> "{attribute} खाली नहीं हो सकती।"],
            [['received_from','fund_type','cbo_shg_id'],'integer'],
            [['amount_received'],'number','max'=>100000000],
            [['date_of_receipt','shg_fund_received_id'],'safe'],
            [['date_of_receipt'], 'date', 'format' => 'php:Y-m-d']
         ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'fund_type' => 'Fund Type',
            'received_from' => 'से प्राप्त किया',
            'date_of_receipt' => 'प्राप्ति की तारीख',
            'amount_received' => 'रकम प्राप्त',
        ];
    }


}
