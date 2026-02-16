<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use Yii;

/**
 * This is the model class for table "dbt_pilot_data_round2".
 *
 * @property int $id
 * @property string|null $name_of_beneficiary
 * @property string|null $dist
 * @property int|null $block_code
 * @property string|null $blocK
 * @property string|null $gp
 * @property string|null $gp_code
 * @property string|null $mobile_no
 * @property string|null $bank
 * @property string|null $scholl_name
 * @property string|null $ac_no
 * @property string|null $amount_remited
 * @property string|null $paymentdate
 * @property string|null $transactionId
 * @property int $status
 */
class DbtPilotDataRound2 extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbt_pilot_data_round2';
    }

    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['block_code', 'status'], 'integer'],
            [['name_of_beneficiary', 'dist', 'blocK', 'gp'], 'string', 'max' => 150],
            [['gp_code'], 'string', 'max' => 7],
            [['mobile_no'], 'string', 'max' => 10],
            [['bank'], 'string', 'max' => 150],
            [['scholl_name'], 'string', 'max' => 255],
            [['ac_no'], 'string', 'max' => 30],
            [['amount_remited'], 'string', 'max' => 14],
            [['paymentdate'], 'string', 'max' => 15],
            [['transactionId'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_of_beneficiary' => 'Name Of Beneficiary',
            'dist' => 'Dist',
            'block_code' => 'Block Code',
            'blocK' => 'Bloc K',
            'gp' => 'Gp',
            'gp_code' => 'Gp Code',
            'mobile_no' => 'Mobile No',
            'bank' => 'Bank',
            'scholl_name' => 'Scholl Name',
            'ac_no' => 'Ac No',
            'amount_remited' => 'Amount Remited',
            'paymentdate' => 'Paymentdate',
            'transactionId' => 'Transaction ID',
            'status' => 'Status',
        ];
    }
}
