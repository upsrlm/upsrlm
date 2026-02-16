<?php

namespace bc\modules\selection\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcHonorariumPayment;

/**
 * BcPaymentForm is the model behind the BcHonorariumPayment
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BcPaymentDistributionForm extends \yii\base\Model {

    public $file_name;
    public $month;
    public $distribution_date;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $sample_csv_url;
    public $fileid;
    public $bc_payment_model;
    public $rows = [];

    public function rules() {

        return [
            [['month'], 'required'],
            [['distribution_date'], 'required'],
            [['month'], \common\validators\HonorariumMonthValidator::className()],
            [['distribution_date'], \common\validators\HonorariumDistributionDate::className()],
            ['file_name', 'required'],
            [['file_name'], 'file', 'skipOnEmpty' => true, 'extensions' => 'csv','checkExtensionByMimeType' => false, 'wrongExtension' => 'Only CSV file are allowed'],
            //[['file_name'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'month' => 'Month',
            'file_name' => 'Payment CSV file',
            'distribution_date' => 'Distribution Payment Date'
        );
    }

}
